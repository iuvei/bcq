<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ApplicantAuth extends Model
{
    //
    protected $table = 'applicant_author';
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    static function getApplicantAuth($skip,$limit,$flag,$sSearch,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }

        $query = ApplicantAuth::orderBy('id', 'desc');
        if ($sSearch){
            $query = $query->where('name',$sSearch);
        }
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        $obj = $obj->load('user');
        return $obj;
    }

    static function getApplicantAuthCount(){

        $count = ApplicantAuth::count();

        return $count;
    }

}
