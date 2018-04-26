<?php
/**
 * Created by PhpStorm.
 * User: cao13
 * Date: 2017/11/22
 * Time: 9:45
 */
Route::group(['prefix'=>'account'],function () {

    Route::post('/register', 'Front\AccountController@register');

    Route::post('/login', 'Front\AccountController@login');

    Route::post('/reset_password', 'Front\AccountController@resetPassword');

});

//获取页面内的组件数据
Route::group(['prefix'=>'components'],function () {

    Route::get('/get_right_list', 'Front\ComponentsController@get_right_list');

    Route::get('/get_mail_count', 'Front\ComponentsController@get_mail_count');

    Route::get('/get_cat_list', 'Front\ComponentsController@get_cat_list');

    Route::get('/get_special', 'Front\ComponentsController@get_special');

    Route::get('/get_news', 'Front\ComponentsController@get_news');

    Route::get('/get_user_data', 'Front\ComponentsController@get_user_data');

    Route::get('/get_report', 'Front\ComponentsController@get_report');

    Route::get('/get_business', 'Front\ComponentsController@get_business');

    Route::get('/get_platform', 'Front\ComponentsController@get_platform');

    Route::get('/get_author', 'Front\ComponentsController@get_author'); 

    Route::get('/get_hot_news', 'Front\ComponentsController@get_hot_news');

    Route::get('/get_hot_special', 'Front\ComponentsController@get_hot_special');

    Route::get('/get_hot_question', 'Front\ComponentsController@get_hot_question');

    Route::get('/get_exhibition', 'Front\ComponentsController@get_new_exhibition');

    Route::get('/get_flash', 'Front\ComponentsController@get_flash');

    Route::get('/get_hot_download', 'Front\ComponentsController@get_hot_download');

    Route::get('/get_week_hot_news', 'Front\ComponentsController@get_week_hot_news');

    Route::get('/get_notice_list', 'Front\ComponentsController@get_notice_list');

    Route::get('/get_exhibition_news', 'Front\ComponentsController@get_exhibition_news');    

    Route::get('/get_brief_list', 'Front\ComponentsController@get_brief_list');    

    Route::get('/search', 'CommonController@Search');//搜索

    Route::get('/get_income', 'Front\ComponentsController@getIncome');

    Route::get('/get_cats', 'Front\ComponentsController@getNewsCats');

    Route::get('/get_game_info', 'Front\ComponentsController@GetGameInfo');

});

Route::group(['prefix'=>'home'],function () {
    //首页渲染
    Route::get('/render','Front\HomePageController@render');
    //左边栏渲染
    Route::get('/left_render','Front\HomePageController@left_render');
    //获取news信息
    Route::get('/falls_render','Front\HomePageController@falls_render');

    Route::get('/falls_test','Front\HomePageController@falls_test');

    Route::get('/get_news_list','Front\HomePageController@getNewsList');
    //获取问答信息
    Route::get('/get_question_list','Front\HomePageController@getQuestionList');
    //用户资料列表
    Route::get('/get_user_data_list','Front\HomePageController@getUserDataList');
    //上传微动态图片
    Route::post('/upload_image','Front\HomePageController@UploadImage');

});


Route::group(['prefix'=>'news'],function (){
    Route::get('/render','Front\NewsPageController@render');
    Route::get('/get_news_list','Front\NewsPageController@getNewsList');
});

Route::group(['prefix'=>'auth_list'],function (){
    Route::get('/render','Front\AuthListPageController@render');
    Route::get('/get_news','Front\AuthListPageController@authorNews');
    Route::get('/get_author_list','Front\AuthListPageController@getAuthorList');
});

Route::group(['prefix'=>'applicant_auth'],function (){
    Route::post('/add_auth','Front\ApplicantAuthController@addAuth');
});

Route::group(['prefix'=>'trend'],function (){
    Route::get('/render','Front\TrendPageController@render');
    Route::post('/add_trend','Front\TrendPageController@addTrend');
    Route::get('/get_trend_list','Front\TrendPageController@getTrendList');
    Route::get('/add_view','Front\TrendPageController@addView');   
});

Route::group(['prefix'=>'report'],function () {
    Route::get('/render','Front\ReportPageController@render');
    Route::get('/get_report_list','Front\ReportPageController@getReportList');
});

Route::group(['prefix'=>'exhibition'],function () {
    Route::get('/render','Front\ExhibitionPageController@render');
    Route::get('/get_exhibition_list','Front\ExhibitionPageController@getExhibitionList');
});

Route::group(['prefix'=>'special'],function () {
    Route::get('/render','Front\SpecialPageController@render');
    Route::get('/get_special_list','Front\SpecialPageController@getSpecialList');
});

