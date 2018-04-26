<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flash extends Model
{
    protected $table = 'flash';

    public function getFlashList($skip,$limit,$opt){

        if (!$limit){
            return [];
        }

        $flashList = Flash::where('status',1)->skip($skip)->limit($limit);

        $flashList = $flashList->latest()->orderBy('updated_at','desc')->orderBy('sort','desc')->get();

        foreach ($flashList as $key=>$flash){

            if ($flash->updated_at){
                $flashList[$key]->date = $flash->created_at->diffForHumans();

                $flashList[$key]->time = $flash->created_at->toDateString();
            }
            unset($flashList[$key]->sort);

            unset($flashList[$key]->status);

            unset($flashList[$key]->created_at);

        }
        return $flashList->groupBy('time');
    }

    public function get_flash(){

        $flash = Flash::where('status',1)->select('id','title','brief','updated_at')->whereNotNull('brief')->where('brief','<>','')->latest()->limit(4)->orderBy('updated_at','desc')->orderBy('sort','desc')->get();

        foreach($flash as $key=>$value){

            $flash[$key]->time = isset($value->updated_at)?$value->updated_at->diffForHumans():'';

            $flash[$key]->is_actve = 0;
        }

        return $flash;

    }

    public function get_top($id){

        $top = Flash::where('status',1)->where('id',$id)->first();

        return $top;

    }

    public function AssembleData($id){

        $data = Flash::where('id',$id)

                ->where('status',1)

                ->select('id','title','image','updated_at')

                ->first();
        
        if (empty($data)) {

            return false;
        }

        $rand = rand(1,54);

        if (!$data->image) {

            $image = '/static/724pics/724usepic_'.$rand.'.jpg';

            Flash::where('id',$id)->update(['image'=>$image]);

            $data->image = $image;        
        }

        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        return $data;

    }     
}