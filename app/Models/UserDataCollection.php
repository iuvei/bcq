<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDataCollection extends Model
{
    protected $table = 'data_collection';       

    public function data(){

        return $this->belongsTo('App\Models\Question','did','id');
        
    }
}