Route::group(['prefix'=>'flash'],function () {
    Route::get('/render','Front\FlashPageController@render');
    Route::get('/collection','Front\FlashPageController@addNewsCollection');
    Route::get('/attention','Front\FlashPageController@addAttention');
});

Route::group(['prefix'=>'userdata'],function () {
    Route::get('/render','Front\UserDataPageController@render');
    Route::get('/get_userdata_list','Front\UserDataPageController@getUserdataList'); 
});

Route::group(['prefix'=>'mydata'],function () {//
    Route::get('/render','Front\MyDataPageController@render');
    Route::get('/get_upload_list','Front\MyDataPageController@getUploadList');
    Route::get('/get_download_list','Front\MyDataPageController@getDownloadList');
    Route::get('/get_mydata_list','Front\MyDataPageController@getUserdataList'); 
    Route::get('/delete','Front\MyDataPageController@delete'); 
    Route::get('/edit','Front\MyDataPageController@edit');     
    Route::get('/get_count','Front\MyDataPageController@get_count');      
});

Route::group(['prefix'=>'enterprise'],function () {//企业库
    Route::get('/render','Front\EnterprisePageController@render');
    Route::post('/filter','Front\EnterprisePageController@filter');
    Route::match(['get', 'post'],'/add_enterprise', 'Front\EnterprisePageController@addEnterprise');
});

Route::group(['prefix'=>'cash'],function () {//现金网
    Route::get('/render','Front\CashPageController@render');
    Route::post('/filter','Front\CashPageController@filter');
    Route::get('/get_more','Front\CashPageController@getMore');
    Route::match(['get', 'post'],'/add_cash', 'Front\CashPageController@addCash');
});

Route::group(['prefix'=>'platform'],function () {
    Route::get('/render','Front\PlatformPageController@render');
    Route::get('/filter','Front\PlatformPageController@filter');
    Route::get('/get_more','Front\PlatformPageController@getMore');
});

Route::group(['prefix'=>'business'],function () {//商讯页面
    Route::get('/render','Front\BusinessPageController@render');
    Route::get('/filter','Front\BusinessPageController@filter');
    Route::get('/get_more','Front\BusinessPageController@getMore');
});

Route::group(['prefix'=>'trade'],function () {//商讯发布页面
    Route::get('/get_platform_opt','Front\PbPublishController@get_platform_opt');
    Route::get('/get_business_opt','Front\PbPublishController@get_business_opt');
    Route::post('/platform_publish','Front\PbPublishController@platform_publish');
    Route::post('/business_publish','Front\PbPublishController@business_publish');
    Route::post('/upload_picture','Front\PbPublishController@uploadPicture');
    Route::get('/get_detail','Front\PbPublishController@getDetail');    
});

Route::group(['prefix'=>'game'],function () {//游戏商页面
    Route::get('/render','Front\GamePageController@render');
    Route::get('/filter','Front\GamePageController@filter');
});

Route::group(['prefix'=>'gameinfo'],function () {//游戏商页面
    Route::get('/render','Front\GameInfoController@render');
    Route::get('/get_more','Front\GameInfoController@GetMore');
});

Route::group(['prefix'=>'question'],function () {//互动问答页面
    Route::get('/render','Front\QuestionPageController@render');
    Route::get('/get_more','Front\QuestionPageController@getMore');
    Route::get('/news_collection','Front\QuestionPageController@addNewsCollection');//资讯收藏
    Route::get('/question_collection','Front\QuestionPageController@addQuestionCollection');//收藏问题
    Route::get('/question_search','Front\QuestionPageController@questionSearch');//搜索问题
    Route::post('/new_question','Front\QuestionPageController@newQuestion');//提出新问题
    Route::post('/new_question_render','Front\QuestionPageController@newQuestionRender');//编辑问题 
});

Route::group(['prefix'=>'question_details'],function () {//互动问答详情页面

    Route::get('/render','Front\QuestionDetailPageController@render');//已解决问题详情页

    Route::post('/answer_question','Front\QuestionDetailPageController@answerQuestion');//提交我的回答
/*
    Route::get('/user_answers','Front\QuestionDetailPageController@userAnswer');//我的所有回答

*/    
    Route::get('/user_questions','Front\QuestionDetailPageController@userQuestion');//我的所有问题

    Route::get('/delete_question','Front\QuestionDetailPageController@deleteUserQuestion');//用户删除提问

    Route::get('/accept_question','Front\QuestionDetailPageController@acceptAnswer');//用户删除提问
});

