<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
class UserComment extends Model
{

    protected $table = 'user_comments';

    protected static function boot()
    {
        parent::boot();

        Relation::morphMap([
            'news' => 'App\Models\NewsComment',
            'report' => 'App\Models\ReportComment',
            'userdata' => 'App\Models\UserDataComment',
            'question' => 'App\Models\QuestionAnswer'
        ]);
    }
}
