<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('Front.web_front_bocaiquan');//首页频道

});

Route::get('/flush_cache', 'Front\ComponentsController@flush_cache');

Route::group(['prefix'=>'common'],function () {

    Route::get('/is_login', 'Front\AccountController@isLogin');

    Route::get('/logout', 'Front\AccountController@logout');

    Route::get('/is_author', 'CommonController@is_author');

    Route::get('/get_verification_code', 'CommonController@get_verification_code');//获取验证码

    Route::post('/verify_code', 'CommonController@verify_code');//验证验证码

    Route::get('/add_collection', 'CommonController@add_collection');//添加收藏

    Route::get('/add_attention', 'CommonController@add_attention');//添加关注

    Route::post('/upload_data_file', 'CommonController@upload_data_file');//上传资料

    Route::get('/data_download', 'CommonController@download_file');//下载文件

    Route::get('/download_test', 'CommonController@download_test');//下载文件前测试
    //接受的两个参数为  add_uid（可选，表示扣除登录用户种子的同时为 该id 的用户增加种子） price（必传 ，所需种子数）
    Route::get('/refresh_price', 'CommonController@refresh_price');//刷新积分 包括扣除积分的用户与获得积分的用户
    
    //type = 1 打码计算工具 type = 2 开奖号码对比 
    Route::get('/tools_use_record', 'CommonController@toolsRecord');

    Route::get('/get_mail_code', 'CommonController@get_mail_code');//获取邮箱验证码

    Route::get('/verify_mail', 'CommonController@verify_mail');//验证邮箱链接

    Route::get('/flush_limit_by_ip', 'CommonController@flush_limit_by_ip');

    Route::get('/flush_trade_order', 'CommonController@flush_trade_order');

    Route::get('/change_read_status', 'CommonController@read_status');
});