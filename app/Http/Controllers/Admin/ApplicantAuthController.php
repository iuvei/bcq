<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\User;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModels\ApplicantAuth;
use App\Models\AdminModels\Author;
use App\Models\AdminModels\Message;
class ApplicantAuthController extends Controller
{
    public function applicant_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = ApplicantAuth::getApplicantAuth(0,10,true,$sSearch,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.applicant.applicant-list',compact('object'));
    }

    public function applicant_ajax_list(Request $request){
        $orOpt = array();
        $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
        $object = ApplicantAuth::getApplicantAuth($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$sSearch,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );
        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = ApplicantAuth::getApplicantAuthCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function applicant_review(Request $request){
        $object = ApplicantAuth::where('status',0)->get()->load('user');
        return view('Admin.applicant.applicant-list',compact('object'));
    }

    public function auditAdd(Request $request)
    {
        $userIdList = explode(',', $request->get('id_list'));

        $authorList = Author::getAuthorId(0,count($userIdList),array('uid'=>$userIdList));
        $authorIdList = [];
        if ($authorList){
            $authorIdList = array_column($authorList->toArray(), 'uid', 'id');
        }

        $data = [];


        foreach ($userIdList as $key => $val) {
            if (!in_array($val,$authorIdList)){
                $data[] = ['uid' => intval($val), 'status' => 1, 'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')];
            }
        }
        DB::beginTransaction();
        $user = DB::table('users');
        $author = DB::table('user_author');
        $applicant = DB::table('applicant_author');
        try{
            $author->where('status',0)
                ->whereIn('uid', $authorIdList)
                ->update(['status' => 1]);

            $author->insert($data);

            $applicant->where('status',0)
                ->whereIn('uid', $userIdList)
                ->update(['status' => 1]);

            $user->whereIn('id', $authorIdList)
                ->update(['level_id' => 2]);

            $code = 1;
            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            $code = 0;
        }

        $return['code'] = $code;

        return json_encode($return);
    }


    public function applicant_list_edit(Request $request){

        $id = $request->input('id');

        $obj = ApplicantAuth::where('id',$id)->first();

        $obj->user = $obj->user;

        $table = 'applicant_author';

        return view('Admin.applicant.applicant-list-edit',compact('obj','table'));

    }

    public function applicant_edit(Request $request){

        $id = $request->input('id');

        $uid = $request->input('uid');
        
        $status = $request->input('status');

        $applicant = ApplicantAuth::find($id);

        if ($status==1) {
            $applicant->status = 1;
            Author::firstOrCreate(
                ['uid' => $uid], ['status' => 1]
            );
            $user = User::find($uid);
            $user->level_id = 2;
            $user->save();
            Message::create(['from'=>1,'to'=>$uid,'content'=>'您已成功申请成为菠菜圈认证作者','status'=>1]);
        }elseif ($status == 0) {
            $applicant->status = 0;    
        }elseif ($status == -1) {
            $applicant->status = -1;
        }
        $applicant->save();
    }
}