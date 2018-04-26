<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Author extends Model
{
    //
    protected $table = 'user_author';
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

    static function getAuthor($skip,$limit,$flag,$sSearch,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Author::whereHas('user', function ($query) use($sSearch,$betweenOpt){
            if ($sSearch){
                $query->where('username','like', '%'.$sSearch.'%');
            }
            if (!empty($betweenOpt)) {
                foreach ($betweenOpt as $k => $v) {
                    $query->whereBetween($k, $v);
                }
            }
        });

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        $obj = $obj->load('user');
        return $obj;
    }

    static function getAuthorCount(){

        $count = Author::count();

        return $count;
    }

    static function getAuthorId($skip,$limit,$inOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Author::select(['id','uid']);

        if (!empty($inOpt)) {
            foreach ($inOpt as $k => $v) {
                $query->whereIn($k, $v);
            }
        }

        $obj = $query->skip($skip)->limit($limit)->get();

        return $obj;
    }

}
