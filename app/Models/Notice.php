<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Notice extends Model
{
    protected $table = 'notice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function Slide()
    {
        return $this->morphMany('App\Models\Slide', 'Slide');
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[1]);
        });
    }

    public function getNoticeList(){

        $notice = Notice::where('status',1)->select('id','title','image','content','created_at')->orderBy('sort','desc')->get();

        return $notice;
    
    }

}