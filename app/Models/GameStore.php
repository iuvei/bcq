<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class GameStore extends Model
{
    protected $table = 'gamestore';

    public function platform(){

        return $this->hasMany('App\Models\Platform','gid','id');

    }

    public function getGameStoreList($skip,$limit,$opt){

        $gameStoreList = GameStore::where('status',1);

        if (isset($opt['cid'])&&$opt['cid']) {

            $gameStoreList = $gameStoreList->where('cid',$opt['cid']);            
        }

        $gameStoreList = $gameStoreList->select('id','cid','brief','title','logo','url','money','access_point');

        $gameStoreList = $gameStoreList->skip($skip)->limit($limit)->orderBy('sort','desc')->latest()->get();

        return $gameStoreList;
    }
}