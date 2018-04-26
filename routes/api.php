<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'front'],function () {

    Route::group(['prefix'=>'navigation'],function () {

        Route::get('/render','Front\NavigationPageController@render');

    });

    Route::group(['prefix'=>'cash'],function () {//现金网

        Route::get('/render','Front\CashPageController@render');

        Route::get('/filter','Front\CashPageController@filter');
    });

    Route::group(['prefix'=>'lottery'],function () {//现金网

        Route::match(['get', 'post'],'/render','Front\LotteryController@render');

        Route::post('/search','Front\LotteryController@search');

        Route::get('/filter','Front\LotteryController@filter');
    });

});

Route::group(['prefix'=>'bzp_push'],function () {

    Route::post('/company_info','Front\BzpApiController@AddCompanyInfo');

    Route::post('/company_comment_info','Front\BzpApiController@AddCompanyCommentInfo');

    Route::get('/test','Front\BzpApiController@test');
});

Route::post('/set_lottery', 'Service\LotteryController@setLottery');

Route::post('/lottery_notice', 'Service\LotteryController@LotteryNotice');
