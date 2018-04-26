<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
*/
Route::match(['get', 'post'],'/login', 'Admin\LoginController@login')->middleware('throttle:5,1')->name('login');
Route::get('/logout', 'Admin\LoginController@logout');

Route::group(['middleware' => 'auth:admin'], function(){

    Route::get('/', 'Admin\IndexController@index');

    Route::group(['prefix'=>'index'],function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::get('/index', 'Admin\IndexController@index');
        Route::get('/tips', 'Admin\IndexController@tips');
        Route::get('/getCount', 'Admin\IndexController@getCount');
    });

    /*资讯管理 start*/
        Route::group(['prefix'=>'news'],function () {
            Route::match(['get', 'post'],'/news_list', 'Admin\NewsController@news_list');
            Route::get('/news_ajax_list', 'Admin\NewsController@news_ajax_list');
            Route::get('/news_review', 'Admin\NewsController@news_review');
            Route::match(['get', 'post'],'/news_add', 'Admin\NewsController@news_add');
            Route::match(['get', 'post'],'/news_edit/{obj}', 'Admin\NewsController@news_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\NewsController@datastatus');
        });

        Route::group(['prefix'=>'news_category'],function () {
            Route::get('/category_list', 'Admin\NewsCategoryController@category_list');
            Route::match(['get', 'post'],'/category_add', 'Admin\NewsCategoryController@category_add');
            Route::match(['get', 'post'],'/category_edit/{obj}', 'Admin\NewsCategoryController@category_edit');
        });

        Route::group(['prefix'=>'key'],function () {
            Route::match(['get', 'post'], '/key_list', 'Admin\KeyController@key_list');
            Route::get('/key_ajax_list', 'Admin\KeyController@key_ajax_list');
            Route::match(['get', 'post'],'/key_edit/{obj}', 'Admin\KeyController@key_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\KeyController@datastatus');
        });

        Route::group(['prefix'=>'news_comment'],function () {
            Route::match(['get', 'post'], '/news_comment_list', 'Admin\NewsCommentController@news_comment_list');
            Route::get('/news_comment_ajax_list', 'Admin\NewsCommentController@news_comment_ajax_list');
            Route::get('/news_comment_review', 'Admin\NewsCommentController@news_comment_review');
            Route::match(['get', 'post'],'/news_comment_edit/{obj}', 'Admin\NewsCommentController@news_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\NewsCommentController@datastatus');
        });

        Route::group(['prefix'=>'trends'],function () {
            Route::match(['get', 'post'], '/trends_list', 'Admin\TrendsController@trends_list');
            Route::get('/trends_ajax_list', 'Admin\TrendsController@trends_ajax_list');
            Route::match(['get', 'post'], '/trends_review', 'Admin\TrendsController@trends_review');
            Route::match(['get', 'post'],'/trends_add', 'Admin\TrendsController@trends_add');
            Route::match(['get', 'post'],'/trends_edit/{obj}', 'Admin\TrendsController@trends_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\TrendsController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\TrendsController@ajax_get_file');
        });

        Route::group(['prefix'=>'trends_comment'],function () {
            Route::match(['get', 'post'], '/trends_comment_list', 'Admin\TrendsCommentController@trends_comment_list');
            Route::get('/trends_comment_ajax_list', 'Admin\TrendsCommentController@trends_comment_ajax_list');
            Route::get('/trends_comment_review', 'Admin\TrendsCommentController@trends_comment_review');
            Route::match(['get', 'post'],'/trends_comment_edit/{obj}', 'Admin\TrendsCommentController@trends_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\TrendsCommentController@datastatus');
        });


        Route::group(['prefix'=>'report'],function () {
            Route::match(['get', 'post'], '/report_list', 'Admin\ReportController@report_list');
            Route::get('/report_ajax_list', 'Admin\ReportController@report_ajax_list');
            Route::match(['get', 'post'],'/report_add', 'Admin\ReportController@report_add');
            Route::match(['get', 'post'],'/report_edit/{obj}', 'Admin\ReportController@report_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\ReportController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\ReportController@ajax_get_file');
        });

        Route::group(['prefix'=>'report_comment'],function () {
            Route::match(['get', 'post'], '/report_comment_list', 'Admin\ReportCommentController@report_comment_list');
            Route::get('/report_comment_ajax_list', 'Admin\ReportCommentController@report_comment_ajax_list');
            Route::match(['get', 'post'], '/report_comment_review', 'Admin\ReportCommentController@report_comment_review');
            Route::match(['get', 'post'],'/report_comment_edit/{obj}', 'Admin\ReportCommentController@report_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\ReportCommentController@datastatus');
        });

        Route::group(['prefix'=>'special'],function () {
            Route::match(['get', 'post'], '/special_list', 'Admin\SpecialController@special_list');
            Route::get('/special_ajax_list', 'Admin\SpecialController@special_ajax_list');
            Route::match(['get', 'post'],'/special_add', 'Admin\SpecialController@special_add');
            Route::match(['get', 'post'],'/special_edit/{obj}', 'Admin\SpecialController@special_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\SpecialController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\SpecialController@ajax_get_file');
        });

        Route::group(['prefix'=>'special_news'],function () {
            Route::match(['get', 'post'], '/special_news_list/{sid}', 'Admin\SpecialNewsController@special_news_list');
            Route::get('/special_news_ajax_list/{sid}', 'Admin\SpecialNewsController@special_news_ajax_list');
            Route::match(['get', 'post'],'/special_news_add/{sid}', 'Admin\SpecialNewsController@special_news_add');
            Route::match(['get', 'post'],'/special_news_ajax_add/{sid}', 'Admin\SpecialNewsController@special_news_ajax_add');
            Route::post('/special_news_insert/{obj}', 'Admin\SpecialNewsController@special_news_insert');
            Route::match(['get', 'post'],'/special_news_edit/{obj}', 'Admin\SpecialNewsController@special_news_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\SpecialNewsController@datastatus');
        });

        Route::group(['prefix'=>'show'],function () {
            Route::match(['get', 'post'], '/show_list', 'Admin\ShowController@show_list');
            Route::get('/show_ajax_list', 'Admin\ShowController@show_ajax_list');
            Route::match(['get', 'post'],'/show_add', 'Admin\ShowController@show_add');
            Route::match(['get', 'post'],'/show_edit/{obj}', 'Admin\ShowController@show_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\ShowController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\ShowController@ajax_get_file');
        });

        Route::group(['prefix'=>'show_news'],function () {
            Route::match(['get', 'post'], '/show_news_list/{sid}', 'Admin\ShowNewsController@show_news_list');
            Route::get('/show_news_ajax_list/{sid}', 'Admin\ShowNewsController@show_news_ajax_list');
            Route::match(['get', 'post'],'/show_news_add/{sid}', 'Admin\ShowNewsController@show_news_add');
            Route::match(['get', 'post'],'/show_news_ajax_add/{sid}', 'Admin\ShowNewsController@show_news_ajax_add');
            Route::post('/show_news_insert/{obj}', 'Admin\ShowNewsController@show_news_insert');
            Route::match(['get', 'post'],'/show_news_edit/{obj}', 'Admin\ShowNewsController@show_news_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\ShowNewsController@datastatus');
        });
    /*资讯管理 end*/

    /*快讯管理 start*/
        Route::group(['prefix'=>'flash'],function () {
            Route::match(['get', 'post'],'/flash_list', 'Admin\FlashController@flash_list');
            Route::get('/flash_ajax_list', 'Admin\FlashController@flash_ajax_list');
            Route::match(['get', 'post'],'/flash_add', 'Admin\FlashController@flash_add');
            Route::match(['get', 'post'],'/flash_edit/{obj}', 'Admin\FlashController@flash_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\FlashController@datastatus');
        });
    /*快讯管理 end*/

    /*资料管理 start*/
        Route::group(['prefix'=>'data'],function () {
            Route::match(['get', 'post'], '/data_list', 'Admin\DataController@data_list');
            Route::get('/data_ajax_list', 'Admin\DataController@data_ajax_list');
            Route::get('/data_review', 'Admin\DataController@data_review');
            Route::match(['get', 'post'],'/data_add', 'Admin\DataController@data_add');
            Route::match(['get', 'post'],'/data_edit/{obj}', 'Admin\DataController@data_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\DataController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\DataController@ajax_get_file');
        });

        Route::group(['prefix'=>'data_comment'],function () {
            Route::match(['get', 'post'], '/data_comment_list', 'Admin\DataCommentController@data_comment_list');
            Route::get('/data_comment_ajax_list', 'Admin\DataCommentController@data_comment_ajax_list');
            Route::get('/data_comment_review', 'Admin\DataCommentController@data_comment_review');
            Route::match(['get', 'post'],'/data_comment_edit/{obj}', 'Admin\DataCommentController@data_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\DataCommentController@datastatus');
        });

        Route::group(['prefix'=>'url'],function () {
            Route::match(['get', 'post'], '/url_list', 'Admin\UrlController@url_list');
            Route::get('/url_ajax_list', 'Admin\UrlController@url_ajax_list');
            Route::match(['get', 'post'],'/url_add', 'Admin\UrlController@url_add');
            Route::match(['get', 'post'],'/url_edit/{obj}', 'Admin\UrlController@url_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\UrlController@datastatus');
        });

        Route::group(['prefix'=>'url_category'],function () {
            Route::get('/category_list', 'Admin\UrlCategoryController@category_list');
            Route::match(['get', 'post'],'/category_add', 'Admin\UrlCategoryController@category_add');
            Route::match(['get', 'post'],'/category_edit/{obj}', 'Admin\UrlCategoryController@category_edit');
        });

        Route::group(['prefix'=>'cash'],function () {
            Route::match(['get', 'post'], '/cash_list', 'Admin\CashController@cash_list');
            Route::get('/cash_ajax_list', 'Admin\CashController@cash_ajax_list');
            Route::match(['get', 'post'],'/cash_add', 'Admin\CashController@cash_add');
            Route::match(['get', 'post'],'/cash_edit/{obj}', 'Admin\CashController@cash_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\CashController@datastatus');
        });

        Route::group(['prefix'=>'enterprise'],function () {
            Route::match(['get', 'post'], '/enterprise_list', 'Admin\EnterpriseController@enterprise_list');
            Route::get('/enterprise_ajax_list', 'Admin\EnterpriseController@enterprise_ajax_list');
            Route::match(['get', 'post'],'/enterprise_add', 'Admin\EnterpriseController@enterprise_add');
            Route::match(['get', 'post'],'/enterprise_edit/{obj}', 'Admin\EnterpriseController@enterprise_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\EnterpriseController@datastatus');
        });
    /*资料管理 end*/

    /*交易管理 start*/
        Route::group(['prefix'=>'business'],function () {
            Route::match(['get', 'post'], '/business_list/{type}', 'Admin\BusinessController@business_list');
            Route::get('/business_ajax_list/{type}', 'Admin\BusinessController@business_ajax_list');
            Route::get('/business_review/{type}', 'Admin\BusinessController@business_review');
            Route::match(['get', 'post'],'/business_add/{type}', 'Admin\BusinessController@business_add');
            Route::match(['get', 'post'],'/business_edit/{obj}', 'Admin\BusinessController@business_edit');
            Route::post('/type_change/{obj}', 'Admin\BusinessController@type_change');
            Route::match(['get', 'post'],'/datastatus', 'Admin\BusinessController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\BusinessController@ajax_get_file');
        });

        Route::group(['prefix'=>'bcategory'],function () {
            Route::get('/category_list', 'Admin\BcategoryController@category_list');
            Route::match(['get', 'post'],'/category_add', 'Admin\BcategoryController@category_add');
            Route::match(['get', 'post'],'/category_edit/{obj}', 'Admin\BcategoryController@category_edit');
        });

        Route::group(['prefix'=>'platform'],function () {
            Route::match(['get', 'post'], '/platform_list/{type}', 'Admin\PlatformController@platform_list');
            Route::get('/platform_ajax_list/{type}', 'Admin\PlatformController@platform_ajax_list');
            Route::get('/platform_review/{type}', 'Admin\PlatformController@platform_review');
            Route::match(['get', 'post'],'/platform_add/{type}', 'Admin\PlatformController@platform_add');
            Route::match(['get', 'post'],'/platform_edit/{obj}', 'Admin\PlatformController@platform_edit');
            Route::post('/type_change/{obj}', 'Admin\PlatformController@type_change');
            Route::match(['get', 'post'],'/datastatus', 'Admin\PlatformController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\PlatformController@ajax_get_file');
        });
    /*交易管理 end*/

    /*服务管理 start*/
        Route::group(['prefix'=>'gamestore'],function () {
        Route::match(['get', 'post'], '/gamestore_list', 'Admin\GamestoreController@gamestore_list');
        Route::get('/gamestore_ajax_list', 'Admin\GamestoreController@gamestore_ajax_list');
        Route::match(['get', 'post'],'/gamestore_add', 'Admin\GamestoreController@gamestore_add');
        Route::match(['get', 'post'],'/gamestore_edit/{obj}', 'Admin\GamestoreController@gamestore_edit');
        Route::match(['get', 'post'],'/datastatus', 'Admin\GamestoreController@datastatus');
        Route::match(['get', 'post'],'/gamestore_co_list/{gid}', 'Admin\GamestoreController@gamestore_co_list');
        Route::match(['get', 'post'],'/gamestore_co_edit/{obj}', 'Admin\GamestoreController@gamestore_co_edit');
    });


    Route::group(['prefix'=>'gamestore_category'],function () {
        Route::get('/category_list', 'Admin\GamestoreCategoryController@category_list');
        Route::match(['get', 'post'],'/category_add', 'Admin\GamestoreCategoryController@category_add');
        Route::match(['get', 'post'],'/category_edit/{obj}', 'Admin\GamestoreCategoryController@category_edit');
    });
    /*服务管理 end*/

    /*互动管理 start*/
        Route::group(['prefix'=>'question'],function () {
            Route::match(['get', 'post'], '/question_list', 'Admin\QuestionController@question_list');
            Route::get('/question_ajax_list', 'Admin\QuestionController@question_ajax_list');
            Route::match(['get', 'post'], '/question_review', 'Admin\QuestionController@question_review');
            Route::match(['get', 'post'],'/question_add', 'Admin\QuestionController@question_add');
            Route::match(['get', 'post'],'/question_edit/{obj}', 'Admin\QuestionController@question_edit');
            Route::match(['get', 'post'],'/question_adoption/{obj}', 'Admin\QuestionController@question_adoption');
            Route::match(['get', 'post'],'/datastatus', 'Admin\QuestionController@datastatus');
        });

        Route::group(['prefix'=>'answer'],function () {
            Route::match(['get', 'post'], '/answer_list/{qid}', 'Admin\AnswerController@answer_list');
            Route::match(['get', 'post'],'/answer_add/{obj}', 'Admin\AnswerController@answer_add');
            Route::match(['get', 'post'],'/answer_edit/{obj}', 'Admin\AnswerController@answer_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\AnswerController@datastatus');
            Route::match(['get', 'post'], '/answer_all_list', 'Admin\AnswerController@answer_all_list');
            Route::match(['get', 'post'], '/answer_ajax_all_list', 'Admin\AnswerController@answer_ajax_all_list');
        });

        Route::group(['prefix'=>'answer_comment'],function () {
            Route::match(['get', 'post'], '/answer_comment_list', 'Admin\AnswerCommentController@answer_comment_list');
            Route::get('/answer_comment_ajax_list', 'Admin\AnswerCommentController@answer_comment_ajax_list');
            Route::get('/answer_comment_review', 'Admin\AnswerCommentController@answer_comment_review');
            Route::match(['get', 'post'],'/answer_comment_edit/{obj}', 'Admin\AnswerCommentController@answer_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\AnswerCommentController@datastatus');
        });

    /*互动管理 end*/

    /*用户管理 start*/
        Route::group(['prefix'=>'user'],function () {
            Route::match(['get', 'post'], '/user_list', 'Admin\UserController@user_list');
            Route::get('/user_ajax_list', 'Admin\UserController@user_ajax_list');
            Route::match(['get', 'post'],'/user_add', 'Admin\UserController@user_add');
            Route::match(['get', 'post'],'/user_edit/{obj}', 'Admin\UserController@user_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\UserController@datastatus');
        });

        Route::group(['prefix'=>'level'],function () {
            Route::get('/level_list', 'Admin\LevelController@level_list');
            Route::match(['get', 'post'],'/level_add', 'Admin\LevelController@level_add');
            Route::match(['get', 'post'],'/level_edit/{obj}', 'Admin\LevelController@level_edit');
        });

        Route::group(['prefix'=>'author'],function () {
            Route::match(['get', 'post'], '/author_list', 'Admin\AuthorController@author_list');
            Route::get('/author_ajax_list', 'Admin\AuthorController@author_ajax_list');
            Route::match(['get', 'post'],'/author_add', 'Admin\AuthorController@author_add');
            Route::match(['get', 'post'],'/user_ajax_list', 'Admin\AuthorController@user_ajax_list');
            Route::match(['get', 'post'],'/author_edit/{obj}', 'Admin\AuthorController@author_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\AuthorController@datastatus');
        });

        Route::group(['prefix'=>'applicant'],function () {
            Route::match(['get', 'post'], '/applicant_list', 'Admin\ApplicantAuthController@applicant_list');
            Route::get('/applicant_ajax_list', 'Admin\ApplicantAuthController@applicant_ajax_list');
            Route::get('/applicant_review', 'Admin\ApplicantAuthController@applicant_review');
            Route::post('/audit_add', 'Admin\ApplicantAuthController@auditAdd');
            Route::get('/applicant_list_edit', 'Admin\ApplicantAuthController@applicant_list_edit');
            Route::post('/applicant_edit/{id}', 'Admin\ApplicantAuthController@applicant_edit');
        });
    /*用户管理 end*/

        Route::group(['prefix'=>'tools'],function () {
            Route::post('/file_upload', 'Admin\ToolsController@file_upload');
        });

    /*系统管理 start*/
        Route::group(['prefix'=>'slide'],function () {
            Route::match(['get', 'post'],'/slide_list', 'Admin\SlideController@slide_list');
            Route::get('/slide_ajax_list', 'Admin\SlideController@slide_ajax_list');
            Route::match(['get', 'post'],'/slide_add/{type}', 'Admin\SlideController@slide_add');
            Route::get('/slide_ajax_add/{type}', 'Admin\SlideController@slide_ajax_add');
            Route::match(['get', 'post'],'/slide_edit/{obj}', 'Admin\SlideController@slide_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\SlideController@datastatus');
            Route::post('/slide_insert/{type}', 'Admin\SlideController@slide_insert');

        });

        Route::group(['prefix'=>'fall'],function () {
            Route::match(['get', 'post'],'/fall_list', 'Admin\FallController@fall_list');
            Route::get('/fall_ajax_list', 'Admin\FallController@fall_ajax_list');
            Route::match(['get', 'post'],'/fall_add/{type}', 'Admin\FallController@fall_add');
            Route::get('/fall_ajax_add/{type}', 'Admin\FallController@fall_ajax_add');
            Route::match(['get', 'post'],'/datastatus', 'Admin\FallController@datastatus');
            Route::post('/fall_insert/{type}', 'Admin\FallController@fall_insert');
        });

        Route::group(['prefix'=>'components_config'],function () {
            Route::get('/components_config_list', 'Admin\ComponentsConfigController@components_config_list');
            Route::match(['get', 'post'],'/components_config_edit/{obj}', 'Admin\ComponentsConfigController@components_config_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\ComponentsConfigController@datastatus');
        });

        Route::group(['prefix'=>'admin'],function () {
                Route::match(['get', 'post'], '/admin_list', 'Admin\AdminController@admin_list');
                Route::get('/admin_ajax_list', 'Admin\AdminController@admin_ajax_list');
                Route::match(['get', 'post'],'/admin_add', 'Admin\AdminController@admin_add');
                Route::match(['get', 'post'],'/admin_edit/{obj}', 'Admin\AdminController@admin_edit');
                Route::match(['get', 'post'],'/datastatus', 'Admin\AdminController@datastatus');
            });

        Route::group(['prefix'=>'order'],function () {
                Route::match(['get', 'post'],'/order_list', 'Admin\OrderController@order_list');
                Route::get('/order_ajax_list', 'Admin\OrderController@order_ajax_list');
            });

        Route::group(['prefix'=>'mail'],function () {
            Route::match(['get', 'post'], '/mail_list', 'Admin\MailController@mail_list');
            Route::get('/mail_ajax_list', 'Admin\MailController@mail_ajax_list');
            Route::match(['get', 'post'],'/mail_add', 'Admin\MailController@mail_add');
            Route::match(['get', 'post'],'/mail_edit/{obj}', 'Admin\MailController@mail_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\MailController@datastatus');
        });

        Route::group(['prefix'=>'message'],function () {
            Route::match(['get', 'post'], '/message_send_add/{uid}/{table}/{id}/{type}/{tname}/{ctime}', 'Admin\MessageSendController@message_send_add');
        });

        Route::group(['prefix'=>'mail_send'],function () {
            Route::match(['get', 'post'], '/mail_send_list/{mid}', 'Admin\MailSendController@mail_send_list');
            Route::get('/mail_send_ajax_list/{mid}', 'Admin\MailSendController@mail_send_ajax_list');
            Route::match(['get', 'post'],'/mail_send_add/{mid}', 'Admin\MailSendController@mail_send_add');
            Route::match(['get', 'post'],'/mail_send_ajax_add/{mid}', 'Admin\MailSendController@mail_send_ajax_add');
            Route::post('/mail_send_insert/{obj}', 'Admin\MailSendController@mail_send_insert');
            Route::match(['get', 'post'],'/mail_send_edit/{obj}', 'Admin\MailSendController@mail_send_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\MailSendController@datastatus');
        });

        Route::group(['prefix'=>'notice'],function () {
            Route::match(['get', 'post'], '/notice_list', 'Admin\NoticeController@notice_list');
            Route::get('/notice_ajax_list', 'Admin\NoticeController@notice_ajax_list');
            Route::match(['get', 'post'],'/notice_add', 'Admin\NoticeController@notice_add');
            Route::match(['get', 'post'],'/notice_edit/{obj}', 'Admin\NoticeController@notice_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\NoticeController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\NoticeController@ajax_get_file');
        });

        Route::group(['prefix'=>'feedback'],function () {
            Route::match(['get', 'post'], '/feedback_list', 'Admin\FeedbackController@feedback_list');
            Route::get('/feedback_review', 'Admin\FeedbackController@feedback_review');
            Route::match(['get', 'post'],'/feedback_edit/{obj}', 'Admin\FeedbackController@feedback_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\FeedbackController@datastatus');
        });

        Route::group(['prefix'=>'official'],function () {
            Route::match(['get', 'post'], '/official_list', 'Admin\OfficialController@official_list');
            Route::get('/official_ajax_list', 'Admin\OfficialController@official_ajax_list');
            Route::match(['get', 'post'],'/official_add', 'Admin\OfficialController@official_add');
            Route::match(['get', 'post'],'/official_edit/{obj}', 'Admin\OfficialController@official_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\OfficialController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\OfficialController@ajax_get_file');
        });

        Route::group(['prefix'=>'income'],function () {
            Route::match(['get', 'post'], '/income_list', 'Admin\IncomeController@income_list');
            Route::get('/income_ajax_list', 'Admin\IncomeController@income_ajax_list');
            Route::match(['get', 'post'],'/income_edit/{obj}', 'Admin\IncomeController@income_edit');
        });

        Route::group(['prefix'=>'micro'],function () {
            Route::match(['get', 'post'], '/micro_list', 'Admin\MicroController@micro_list');
            Route::get('/micro_ajax_list', 'Admin\MicroController@micro_ajax_list');
            Route::match(['get', 'post'],'/micro_edit/{obj}', 'Admin\MicroController@micro_edit');
            Route::match(['get', 'post'],'/ajax_get_file/{obj}', 'Admin\MicroController@ajax_get_file');
            Route::match(['get', 'post'],'/datastatus', 'Admin\MicroController@datastatus');
            Route::get('/ajax_get_file/{obj}', 'Admin\MicroController@ajax_get_file');
        });

        Route::group(['prefix'=>'micro_comment'],function () {
            Route::match(['get', 'post'], '/micro_comment_list', 'Admin\MicroCommentController@micro_comment_list');
            Route::get('/micro_comment_ajax_list', 'Admin\MicroCommentController@micro_comment_ajax_list');
            Route::get('/micro_comment_review', 'Admin\MicroCommentController@micro_comment_review');
            Route::match(['get', 'post'],'/micro_comment_edit/{obj}', 'Admin\MicroCommentController@micro_comment_edit');
            Route::match(['get', 'post'],'/datastatus', 'Admin\MicroCommentController@datastatus');
        });

    /*系统管理 end*/
});
