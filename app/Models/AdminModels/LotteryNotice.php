<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class LotteryNotice extends Model
{
    protected $table = 'lottery_notice';
    protected $guarded = [];

    public function micro(){

        return $this->belongsTo('App\Models\AdminModels\Micro','mid','id');

    }

}