Route::group(['prefix'=>'news_details'],function (){//资讯详情页

    Route::get('/render','Front\NewsDetailsPageController@render');

    Route::get('/collection','Front\NewsDetailsPageController@addCollection');

    Route::get('/attention','Front\NewsDetailsPageController@addAttention');

    Route::get('/add_comment','Front\NewsDetailsPageController@addComment');

    Route::get('/add_comment_top','Front\NewsDetailsPageController@addCommentTop');

    Route::get('/get_comment_list','Front\NewsDetailsPageController@getCommentList');

    Route::get('/add_top','Front\NewsDetailsPageController@addTop');

    Route::get('/add_complaint','Front\NewsDetailsPageController@addComplaint');

});

Route::group(['prefix'=>'micro'],function (){

    Route::post('/new_micro','Front\MicroController@NewMicro');
    
    Route::get('/get_detail','Front\MicroController@GetMicroDetail');

    Route::get('/add_comment','Front\MicroController@addComment');

    Route::get('/add_comment_top','Front\MicroController@addCommentTop');

    Route::get('/add_complaint','Front\NewsDetailsPageController@addComplaint');

    Route::get('/get_comment_list','Front\MicroController@getCommentList');

    Route::get('/get_relate_micro','Front\MicroController@GetRelateMicro');    

    Route::get('/get_recommand_micro','Front\MicroController@GetRecommendMicro');    

});

Route::group(['prefix'=>'user_data_details'],function (){//用户资料详情页

    Route::get('/render','Front\UserDataDetailsPageController@render');

    Route::get('/add_comment','Front\UserDataDetailsPageController@addComment');

    Route::get('/add_comment_top','Front\UserDataDetailsPageController@addCommentTop');

    Route::get('/add_complaint','Front\UserDataDetailsPageController@addComplaint');

    Route::get('/get_comment_list','Front\UserDataDetailsPageController@getCommentList');
    
});

Route::group(['prefix'=>'report_details'],function (){//数据报告详情页

    Route::get('/render','Front\ReportDetailsPageController@render');

    Route::get('/add_comment','Front\ReportDetailsPageController@addComment');

    Route::get('/add_comment_top','Front\ReportDetailsPageController@addCommentTop');

    Route::get('/add_complaint','Front\ReportDetailsPageController@addComplaint');

    Route::get('/get_comment_list','Front\ReportDetailsPageController@getCommentList');
});

Route::group(['prefix'=>'data_upload'],function () {//数据报告详情页

    Route::get('/render','Front\DataUploadPageController@render');

    Route::post('/data_submit','Front\DataUploadPageController@DataUpload');

});

Route::group(['prefix'=>'user_zone'],function () {

    Route::get('/render','Front\User\UserZoneController@render');

    Route::get('/get_cat_list','Front\User\UserZoneController@GetCatList');    

    Route::get('/get_news','Front\User\UserZoneController@getNewsList');//获取更多内容

    Route::get('/get_trend','Front\User\UserZoneController@getTrendList');//获取更多内容

    Route::get('/get_data','Front\User\UserZoneController@getDataList');//获取更多内容

    Route::get('/get_business','Front\User\UserZoneController@getBusinessList');//获取更多内容

    Route::get('/get_platform','Front\User\UserZoneController@getPlatformList');//获取更多内容

    Route::get('/get_question','Front\User\UserZoneController@getQuestionList');//获取更多内容

    Route::get('/get_micro','Front\User\UserZoneController@getMicroList');

    Route::get('/apply_author','Front\User\UserZoneController@applyAuthor');//申请成为作者

    Route::get('/build_class','Front\User\UserZoneController@buildNewClass');//创建新分类

    Route::get('/get_comment','Front\User\UserZoneController@getCommentList');//获取所有评论

    Route::get('/get_fans','Front\User\UserZoneController@getFansList');//获取所有粉丝

    Route::get('/get_attention','Front\User\UserZoneController@getAttentionList');//获取所有粉丝

    Route::post('/send_message','Front\User\UserZoneController@sendMessage');//发送私信
});

Route::group(['prefix'=>'creation_page'],function () {//作者创作页面

    Route::get('/render','Front\User\CreationPageController@render');

    Route::get('/build_class','Front\User\CreationPageController@buildNewClass');//创建新分类

    Route::get('/get_content','Front\User\CreationPageController@getContent');//查询内容

    Route::post('/upload_picture','Front\User\CreationPageController@uploadPicture');

    Route::post('/upload_picture_base64','Front\User\CreationPageController@uploadPictureBase64');

    Route::post('/create_creation','Front\User\CreationPageController@createCreation');//创建新分类

    Route::get('/delete_creation','Front\User\CreationPageController@deleteCreation');//删除创作

    Route::get('/move_creation','Front\User\CreationPageController@moveCreation');//移动创作到新组

    Route::get('/restore_creation','Front\User\CreationPageController@restoreCreation');//恢复创作

    Route::get('/rename_class','Front\User\CreationPageController@renameClass');//修改创作名称

    Route::get('/get_brief','Front\User\CreationPageController@get_brief');

    Route::get('/lock_news','Front\User\CreationPageController@lock_news');

});


