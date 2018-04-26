<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\NewsComment;
class News extends Model
{
    public function collection(){

        return $this->hasMany('App\Models\NewsCollection','nid','id');
    }

    public function comment(){

        return $this->hasMany('App\Models\NewsComment','nid','id');
    }

    public function category(){
        return $this->belongsTo('App\Models\NewsCategory','cid','id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function author_info(){
        return $this->belongsTo('App\Models\Author','uid','uid');
    }

    public function getNewsList($skip,$limit,$opt){
        if (!$limit){
            return [];
        }
        $newsLists = News::where('status',1)->select('id','title','author','origin','image','brief','cid','uid','updated_at','created_at');
        if (!empty($opt['uid'])){//指定了作者id
            $newsLists = $newsLists->where('uid',$opt['uid']);
        }
        if (!empty($opt['author'])){//指定了作者类型
            $newsLists = $newsLists->where('author',$opt['author']);
        }
        if (!empty($opt['cid'])) {
            $newsLists = $newsLists->where('cid',$opt['cid']);
        }
        if (!empty($opt['ucid'])) {
            $newsLists = $newsLists->where('ucid',$opt['ucid']);
        }
        $newsLists = $newsLists->orderBy('updated_at','desc')->orderBy('id','desc')->skip($skip)->limit($limit)->get();
        foreach ($newsLists as $key=>$news){
            if (!empty($opt['is_collected'])){              
                $newsLists[$key]->is_collected = $this->is_collected($news->id,$opt['is_collected']);
            }
            $newsLists[$key]->time = isset($news->updated_at)?$news->updated_at->diffForHumans():'';
            $newsLists[$key]->category_name = isset($news->category)?$news->category->cname:'';
            $newsLists[$key]->user_name = name_filter($news->user->username);
            unset($news->user);
            unset($news->category);
            unset($news->collection);
        }
        return $newsLists;
    }

    public function addTop($id){

        DB::table('News')->where('id',$id)->increment('top');
    }

    public function getView($id){//获取浏览量

        $obj = News::find($id);

        return $obj->f_view;
    }

    public function getComment($id){//获取评论数量

        $obj = News::where('id',$id)->first();

        $comment = $obj->comment->where('status',1)->count();

        return $comment;

    }

    public function getCollection($id){//获取收藏数量

        $obj = News::where('id',$id)->first();

        $collection = $obj->collection->where('status',1)->count();

        return $collection;
    }

    public function is_collected($nid,$uid){

        $is_collected = DB::table('news_collection')->where('uid',$uid)->where('nid',$nid)->where('status',1)->count();

        return $is_collected;
    }

    public function add_collection($nid,$uid){

        $collection = DB::table('news_collection')->where('uid',$uid)->where('nid',$nid)->first();

        if ($collection){
            if ($collection->status){
                $collection = DB::table('news_collection')->where('uid',$uid)->where('nid',$nid)->update(['status'=>0]);
            }else{
                $collection = DB::table('news_collection')->where('uid',$uid)->where('nid',$nid)->update(['status'=>1]);
            }
        }else{
            $collection = DB::table('news_collection')->insert(['uid'=>$uid,'nid'=>$nid,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }

        if (!$collection){
            return ['code'=>0,'msg'=>'update status fail'];
        }

        return ['code'=>1,'msg'=>'update status success'];
    }

    public function getDetails($nid,$uid,$limit){//获取资讯详情页信息   $uid不是作者的id是当前登录用户的id
        //这里的limit是指作者最近发布的文章
        $news = News::whereIn('status',[0,1])->where('id',$nid)->select('id','uid','cid','title','origin','author','image','keywords','brief','content','created_at','updated_at','top','locked','byself')->first();

        if (!$news){
            return '';
        }

        if ($uid){
            $auth_obj = new Author();
            $news->is_collected = $this->is_collected($news->id,$uid);//用户收藏该文章状态
            $news->is_attention = $auth_obj->is_attention($news->uid,$uid);//用户关注该文章作者状态
        }

        $news->collection =  $this->getCollection($nid);       

        $news->comment = $this->getComment($nid);     

        $news->author_brief = $news->user->brief;

        $news->author_image = $news->user->image;

        $news->author_signature = $news->user->signature;

        $news->author_sign_url = $news->user->sign_url;

        $news->author_username = name_filter($news->user->username);
 
        $news->author_desc = $news->user->desc;

        $news->next_news = $this->getNextNews($news->id);

/*        dd($news->next_news->toArray());*/

        $author_news = News::where('status',1)->where('uid',$news->uid);

        $news->author_news = $author_news->select('id','title','created_at','updated_at','cid')->limit($limit)->get();

        foreach ($news->author_news as $key=>$new){
            $news->author_news[$key]->category_name = $new->category->cname;
            unset($new->category);
        }

        $news->view = $this->getView($news->id);

        $news->author_count = $author_news->count();

        $news->comment_list = NewsComment::getCommentList($news->id);

        unset($news->user);

/*        if (!intval($news->status) && $news->uid != $uid){
            $news = '';
        }
*/
        return $news;
    }

    public function getNextNews($id){//目前在看文章的 发布时间

        $next_news = News::where('status',1)
                    ->where('id','<',$id)
                    ->orderBy('id','desc')
                    ->select('id','title','cid','updated_at')
                    ->first();

        if (isset($next_news)) {
            
            $next_news->cname = isset($next_news->category)?$next_news->category->cname:'';

            $next_news->time = isset($next_news->updated_at)?$next_news->updated_at->diffForHumans():'';

            unset($next_news->category);

        }

        return $next_news;
    }

    public function getRelateNews($nid,$keyword_limit,$new_limit){//获取相关的文章  从关键字关联一部分 从最新发布的文章取一部分
//$keyword是指取关键字搜出的文章个数   $new是取最新发布的文章的个数
        $news = News::where('id',$nid)->first();

        if (!$news){
            return [];
        }

        $keywords = $news->keywords;

        $keyword_news = News::where('status',1)
                        ->where('id','<>',$nid)
                        ->where('keywords',$keywords)
                        ->select('id','title')
                        ->limit($keyword_limit)
                        ->get();

        $occupy_id = [$nid];
//排除已筛选过关键字的id
        if ($keyword_news){

            $keywords_news_id = $keyword_news->pluck('id');

            $keywords_news_id->all();

            $occupy_id = array_merge($keywords_news_id->toArray(),$occupy_id);

        }

        $new_news = News::where('status',1)
                    ->whereNotIn('id', $occupy_id)
                    ->latest()
                    ->select('id','title')
                    ->limit($new_limit)
                    ->get();

        $relate_news = array_merge($keyword_news->toArray(),$new_news->toArray());

        return $relate_news;

    }
    
    static function getNews($skip,$limit,$opt=array(),$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = News::orderBy('id', 'desc');
        if (!empty($opt)){
            foreach ($opt as $k => $v){
                if(is_array($v) && $v[1]){
                    $query = $query->where($k,$v[0],$v[1]);
                }elseif(!is_array($v) && $v){
                    $query = $query->where($k,$v);
                }
            }
        }
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }
        $obj = $query->skip($skip)->limit($limit)->get();
        return $obj;
    }

    static function getNewsCount($statusSign,$status){

        $count = News::where('status',$statusSign,$status)->count();

        return $count;
    }
    static function createCreation($creation,$type){// $type  1是保存  2发布
        $news_obj = new News();
        if ($type != 3){ //如果文章已经存在则更新，否则就新建一个文章
            $news = News::where('id',$creation['nid'])->first();
            if (!empty($news)){
                $news_obj = $news;
            }
        }
        unset($creation['nid']);
        foreach ($creation as $key=>$value){
            if ($key=='ucid'&&$news_obj->ucid) {
                continue;
            }
            $news_obj->$key = $value;
        }
        if ($type == 1||$type == 3){
            $news_obj->status = -3;
        }elseif ($type == 2){
            if (empty($news_obj->cid)){
                return ['code'=>0,'msg'=>'请选择一个分类'];
            }
            $news_obj->status = 0;
        }else{
            return ['code'=>0,'msg'=>'状态错误'];
        }

        $news_obj->save();

        return ['code'=>1,'msg'=>'创建或发布成功','id'=>$news_obj->id];
    }


    static function getContent($id){

        $content = News::where('id',$id)->first();

        return ['image'=>$content->image,'content'=>$content->content,'title'=>$content->title,'ucid'=>$content->ucid];

    }

    static function deleteCreation($uid,$nid){// 删除创作

        $news = News::where('uid',$uid)->where('id',$nid)->first();

        if (empty($news)){
            return ['code'=>0,'msg'=>'news and user dismatch'];
        }

        $news->status = -1;

        $news->save();

        return ['code'=>1,'msg'=>'delete success'];
    }

    static function moveCreation($uid,$nid,$ucid){ // 移动创作分类

        $news = News::where('uid',$uid)->where('id',$nid)->first();

        if (empty($news)){
            return ['code'=>0,'msg'=>'文章作者不匹配'];
        }

        $news->ucid = $ucid;

        $news->save();

        return ['code'=>1,'msg'=>'移动成功'];
    }

    static function restoreCreation($uid,$nid){ // 恢复创作

        $news = News::where('uid',$uid)->where('id',$nid)->first();

        if (empty($news)){
            return ['code'=>0,'msg'=>'news and user dismatch'];
        }

        $news->status = 1;

        $news->save();

        return ['code'=>1,'msg'=>'restore success'];

    }

    public function Search($keywords){

        $search = News::where('status',1);              

        if(!trim($keywords)){

            $search = $search->limit(10);

        }else{

            $keywords = '%'.$keywords.'%';

            $search = $search->where('title','like',$keywords);
        }

        $search = $search

                    ->select('id','cid','title','origin','image','brief','updated_at')

                    ->orderBy('view','desc')

                    ->latest()

                    ->limit(20)

                    ->get();

        foreach ($search as $key => $value) {
            $search[$key]->view = $this->getView($value->id);
            $search[$key]->time = isset($value->updated_at)?$value->updated_at->diffForHumans():'';
            $search[$key]->category_name = isset($value->category)?$value->category->cname:'';
            $search[$key]->username = name_filter($value->origin);
            $search[$key]->collection = $this->getCollection($value->id);           
            //unset($search->user);
            unset($search[$key]->category);        
        }

        return $search;
    }

    public function addView($id){

        $news = News::where('id',$id)->first();

        $f_view = $news->f_view;

        $time = $news->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.news');
        
        $add_view = view_rand($f_view,$time_sub,$conf);

        if ($f_view>10000) {
            $add_view = rand(15,30);
        }

        DB::table('news')->where('id',$id)->increment('view');

        DB::table('news')->where('id',$id)->increment('f_view',$add_view);                

        get_model_obj('ViewRecord')->AddRecord($news->uid,$add_view);

    }

    public function get_hot_news(){

        $week_ago = date('Y-m-d', strtotime('-7 days'));

        $hot_news = News::where('status',1)

        ->where('updated_at','>',$week_ago)
        
        ->select('id','title','image','brief','view')

        ->latest()

        ->orderBy('view','desc')
        
        ->limit(10)

        ->get();

        foreach($hot_news as $key => $value){
            $hot_news[$key]->view = $this->getView($value->id);            
        }

        return $hot_news;
    }

    public function get_week_hot_news(){

        $week_ago = date('Y-m-d', strtotime('-7 days'));

        $hot_news = News::where('status',1)

        ->where('updated_at','>',$week_ago)
        
        ->select('id','title','view')
        
        ->limit(10)
        
        ->orderBy('view','desc')
       
        ->get();

        foreach($hot_news as $key => $value){
            $hot_news[$key]->view = $this->getView($value->id);            
        }       

        return $hot_news;
    }

    static function get_recent_news($uid,$count){//参数 uid 作者id ，count 获取近期的几篇文章
        $news = News::where('status',1)
                ->where('uid',$uid)
                ->select('id','title','updated_at','cid')
                ->latest()
                ->limit($count)
                ->get();
        foreach ($news as $key => $value) {
            $news[$key]->cname = isset($value->category)?$value->category->cname:'';
            $news[$key]->time = $value->updated_at->diffForHumans();
            unset($news[$key]->category);
        }
        return $news;
    }

    public function AssembleData($id,$auid){

        $data = News::where('id',$id)

                ->where('status',1)

                ->select('id','title','image','f_view','brief','cid','uid','updated_at','byself')

                ->first();

        if (empty($data)) {

            return false;
        }

        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';
        
        $data->category_name = isset($data->category)?$data->category->cname:'';
        
        $data->comment_count = $data->comment->count();
        
        $data->collection_count = $data->collection->count();

        if (isset($auid)) {
            $data->is_collection = $this->is_collected($id,$auid);
        }else{
            $data->is_collection = 0;
        }

        unset($data->collection);

        unset($data->comment);

        unset($data->category);

        if (!$data->image) {

            $rand = rand(1,54);
            
            $image = '/static/724pics/724usepic_'.$rand.'.jpg';

            News::where('id',$id)->update(['image'=>$image]);

            $data->image = $image;
        }
        
        if ($data->user) {
    
            $data->user_name = name_filter($data->user->username);

            $data->user_id = $data->user->id;

            $data->user_image = $data->user->image;

            unset($data->user);

        }
        
        unset($data->category);
        
        return $data;

    }

    static function LockNews($id){

        $news = News::find($id);

        if (empty($news)) {
            return ['code'=>0,'msg'=>'id not exist'];
        }

        if ($news->locked) {
            $news->locked = 0;
        }else{
            $news->locked = 1;
        }

        $news->save();

        return ['code'=>1,'msg'=>'success'];
    }

    public function getUsreView($uid,$start,$end){

        $view = News::where('uid',$uid);

        if ($start) {
            $view = $view->where('created_at','>',$start);
        }
        if ($end) {
            $view = $view->where('created_at','<=',$end);
        }

        $view = $view->where('status',1)->sum('f_view');

        return $view;

    }

    static function getIncomeList($uid,$start,$end,$limit,$skip){

        $news_obj = News::where('uid',$uid);

        if ($start) {
            $news_obj = $news_obj->where('created_at','>',$start);
        }
        if ($end) {
            $news_obj = $news_obj->where('created_at','<=',$end);
        }

        $lists = $news_obj

        ->where('status',1);

        $count = $lists->count();

        $lists = $lists->select('id','created_at','title','f_view')

        ->limit($limit)

        ->skip($skip)

        ->latest()

        ->get();       

        return ['lists'=>$lists,'count'=>$count];
    } 
}
