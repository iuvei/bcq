<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'enterprise';

    protected $guarded = [];

    public function getEnterpriseList($skip,$limit,$opt){

        if (!isset($limit)||!isset($skip)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }

        $enterprise = Enterprise::where('status',1);

        $enterprise = $enterprise->select('id','famous','scale','region','addip','title','content','logo','url');

        $enterprise = $enterprise->orderBy('famous','desc');

        $enterprise = $enterprise->orderBy('sort','desc')->skip($skip)->limit($limit)->get();

        return $enterprise;
    }

    public function getDetails($cid){
        $enterprise = Enterprise::where('id',$cid)->where('status',1)->select('sort','famous','scale','region','view','addip','title','content','logo','url','status','created_at')->first();
        if (!$enterprise){
            return [];
        }

        $enterprise->content = htmlspecialchars_decode(html_entity_decode($enterprise->content));

        return $enterprise;
    }

    public function getView($id){//获取浏览量

        $obj = Enterprise::find($id);

        return $obj->view;
    }

    static public function getCount(){//获取总量

        $num = Enterprise::where('status',1)->count();

        return $num;
    }

    public function addView($id){

        $obj = Enterprise::find($id);

        if (!empty($obj)){

            $obj->view ++;

            $obj->save();
        }
    }

}


