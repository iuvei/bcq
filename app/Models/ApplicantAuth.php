<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ApplicantAuth extends Model
{

    protected $table = 'applicant_author';

    protected $guarded = [];

    static public function isPublish($uid){
        $flag = false;

        if(ApplicantAuth::where('status',0)->where('uid',$uid)->first())
        {
            $flag = true;
        }

        return $flag;
    }
}
