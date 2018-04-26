<?php
namespace App\Http\Controllers\Front\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController as Common;
use DisplaySystem;
use Closure;
use FileSystem;
use App\Models\Message;
use App\Models\News;
class UserCenterController extends Controller
{
    //用户中心
    //用户中心分为四个页面来写，每个页面都有公共的个人信息部分，所以公共部分抽出来供四个子类继承
    protected $user_obj;

    public $common_obj;

    public function __construct()
    {
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->user_obj = $user_info['user'];

                $this->common_obj = new Common;

            }else{
                echo json_encode(['code'=>0,'msg'=>'请先登录']);
                die;
            }
            return $next($request);
        });
    }

    public function user_info_render(){

        $user_info = $this->user_obj;

        $mails = Message::messageCount($this->user_obj->id,1);//未读站内信

        $author_info = $this->user_obj->authorCheck($this->user_obj->id);//是否是作者

        $view_total = get_model_obj('News')->getUsreView($this->user_obj->id,'','');//总点击量

        $income_total = $this->common_obj->IncomeComputer($view_total);//总收益

        $income_total = intval($income_total);

        echo json_encode(['code'=>1,'render'=>[
            'income_total'=>$income_total,
            'user_info'=>$user_info,
            'mails'=>$mails,
            'author_info'=>$author_info
        ]]);
    }

    public function mail_render(){

        if (empty($this->user_obj)) {
            echo json_encode([]);
            die;
        }

/*        $mail = $this->getList('MailSend',0,config('etc.user_center.mail.render_limit'),$opt = ['uid'=>$this->user_obj->id]);
*/
        $message = $this->getList('Message',0,config('etc.user_center.mail.render_limit'),$opt = ['uid'=>$this->user_obj->id]);;

/*        $collection = [];

        $record = [];

        $publish = [];
*/
        echo json_encode([
/*            'mail'=>$mail,*/
            'message'=>$message
        ]);
    }

    public function change_image(Request $request){

        $image = $request->input('image');

        if (empty($image)){

            echo json_encode(['code'=>0,'msg'=>'头像不得为空']);

            die;
        }

        $dir = 'avatar/'.$this->user_obj->id;

        $path_ret = FileSystem::uploadPublicFileBase64($image,$dir);

        $this->user_obj->image = $path_ret['path'];

        $this->user_obj->save();

        if (!$path_ret['code']) {
            echo json_encode(['code'=>0,'msg'=>'上传头像失败']);
            die;
        }

        echo json_encode(['code'=>1,'msg'=>'修改成功','path'=>$path_ret['path']]);

     }

    public function change_signature_image(Request $request){

        $image = $request->input('image');

        if (empty($image)){

            echo json_encode(['code'=>0,'msg'=>'签名档图片不得为空']);

            die;
        }

        $dir = 'signature/'.$this->user_obj->id;

        $path_ret = FileSystem::uploadPublicFileBase64($image,$dir);

        if (!$path_ret['code']) {
            echo json_encode(['code'=>0,'msg'=>'上传图片失败']);
            die;
        }

        echo json_encode(['code'=>1,'msg'=>'上传成功','path'=>$path_ret['path']]);

    }     

    public function change_signature(Request $request){
        
        $this->user_obj->signature = $request->input('signature_img')?$request->input('signature_img'):'';

        $this->user_obj->sign_url = clean($request->input('signature_url'));

        $this->user_obj->save();

        echo json_encode(['code'=>1,'msg'=>'sussess']);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
