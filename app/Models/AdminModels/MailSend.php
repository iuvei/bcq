<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MailSend extends Model
{
    //
    protected $table = 'mail_send';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1,2,3]);
        });
    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','to','id');

    }

    static function getMailSend($skip,$limit,$flag,$sSearch,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = MailSend::whereHas('user', function ($query) use($sSearch,$betweenOpt){
            if ($sSearch){
                $query->where('username','like', '%'.$sSearch.'%');
            }
            if (!empty($betweenOpt)) {
                foreach ($betweenOpt as $k => $v) {
                    $query->whereBetween($k, $v);
                }
            }
        });

//        $query = MailSend::has('user');

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        $obj = $obj->load('user');
        return $obj;
    }

    static function getMailSendCount(){

        $count = MailSend::count();

        return $count;
    }

    static function getHasMail($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array(),$mid){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = MailSend::whereHas('user', function ($query) use($mid,$orOpt) {
            $query->where('mid', $mid)->Where(function ($query) use($orOpt) {
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        });
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

    static function getHasMailCount($mid){

        $count = MailSend::whereHas('user', function ($query) use($mid) {
            $query->where('mid', $mid);
        })->count();

        return $count;
    }

}
