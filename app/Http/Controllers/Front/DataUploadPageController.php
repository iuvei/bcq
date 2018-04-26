<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use FileSystem;
use App\Models\UserData;
use App\Models\PriceRecord;
class DataUploadPageController extends Controller
{
    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.data_upload_page.page_id'));//获取该页所有广告位广告信息

        $render = [
            'adList'=>$adsList
        ];
        echo json_encode($render);
    }

    public function DataUpload(Request $request){

        $user_ret = get_user_info();

        if (!$user_ret['code']){
            echo json_encode($user_ret);
            die;
        }

        $data['uid'] = $user_ret['user']->id;

        $data['id'] = $request->input('id');//分包的文件

        $data['file'] = $request->input('file');//分包的文件

        $data['title'] = clean($request->input('title'));

        $data['keywords'] = clean($request->input('keywords'));

        $data['suffix'] = clean($request->input('suffix'));

        $data['brief'] = clean($request->input('brief'));

        $data['type'] = $request->input('type');

        $data['price'] = clean($request->input('price'));

        $obj = new UserData();

        $ret = $obj->addUserData($data);

        echo json_encode($ret);
    }
}