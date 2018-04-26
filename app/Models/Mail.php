<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    //
    protected $table = 'mail';

    protected $hidden = [
        'created_at','updated_at','status'
    ];

}
