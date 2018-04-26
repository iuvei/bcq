<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MailSend;
use App\Models\Message;
class UserMailController extends UserCenterController
{
    //用户私信，站内信

	public function delete_mail(Request $request){

		$id = $request->input('id');		

		$type = $request->input('type');

		if ($type == 'mail') {
			$ret = MailSend::deleteMail($id);
		}else{
			$ret = Message::deleteMessage($id);
		}

		echo json_encode($ret);
	}

	public function view_mail(Request $request){

		$id = $request->input('id');		

		$type = $request->input('type');

		if ($type == 'mail') {
			$ret = MailSend::viewMail($id);
		}else{
			$ret = Message::viewMessage($id);
		}

		echo json_encode($ret);
	}

	public function get_mail(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.user_center.mail.render_limit'),config('etc.user_center.mail.limit'));

        $maillist = $this->getList('MailSend',$page_info['skip'],$page_info['limit'],$opt = ['uid'=>$this->user_obj->id]);

        echo json_encode($maillist);
	}

	public function get_message(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.user_center.mail.render_limit'),config('etc.user_center.mail.limit'));

        $messagelist = $this->getList('Message',$page_info['skip'],$page_info['limit'],$opt = ['uid'=>$this->user_obj->id]);

        echo json_encode($messagelist);
	}


	public function send_message(Request $request){

		$to = $request->input('to');

		$from = $this->user_obj->id;

		$content = $request->input('content');

		$message = new Message();

		$ret = $message->sendMessage($from,$to,$content);

		echo json_encode($ret);
	}

}
