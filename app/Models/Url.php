<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'url';

    public function getUrlInfo($ucid){

        $url_info = Url::where('ucid',$ucid)->where('status',1)->select('id','title','url')->get();

        return $url_info;
    }
}