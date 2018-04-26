<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadRecord extends Model
{
    //
    protected $table = 'download_record';

    static function record($data){

    	$record = new DownloadRecord();

    	foreach($data as $key=>$value){

    		$record->$key = $value;

    	}

    	$record->save();

    	return ['code'=>1,'msg'=>'record success'];
    }


    static function user_download_record($uid,$skip,$limit,$type){

        $record = DownloadRecord::where('doid',$uid)->where('type',$type)->latest()->skip($skip)->limit($limit)->pluck('did');

        return $record;

    }

    static function download_count($uid,$type){

        $count =  DownloadRecord::where('doid',$uid)->where('type',$type)->select('did')->distinct()->get();

        return $count->count();         

    }

}
