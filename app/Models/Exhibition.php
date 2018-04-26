<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Exhibition extends Model
{
    //
	protected $table = 'show';

    public function news(){

        return $this->belongsToMany('App\Models\News','show_news','sid','nid');
    }


	public function get_new_exhibition(){

		$now = time();

		$exhibition = Exhibition::where('status',1)

		->where('famous',1)

		->where('starttime','>=',$now)

		->select('starttime','endtime','title','short','sponsor','address','image','url')

        ->orderBy('starttime')

		->first();


		if (empty($exhibition)) {

			$exhibition = Exhibition::where('status',1)

			->where('starttime','>',$now)

			->orderBy('starttime')

			->select('starttime','endtime','title','short','sponsor','address','image','url')

			->first();
		}
		
		return $exhibition;

	}

    public function get_exhibition_news(){

        $show_news = DB::table('show_news')

                    ->join('news','show_news.nid','=','news.id')

                    ->join('show','show_news.sid','=','show.id')

                    ->select('news.id as nid','news.title','show.id as sid','show.short')

                    ->where('show_news.status',1)

                    ->where('news.status',1)

                    ->orderBy('show_news.id','desc')

                    ->orderBy('show_news.sort','desc')

                    ->limit(10)
                    
                    ->get();

        return $show_news;
    }

    public function getExhibitionList($skip,$limit,$opt)
    {
        if (empty($limit)){

            return [];
        }

        $now = time();

        $exhibitionList = Exhibition::where('status',1)->where('starttime','>',$now)->orderBy('starttime');

        if (isset($opt['famous'])){
            $exhibitionList = $exhibitionList->where('famous',1);
        }

        $exhibitionList = $exhibitionList->skip($skip)->limit($limit)->get();

        if (!$exhibitionList->isEmpty()){

            foreach ($exhibitionList as $key=>$exhibition){
                $exhibitionList[$key]->month = getdate($exhibition->starttime)['mon'];
                $exhibitionList[$key]->day = getdate($exhibition->starttime)['mday'];
                $exhibitionList[$key]->starttime = date('Y-m-d',$exhibition->starttime);
                $exhibitionList[$key]->endtime = date('Y-m-d',$exhibition->endtime);
                //避免状态暴露
                unset($exhibitionList[$key]->status);

            }
        }
        return $exhibitionList;
    }

    public function getDetails($sid){
        $exhibition = Exhibition::where('id',$sid)->where('status',1)->first();
        $exhibition->starttime = date('Y-m-d',$exhibition->starttime);
        $exhibition->endtime = date('Y-m-d',$exhibition->endtime);
        if (!$exhibition){
            return [];
        }

        return $exhibition;
    }

    public function addView($id){

        $obj = Exhibition::find($id);

        if (!empty($obj)){

            $obj->view ++;

            $obj->save();
        }
    }


    public function getBriefList(){//这些数据供展会日历使用

        $now = time();

        $exhibitionList = Exhibition::where('status',1)

                        ->where('endtime','>',$now)

                        ->orderBy('starttime')

                        ->select('id',DB::raw("FROM_UNIXTIME(starttime,'%Y-%m-%d') as startdate"),DB::raw("FROM_UNIXTIME(endtime,'%Y-%m-%d') as enddate"),'short','url')
                        ->get();
        
        return $exhibitionList;
        
    }
}