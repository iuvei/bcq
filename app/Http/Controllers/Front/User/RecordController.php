<?php
namespace App\Http\Controllers\Front\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PriceRecord;
class RecordController extends UserCenterController
{   
	public function user_record(Request $request){

		$page = $request->input('page');

		$page_info = page_helper($page,config('etc.user_center.record.render_limit'),config('etc.user_center.record.limit'));

		$record = PriceRecord::user_record($this->user_obj->id,$page_info['skip'],$page_info['limit']);

		echo json_encode($record);

	}	
}