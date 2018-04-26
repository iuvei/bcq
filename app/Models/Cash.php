<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Cash extends Model
{
    protected $table = 'cash';

    protected $guarded = [];

    public function cashmark(){

        return $this->hasMany('App\Models\Cashmark','cid','id');

    }

    public function getCashList($skip,$limit,$opt){

        if (!isset($limit)||!isset($skip)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $cashlist = Cash::where('status',1);

        if (isset($opt['access'])&&$opt['access']){
            $cashlist = $cashlist->where('access','&',$opt['access']);
        }
        if (isset($opt['games'])&&$opt['games']){
            $cashlist = $cashlist->where('games','&',$opt['games']);
        }
        if (isset($opt['region'])&&$opt['region']){
            $cashlist = $cashlist->where('region',$opt['region']);
        }
        if (isset($opt['title'])&&$opt['title']){
            $cashlist = $cashlist->where('title','like','%'.$opt['title'].'%');
        }
        $cashlist = $cashlist->select('id','title','access','games','region','url1','url2','url3','url4','mark','mark1','mark2','mark3','mark4','content','logo');

        if (isset($opt['orderBy'])){
            $cashlist = $cashlist->orderBy($opt['orderBy'],'desc');
        }

        $cashlist = $cashlist->latest()->orderBy('sort','desc')->skip($skip)->limit($limit)->withCount('cashmark')->get();

        foreach ($cashlist as $key => $val){
            $cashlist[$key]['content'] = str_limit($val['content'], 320, '......');
            $cashlist[$key]['access_name'] = ' ';
            foreach (config('base.access') as $k => $v){
                if ($val['access'] & $k){
                    $cashlist[$key]['access_name'] .= $v.' ';
                }
            }

            $cashlist[$key]['games_name'] = ' ';
            foreach (config('base.games') as $i => $j){
                if ($val['games'] & $i){
                    $cashlist[$key]['games_name'] .= $j.' ';
                }
            }

            $region = $val['region'];
            if ($region && $region_name = config('base.region')[$region]){
                $cashlist[$key]['region_name'] = $region_name;
            }else{
                $cashlist[$key]['region_name'] = '未知';
            }
        }

        return $cashlist;
    }

    public function getComment($id){//获取评论数量

        $comment = DB::table('cashmark')->where('cid',$id)->count();

        return $comment;

    }

    public function getDetails($cid){
        $cash = Cash::where('id',$cid)->where('status',1)->select('id','title','access','games','region','view','url1','url2','url3','url4','mark','mark1','mark2','mark3','mark4','content','logo')->withCount('cashmark')->first();
        if (!$cash){
            return [];
        }


        return $this->process($cash);
    }

    public function process($obj){
        $obj->content = htmlspecialchars_decode(html_entity_decode($obj->content));

        $obj->access_name = ' ';
        foreach (config('base.access') as $k => $v){
            if ($obj->access & $k){
                $obj->access_name .= $v.' ';
            }
        }

        $obj->games_name = ' ';
        foreach (config('base.games') as $i => $j){
            if ($obj->games & $i){
                $obj->games_name .= $j.' ';
            }
        }

        $region = $obj->region;
        if ($region && $region_name = config('base.region')[$region]){
            $obj->region_name = $region_name;
        }else{
            $obj->region_name = '未知';
        }
        return $obj;
    }

    public function addView($id){

        $obj = Cash::find($id);

        if (!empty($obj)){

            $obj->view ++;

            $obj->save();
        }
    }

    static function getCount($opt){
        $query = Cash::where('status',1);
        if (isset($opt['access'])&&$opt['access']){
            $query = $query->where('access','&',$opt['access']);
        }
        if (isset($opt['games'])&&$opt['games']){
            $query = $query->where('games','&',$opt['games']);
        }
        if (isset($opt['region'])&&$opt['region']){
            $query = $query->where('region',$opt['region']);
        }
        $count = $query->count();

        return $count;
    }





}
