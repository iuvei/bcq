<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Level;

class UserController extends Controller
{
    protected $passField = [
        'username','password','level_id','vip','price','viptime','regdate','regip','lastlogindate','lastloginip','image','brief','phone','skype','email','wechat','qq','job','grasp','city','remember_token','status'
    ];

    public function user_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['username'] = array('like','%'.$sSearch.'%');
                $orOpt['phone'] = array('like','%'.$sSearch.'%');
                $orOpt['city'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
        if ($request->post('datemin') && $request->post('datemax')){
            $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
        }
            $object = User::getUser(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        //dd($object);
        return view('Admin.user.user-list',compact('object'));
    }

    public function user_ajax_list(Request $request){
        $opt = array(
            'status' => array('!=',-1)
        );

        $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
        $orOpt = array();
        if ($sSearch){
            $orOpt['username'] = array('like','%'.$sSearch.'%');
            $orOpt['phone'] = array('like','%'.$sSearch.'%');
            $orOpt['city'] = array('like','%'.$sSearch.'%');
        }

        $object = User::getUser($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),

        );
        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = User::getUserCount('!=',-1);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function user_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'username' => 'required|unique:users',
                'password' => 'required|confirmed',
                'phone' => 'required|integer|unique:users',
                'level_id' => 'required',
                'price' => 'integer|nullable',
                'email' => 'email|nullable',
                'qq' => 'integer|nullable',
                'status' => 'required',
            ]);

            //数据库操作
            $ip = $request->getClientIp();
            $data = array('regip'=>$ip,'lastloginip'=>$ip);
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if ($key == 'password'){
                        $val = substr(md5('PASSWORD_SALT'.$val),6,18);
                    }
                    if($key == 'image' && !$val){
                        $val = config('base.news_user_avatar');
                    }
                    $data[$key] = $val;
                }
            }
            User::create($data);
            //返回结果
        }

        $level = Level::getLevel('created_at');
        return view('Admin.user.user-add',compact('level'));
    }

    public function user_edit(User $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'username' => $obj->username==request()->get('username')?'required':'required|unique:users',
                'level_id' => 'required',
                'price' => 'integer|nullable',
                'email' => 'email|nullable',
                'qq' => 'integer|nullable',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->lastloginip = request()->getClientIp();
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if ($key == 'password' && $val){
                        $val = substr(md5('PASSWORD_SALT'.$val),6,18);
                    }
                    if($key == 'image' && !$val){
                        $val = config('base.news_user_avatar');
                    }
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        $level = Level::getLevel('created_at');
        return view('Admin.user.user-edit',compact('obj','level'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new User();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }
}