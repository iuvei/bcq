<?php
/*
|--------------------------------------------------------------------------
| Service Routes
*/

/*->middleware('throttle:1,5')*/;

Route::get('/lottery', 'Service\LotteryController@lottery');

Route::get('/issue/{lottery}/{issue}', 'Service\LotteryController@issue');

Route::get('/issue_each', 'Service\LotteryController@issue_each');

Route::get('/get_news/{fun}', 'Service\QueryController@getNews');/*->middleware('throttle:1,5')*/;

Route::get('/key', 'Service\KeyController@key');

Route::get('/getKey', 'Service\KeyController@getKey');

Route::get('/test', 'Service\TestController@test');

