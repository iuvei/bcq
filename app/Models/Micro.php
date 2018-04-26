<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use DB;
class Micro extends Model
{
    //微动态
	protected $table = 'micro';
    
    protected $hidden = ['sort','view'];
	
    public function user(){
        return $this->belongsTo('App\Models\User','uid','id');
    }
    public function collection(){

        return $this->hasMany('App\Models\MicroCollection','mid','id');
    }

    public function comment(){

        return $this->hasMany('App\Models\MicroComment','mid','id');
    }


    public function getMicroList($skip,$limit,$opt){

        $micro = Micro::where('status',1);

        if (isset($opt['uid'])) {

            $micro = $micro->where('uid',$opt['uid']);
        
        }

        if (isset($opt['utype'])) {
            $micro = $micro->where('utype',$opt['utype']);
        }        

        $micro = $micro->latest()

        ->limit($limit)

        ->skip($skip)

        ->get();

        foreach ($micro as $key => $value) {

            $micro[$key]->time = $value->updated_at->diffForHumans();

            $micro[$key]->image = json_decode($micro[$key]->image,true);            

            $micro[$key]->comment_count = $value->comment->where('status',1)->count();

            $micro[$key]->user;

            unset($micro[$key]->comment);

        }

        return $micro;

    }


    public function MicroDetail($id){

    	$detail = Micro::where('status',1)
    	
    	->where('id',$id)
    	
    	->select('id','uid','utype','content','image','top','f_view','updated_at')
    	
    	->first();

    	if (empty($detail)) {
    		return '';
    	}

    	$detail->time = $detail->updated_at->diffForHumans();

    	$detail->comment_count = $detail->comment->where('status',1)->count();

    	$detail->user;

    	$detail->user->is_author = Author::is_author($detail->user->id);

    	unset($detail->comment);

    	return $detail;
    }

    public function getComment($id){//获取评论数量

        $obj = Micro::where('id',$id)->first();

        $comment = $obj->comment->where('status',1)->count();

        return $comment;

    }

    public function getCollection($id){//获取收藏数量

        $obj = Micro::where('id',$id)->first();

        $collection = $obj->collection->where('status',1)->count();

        return $collection;
    }

    public function addView($id){

        $micro = Micro::where('id',$id)->first();

        $f_view = $micro->f_view;

        $time = $micro->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.micro');
        
        $add_view = view_rand($f_view,$time_sub,$conf);

        DB::table('micro')->where('id',$id)->increment('view');

        DB::table('micro')->where('id',$id)->increment('f_view',$add_view);                

    }

    public function GetRelateMicro($uid,$except){

        $relate = Micro::where('uid',$uid)
        
        ->where('status',1)

        ->where('id','<>',$except)

        ->select('id','content','updated_at')

        ->latest()

        ->limit(5)

        ->get();   

        foreach ($relate as $key => $value) {

            $relate[$key]->time = $value->updated_at->diffForHumans();

        }

        return $relate;
    }

    public function GetRecommendMicro($limit,$skip){

        $recommand = Micro::where('status',1)

        ->select('id','content','uid')

        ->limit($limit)

        ->skip($skip)

        ->orderBy('f_view','desc')

        ->latest()

        ->get();   

        foreach ($recommand as $key => $value) {

            $recommand[$key]->user;
            
            $recommand[$key]->user->is_author = Author::is_author($recommand[$key]->user->id);
        
        }

        return $recommand;

    }

    public function AssembleData($id){

        $data = Micro::where('id',$id)

                ->where('status',1)

                ->select('id','content','utype','image','f_view','uid','top','updated_at')

                ->first();
        
        if (empty($data)) {
            
            return [];
        }

        $data->time = $data->updated_at->diffForHumans();

        $data->image = json_decode($data->image,true);

        $data->comment_count = $data->comment->where('status',1)->count();

        unset($data->comment);

        $data->user;

        $data->user->is_author = Author::is_author($data->user->id);

        return $data;

    }  

    public function GetDayPublish($uid){

        $count =  Micro::where('uid',$uid)

        ->where('updated_at','>',date('Y-m-d'))

        ->count();

        return $count;
    }  

    public function GetNewInfo(){

        $micro = Micro::where('status',1)->where('utype',1)->latest()->first();

        if (empty($micro)) {
            return '';
        }

        $micro->time = $micro->updated_at->diffForHumans();       

        $micro->user;

        return $micro;
    }

    public function user_publish($uid,$skip,$limit){

        $publish = Micro::whereNotIn('status',[-1,-3])->where('uid',$uid);

        $count = $publish->count();

        $publish = $publish->skip($skip)->limit($limit)->orderBy('unread','desc')->latest()->get();

        return ['list'=>$publish,'count'=>$count];

    }
}
