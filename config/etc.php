<?php

return [
    'account'=>[
        'login_key'=>'user_id'
    ],
    'homepage'=>[//首页
        //首页id
        'page_id'=>1,
        //首页各个数据限制条数
        'news'=>['render_limit'=>20,'limit'=>20],
        'slide'=>['slide_limit'=>10,'secondary_limit'=>3],
        'falls'=>['render_limit'=>20,'limit'=>20]
    ],
    'news'=>[//资讯页面
        'page_id'=>2, //产业资讯页面
        'news'=>['render_limit'=>30,'limit'=>10]
    ],
    'auth_list'=>[//专栏作者页面
        'page_id'=>3,
        'author'=>['render_limit'=>30,'limit'=>30],
    ],
    'trend'=>[//产品动态页面
        'page_id'=>4,
        'trend' => ['render_limit'=>20,'limit'=>10], 
        'author'=> ['render_limit'=>4,'limit'=>4]
    ],
    'report'=>[//数据报告页面
        'page_id'=>5,
        'report'=>['render_limit'=>20,'limit'=>10] 
    ],
    'real_time_news'=>[//7x24小时快讯页面
        'page_id'=>6,
        'limit'=>['news' => 10, 'author'=>10, 'flash'=>20]
    ],
    'user_data'=>[//用户资料下载页面
        'page_id'=>7,
        'user_data'=>['render_limit'=>20,'limit'=>10] 
    ],
    'navigation'=>[//优质导航页面
        'page_id'=>8,
    ],
    'enterprise'=>[//企业库
        'page_id'=>9,
        'limit'=>['enterprise'=>24]
    ],
    'cash'=>[//企业库
        'page_id'=>10,
        'limit'=>['cash'=>24]
    ],
    'platform'=>[
        'page_id'=>11,
        'platform'=> ['render_limit'=>20,'limit'=>20]//渠道商
    ],
    'business'=>[
        'page_id'=>12,
        'business'=> ['render_limit'=>20,'limit'=>20]
    ],
    'game'=>[//游戏商页面
        'page_id'=>13,
        'gamestore'=>['render_limit'=>20,'limit'=>10]
    ],
    'question'=>[//问答页面
        'page_id'=>14,
        'question'=>['render_limit'=>20,'limit'=>10]
    ],
    'news_details' =>[//资讯详情页
        'page_id'=>15,
        'render_limit'=>['latest_news' =>2,'keyword_news'=>3,'new_news'=>3]
    ],//latest_news是作者最近发布的文章  keyword_news是指相关的文章，根据关键字筛选的 new_news也是指相关的文章，取最新发布的文章
    'report_details' =>[//数据报告详情页
        'page_id'=>16
    ],
    'user_data_details' =>[//用户资料详情页
        'page_id'=>17
    ],
    'data_upload_page' =>[//上传资料页
        'page_id'=>18
    ],
    'special'=>[//产业专题
        'page_id'=>19, //产业专题页面
        'special'=>['render_limit'=>20,'limit'=>10]
    ],
    'special_details' =>[//资讯详情页
        'page_id'=>20, //产业专题页面
        'render_limit'=>['news'=>20]
    ],
    'exhibition' =>[//展会列表页
        'page_id'=>21,
        'exhibition'=>['render_limit'=>10,'limit'=>10]
    ],
    'exhibition_details' =>[//展会详情页
        'page_id'=>22,
        'render_limit'=>['news'=>10]
    ],
    'question_detail'=>[
        'page_id'=>23,
        'solved'=>['render_limit'=>20,'limit'=>10],//已解决问题
        'unsolved'=>['render_limit'=>20,'limit'=>10],//未解决问题
        'user_question'=>['render_limit'=>20,'limit'=>10],//我的所有问题或者回答
    ],    
    'games'=>//游戏种类，用于set类型选取
        [
            ['name'=>'真人视讯','val'=>pow(2,0)],
            ['name'=>'老虎机','val'=>pow(2,1)],
            ['name'=>'彩票','val'=>pow(2,2)],
            ['name'=>'捕鱼','val'=>pow(2,3)],
            ['name'=>'体育','val'=>pow(2,4)],
            ['name'=>'电子竞技','val'=>pow(2,5)],
            ['name'=>'扑克','val'=>pow(2,6)],
            ['name'=>'麻将','val'=>pow(2,7)],
            ['name'=>'赛马','val'=>pow(2,8)],
            ['name'=>'金融','val'=>pow(2,9)],
            ['name'=>'其他','val'=>pow(2,10)]
        ],
    'settlement'=>//结算方式  '日结','周结','月结','季结','半年结','年结'
        [
            ['name'=>'日结','val'=>1],
            ['name'=>'周结','val'=>2],
            ['name'=>'月结','val'=>3],
            ['name'=>'季结','val'=>4],
            ['name'=>'半年结','val'=>5],
            ['name'=>'年结','val'=>6]
        ],
    'scale' => [//规模
        ['name'=>'10人以下','val'=>1],
        ['name'=>'10-50人','val'=>2],
        ['name'=>'50-200人','val'=>3],
        ['name'=>'200-500人','val'=>4],
        ['name'=>'500-1000人','val'=>5],
        ['name'=>'1000人以上','val'=>6],
    ],
    'region'=>[
        ['name'=>'菲律宾','val'=>1],
        ['name'=>'柬埔寨','val'=>2],
        ['name'=>'马来西亚','val'=>3],
        ['name'=>'泰国','val'=>4],
        ['name'=>'老挝','val'=>5],
        ['name'=>'缅甸','val'=>6],
        ['name'=>'台湾','val'=>7],
        ['name'=>'澳门','val'=>8],
        ['name'=>'中国大陆','val'=>9],
        ['name'=>'亚洲','val'=>10],
        ['name'=>'欧洲','val'=>11],
        ['name'=>'美洲','val'=>12],
        ['name'=>'其他地区','val'=>13]
    ],
    'access'=>[
        ['name'=>'AG','val'=>pow(2,0)],
        ['name'=>'BBIN','val'=>pow(2,1)],
        ['name'=>'EA','val'=>pow(2,2)],
        ['name'=>'OG','val'=>pow(2,3)],
        ['name'=>'HG','val'=>pow(2,4)],
        ['name'=>'欧普斯','val'=>pow(2,5)],
        ['name'=>'欧博','val'=>pow(2,6)],
        ['name'=>'EBET','val'=>pow(2,7)],
        ['name'=>'玛雅','val'=>pow(2,8)],
        ['name'=>'PT','val'=>pow(2,9)],
        ['name'=>'MG','val'=>pow(2,10)],
        ['name'=>'QT','val'=>pow(2,11)],
        ['name'=>'LB','val'=>pow(2,12)],
        ['name'=>'188','val'=>pow(2,13)],
        ['name'=>'沙巴','val'=>pow(2,14)],
        ['name'=>'皇冠','val'=>pow(2,15)],
        ['name'=>'TTG','val'=>pow(2,16)],
        ['name'=>'GD','val'=>pow(2,17)],
        ['name'=>'KENO','val'=>pow(2,18)],
        ['name'=>'AMP','val'=>pow(2,19)],
        ['name'=>'SA','val'=>pow(2,20)],
        ['name'=>'自主研发','val'=>pow(2,21)]
    ],
    'components'=>[
        'special'=>['id'=>1,'c_name'=>'专题','render_limit'=>10,'limit'=>10],
        'news'=>['id'=>2,'c_name'=>'资讯','render_limit'=>10,'limit'=>10],
        'user_data'=>['id'=>3,'c_name'=>'用户资料','render_limit'=>4,'limit'=>8],
        'report'=>['id'=>4,'c_name'=>'数据报告','render_limit'=>4,'limit'=>8],
        'business'=>['id'=>5,'c_name'=>'供求商讯','render_limit'=>10,'limit'=>10],
        'platform'=>['id'=>6,'c_name'=>'代理招商','render_limit'=>10,'limit'=>10],
        'author'=>['id'=>4,'c_name'=>'作者列表'],
    ],
    'data_type'=>[
        '1'=>'Andriod',
        '2'=>'IOS',
        '3'=>'PC'
    ],
    'author_page'=>[
        'news'=>['render_limit'=>15,'limit'=>8],
        'trend'=>['render_limit'=>15,'limit'=>8],
        'user_data'=>['render_limit'=>15,'limit'=>8],
        'business'=>['render_limit'=>15,'limit'=>8],
        'platform'=>['render_limit'=>15,'limit'=>8],
        'question'=>['render_limit'=>15,'limit'=>8],
        'comment'=>['render_limit'=>2,'limit'=>8],
        'fans'=>['render_limit'=>15,'limit'=>10],
        'attention'=>['render_limit'=>15,'limit'=>10]
    ],
    'business_detail'=>[
        'command_business'=>['limit'=>5]
    ],
    'platform_detail'=>[
        'command_platform'=>['limit'=>5]
    ],
    'mydata'=>[//我的资料页面
        'page_id'=>19,
        'my_upload'=>['render_limit'=>10,'limit'=>10],
        'my_download'=>['render_limit'=>10,'limit'=>10]
    ],
    'user_center'=>[//用户中心页面
        'page_id'=>20,
        'mail'=>['render_limit'=>10,'limit'=>10],
        'collection'=>['render_limit'=>10,'limit'=>10],
        'publish'=>['render_limit'=>10,'limit'=>10],
        'record'=>['render_limit'=>10,'limit'=>10]
    ]
];