Route::group(['prefix'=>'special_details'],function () {

    Route::get('/render','Front\SpecialDetailsPageController@render');

    Route::get('/get_special_news','Front\SpecialDetailsPageController@getSpecialNews');
});

Route::group(['prefix'=>'cash_details'],function () { //现金网详情页

    Route::get('/render','Front\CashDetailsPageController@render');

    Route::post('/add_mark','Front\CashDetailsPageController@addMark');
});

Route::group(['prefix'=>'enterprise_details'],function () { //企业库详情页

    Route::get('/render','Front\EnterpriseDetailsPageController@render');

});

Route::group(['prefix'=>'business_details'],function () { //供求商讯详情页

    Route::get('/render','Front\BusinessDetailsPageController@render');

    Route::get('/add_top','Front\BusinessDetailsPageController@addTop');

    Route::get('/add_collection','Front\BusinessDetailsPageController@addCollection');

    Route::get('/confirm/{bid}/{plate_id}','Front\BusinessDetailsPageController@confirm');
});

Route::group(['prefix'=>'platform_details'],function () { //招商代理详情页

    Route::get('/render','Front\PlatformDetailPageController@render');

    Route::get('/add_top','Front\PlatformDetailPageController@addTop');

    Route::get('/add_collection','Front\PlatformDetailPageController@addCollection');

    Route::get('/confirm/{pid}/{plate_id}','Front\PlatformDetailPageController@confirm');

});

Route::group(['prefix'=>'user_center'],function () {//个人中心

    Route::get('/user_info_render','Front\User\UserCenterController@user_info_render');

    Route::get('/mail_render','Front\User\UserCenterController@mail_render');

    Route::post('/change_image','Front\User\UserCenterController@change_image');

    Route::post('/change_signature_image','Front\User\UserCenterController@change_signature_image');

    Route::get('/change_signature','Front\User\UserCenterController@change_signature');

    Route::post('/modify_info','Front\User\UserInfoController@modify_info');
    
    Route::get('/user_record','Front\User\RecordController@user_record');    

    Route::get('/report_bar','Front\User\IncomeController@getReportBar');    

    Route::get('/publsih_list','Front\User\IncomeController@getRecordList');    

    Route::post('/takeout_request','Front\User\IncomeController@takeoutRequest');    

    Route::get('/get_income_iist','Front\User\IncomeController@getIncomeList');    

    Route::post('/takeout_cancel','Front\User\IncomeController@takeoutCancel');    

});

Route::group(['prefix'=>'user_mail'],function () {//个人中心 私信 站内信

    Route::get('/delete_mail','Front\User\UserMailController@delete_mail');

    Route::get('/view_mail','Front\User\UserMailController@view_mail');

    Route::get('/get_mail','Front\User\UserMailController@get_mail');

    Route::get('/get_message','Front\User\UserMailController@get_message');

    Route::post('/send_message','Front\User\UserMailController@send_message');
});

Route::group(['prefix'=>'user_collection'],function () {//个人收藏

    Route::get('/render','Front\User\UserCollectionController@render');

    Route::get('/get_more','Front\User\UserCollectionController@get_more');

});

Route::group(['prefix'=>'user_publish'],function () {//个人收藏

    Route::get('/render','Front\User\UserPublishController@render');

    Route::get('/get_more','Front\User\UserPublishController@get_more');

    Route::get('/delete','Front\User\UserPublishController@delete');

});

Route::group(['prefix'=>'user_task'],function () { //用户个人任务

    Route::get('/render','Front\User\UserTaskController@render');

});

Route::group(['prefix'=>'exhibition_details'],function () {

    Route::get('/render','Front\ExhibitionDetailsPageController@render');

    Route::get('/get_exhibition_news','Front\ExhibitionDetailsPageController@getExhibitionNews');

});

Route::group(['prefix'=>'feedback'],function () { //企业库详情页

    Route::post('/add_feedback','Front\FeedbackPageController@addFeedback');

});

Route::group(['prefix'=>'pusher'],function () { //消息推送

    Route::get('/test','Front\PusherController@test');

});