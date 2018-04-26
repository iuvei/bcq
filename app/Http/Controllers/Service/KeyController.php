<?php
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\News;
use App\Models\AdminModels\Key;
use App\Http\Controllers\Admin\ToolsController;
use Illuminate\Support\Facades\Redis;

class KeyController extends Controller
{
    public function getKey(){
        dd(Redis::del('keynum'));

        $keyword = Redis::zRangeByScore('keynum', -INF, INF, array('withscores' => TRUE));
        arsort($keyword);

        foreach ($keyword as $key => $val){
            if(mb_strlen($key) == 1 || is_numeric($key)){
                unset($keyword[$key]);
            }
        }
        foreach ($keyword as $k => $v){
            Key::Create(
                ['keywords' => $k,'num' => $v]
            );
        }


        /*        $new = News::whereIn('status',[0,1])->where('id','>',3000)->where('id','<',4501)->get();
                //$new = News::whereIn('status',[0,1])->where('id',1)->get();

                foreach ($new as $k => $v){
                    $key_res = ToolsController::getKey(strip_tags(html_entity_decode($v->content)));
                }*/

        //dd($this->getKeyword($str));
    }
    public function key(){
        //$new = News::whereIn('status',[0,1])->where('id','>',3000)->where('id','<',4501)->get();
        $new = News::whereIn('status',[0,1])->where('id',4320)->get();

        foreach ($new as $k => $v){
            $key_res = ToolsController::getKeyword(strip_tags(html_entity_decode($v->content)),false);
            $v->key_all = $key_res['key_all'];
            $v->keywords = $key_res['keywords'];
            dd($v->save());
        }

        //dd($this->getKeyword($str));
    }

}