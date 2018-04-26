<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'message_send';

    protected $hidden = ['updated_at'];

    public function user(){

        return $this->belongsTo('App\Models\User','from','id');

    } 

    static function messageCount($uid,$status){//获取私信的数量   uid是用户id ，status是私信的状态 已读，未读，已删除等

        //status 状态：-1发送者删除，0发送者禁用，1接受者未读，2接受者已读，3接受者删除

        $count = Message::where('to',$uid)->where('status',$status)->count();

        return $count;
    }

    public function sendMessage($from,$to,$content){

		try{
	    	$this->from = $from;

	    	$this->to = $to;

	    	$this->content = $content;

	    	$this->save();	

		}catch(Exception $e){

			return ['code'=>0,'msg'=>$e->getMessage()];
		}

    	return ['code'=>1,'msg'=>'success'];
    }


    public function getMessageList($skip,$limit,$opt){

        $message = Message::whereIn('status',[1,2])->where('to',$opt['uid']);

        $message_info['count'] = $message->count();

        $message_info['data'] = $message->limit($limit)->skip($skip)->latest()->select('id','from','to','content','created_at','status')->get(); 
        
        foreach ($message_info['data'] as $key => $value) {
            $message_info['data'][$key]->date = $value->created_at->toDateString();
            $message_info['data'][$key]->username = name_filter($value->user->username);
            unset($message_info['data'][$key]->user);
        }

        return $message_info;

    }

    static function deleteMessage(array $mail_id){

        Message::whereIn('id',$mail_id)->update(['status'=>3]);

        return ['code'=>1,'msg'=>'success'];
    }

    static function viewMessage($id){

        Message::where('id',$id)->update(['status'=>2]);

        return ['code'=>1,'msg'=>'success'];
    }


}
