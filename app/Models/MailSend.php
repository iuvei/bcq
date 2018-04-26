<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSend extends Model
{
    protected $table = 'mail_send';

    public function mail(){

        return $this->belongsTo('App\Models\Mail','mid','id');

    }

    //状态：-1管理员删除，0管理员禁用，1用户未读，2用户已读，3用户删除

    static function getMailCount($uid){//获取用户未读站内信数量

        $count = MailSend::where('to',$uid)->where('status',1)->count();

        return  $count;

    }

    public function getMailSendList($skip = 0,$limit,$opt){

    	$mail = MailSend::whereIn('status',[1,2])->where('to',$opt['uid'])->whereHas('mail',function($query){
    		$query->where('status',1);
    	});

    	$mail_info['count'] = $mail->count();

    	$mail_info['data'] = $mail->limit($limit)->skip($skip)->select('id','to','mid','created_at','status')->get();	

		foreach($mail_info['data'] as $key=>$value){
            $mail_info['data'][$key]->date = $value->created_at->toDateString();
			$mail_info['data'][$key]->mail;
		}

		return $mail_info;
    }

    static function deleteMail(array $mail_id){

        MailSend::whereIn('id',$mail_id)->update(['status'=>3]);

        return ['code'=>1,'msg'=>'success'];
    }

    static function viewMail($id){

         MailSend::where('id',$id)->update(['status'=>2]);

         return ['code'=>1,'msg'=>'success'];
    }

    
}
