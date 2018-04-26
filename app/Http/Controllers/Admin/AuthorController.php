<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Author;

class AuthorController extends Controller
{
    protected $passField = [
        'uid','blog','recommend','publish','u_time','is_admin','desc','status'
    ];

    public function author_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Author::getAuthor(0,10,true,$sSearch,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.author.author-list',compact('object'));
    }

    public function author_ajax_list(Request $request){
        $orOpt = array();
        $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
        $object = Author::getAuthor($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$sSearch,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );
        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Author::getAuthorCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function author_add(Request $request){
        if($request->isMethod('post')){
            $userIdList = explode(',',$request->get('id_list'));
            $authorAdmin = new Author();
            $data = [];
            foreach ($userIdList as $val){
                $data = ['uid' => $val,'status' => 1,'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')];
                Author::updateOrCreate(
                    ['uid' => $data['uid']],
                    $data
                );
            }

            $res = User::whereIn('id', $userIdList)
                ->update(['level_id' => 2]);

            if($res){
                $return['code'] = 1;
            }else{
                $return['code'] = 0;
            }
            return json_encode($return);
        }
        $object = [];
        return view('Admin.author.user-list',compact('object'));
    }

    public function user_ajax_list(Request $request){
        $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
        $orOpt = array();
        if ($sSearch){
            $orOpt['username'] = array('like','%'.$sSearch.'%');
            $orOpt['phone'] = array('like','%'.$sSearch.'%');
            $orOpt['city'] = array('like','%'.$sSearch.'%');
        }

        $object = User::getNotAuthor($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );
        $count = User::getNotAuthorCount($orOpt);
        $Data['iTotalDisplayRecords'] = $count;

        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function author_edit(Author $obj){
        $obj = $obj->load('user');
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'blog' => 'max:100|url|nullable',
                'recommend' => 'required',
                'is_admin' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $obj->$key = $val;
                    if ($key == 'desc'){
                        $obj->user->desc = $val;
                        $obj->user->save();
                    }
                }
            }
            $obj->save();
            $author = $obj->load('user');
            if (intval($obj->status)){
                $author->user->level_id = 2;
            }else{
                $author->user->level_id = 1;
            }
            $author->user->save();
            //返回结果
        }
        return view('Admin.author.author-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));

            if(intval(request('status'))){
                $level_id = 2;
            }else{
                $level_id = 1;
            }
            $author = Author::whereIn('id', $idList)->with('user')->get();
            if($author){
                foreach ($author as $key => $val){
                    $val->user->level_id = $level_id;
                    $val->status = request('status');
                    $val->user->save();
                    $val->save();
                }
            }
            $return_data['code'] = '1';
            $return_data['msg'] = '成功';
            return $return_data;
        }
    }

}