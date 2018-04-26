<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ViewRecord extends Model
{

    protected $table = 'view_record';

    protected $fillable = ['uid','date'];

    public function AddRecord($uid,$view){

    	$date = date('Y-m-d');

    	$record = ViewRecord::firstOrCreate([
    		'uid'=>$uid,
    		'date'=>$date
    	]);

    	$new_view = $record->view + $view;

    	$record->view = $new_view;

    	$record->save();

    }

    public function GetViewTrend($uid){

    	$this_month_start = date('Y-m-01');

    	$today = date('Y-m-d');

    	$last_month_start = date('Y-m-01',strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01'));

    	$last_month_today = Carbon::parse('-1 months')->toDateString();

        $last_month_view = ViewRecord::where('uid',$uid)
        
        ->where('date','>=',$last_month_start)
        
        ->where('date','<=',$last_month_today)
        
        ->sum('view');

        $this_month_view = ViewRecord::where('uid',$uid)
        
        ->where('date','>=',$this_month_start)
        
        ->where('date','<=',$today)
       
        ->sum('view'); 

        return ['last_month_view'=>$last_month_view,'this_month_view'=>$this_month_view];
    }
}