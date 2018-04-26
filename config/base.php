<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 后台地址
    |--------------------------------------------------------------------------
    */
    'admin' => 'a2b599a6fcb06b7353',//后台地址  substr(md5('bocaiquan-admin'),8,18);

    'dataType' => [//资料类型
        1 => '源代码',
        2 => '推广技巧',
        3 => '技术资料'
    ],

    'trendsType' => [//产品类型
        pow(2,0) => 'Web',
        pow(2,1) => 'Ios',
        pow(2,2) => 'Android'
    ],

    'year' => [//年限
        1 => '1年',
        2 => '2年',
        3 => '3年',
        4 => '4年',
        5 => '5年以上',
        6 => '10年以上'
    ],

    'scale' => [//规模
        1 => '10人以下',
        2 => '10-50人',
        3 => '50-200人',
        4 => '200-500人',
        5 => '500-1000人',
        6 => '1000人以上'
    ],

    'settlement' => [//结算周期
        1 => '日结',
        2 => '周结',
        3 => '月结',
        4 => '季结',
        5 => '半年结',
        6 => '年结'
    ],

    'region' => [//地区
        1 => '菲律宾',
        2 => '柬埔寨',
        3 => '马来西亚',
        4 => '泰国',
        5 => '老挝',
        6 => '缅甸',
        7 => '中国台湾',
        8 => '中国澳门',
        9 => '中国大陆',
        10 => '亚洲',
        11 => '欧洲',
        12 => '美洲',
        13 => '其他地区'
    ],

    'games' => [//主营游戏
        pow(2,0) => '真人视讯',
        pow(2,1) => '老虎机',
        pow(2,2) => '彩票',
        pow(2,3) => '捕鱼',
        pow(2,4) => '体育',
        pow(2,5) => '电子竞技',
        pow(2,6) => '扑克',
        pow(2,7) => '麻将',
        pow(2,8) => '赛马',
        pow(2,9) => '金融',
        pow(2,10) => '其他'
    ],

    'access' => [//接入平台
        pow(2,0) => 'AG',
        pow(2,1) => 'BBIN',
        pow(2,2) => 'EA',
        pow(2,3) => 'OG',
        pow(2,4) => 'HG',
        pow(2,5) => '欧普斯',
        pow(2,6) => '欧博',
        pow(2,7) => 'EBET',
        pow(2,8) => '玛雅',
        pow(2,9) => 'PT',
        pow(2,10) => 'MG',
        pow(2,11) => 'QT',
        pow(2,12) => 'LB',
        pow(2,13) => '188',
        pow(2,14) => '沙巴',
        pow(2,15) => '皇冠',
        pow(2,16) => 'TTG',
        pow(2,17) => 'GD',
        pow(2,18) => 'KENO',
        pow(2,19) => 'AMP',
        pow(2,20) => 'SA',
        pow(2,21) => '自主研发'
    ],

    'plate' => [//持有认证
        pow(2,0) => [
            'title' => '菠菜圈诚信',
            'color' => '#25a934',
            'class' => 'chengxin',
        ],
        pow(2,1) => [
            'title' => '企业资质',
            'color' => '#e08e09',
            'class' => 'zizhi',
        ],
        pow(2,2) => [
            'title' => '合法牌照',
            'color' => '#117ac5',
            'class' => 'hefa',
        ]
    ],
    'slide_type' => [//轮播类型
        'news' => '资讯',
        'report' => '报告',
        'business' => '供求商讯',
        'platform' => '代理招商',
        'notice' => '公告',
        'data' => '资料',
        'banner' => '广告'
    ],
    'lottery_type'=>//彩种
        [
            1 => ['name'=>'时时彩','pid'=>0],
            2 => ['name'=>'11选5','pid'=>0],
            3 => ['name'=>'快3','pid'=>0],
            4 => ['name'=>'六合彩','pid'=>0],
            5 => ['name'=>'体彩','pid'=>0],
            6 => ['name'=>'其他','pid'=>0],

            11 => ['name'=>'重庆时时彩','pid'=>1],
            12 => ['name'=>'天津时时彩','pid'=>1],
            13 => ['name'=>'新疆时时彩','pid'=>1],
            14 => ['name'=>'黑龙江','pid'=>1],
            15 => ['name'=>'PK10','pid'=>1],
            16 => ['name'=>'飞艇','pid'=>1],
            17 => ['name'=>'快马','pid'=>1],

            21 => ['name'=>'山东11选5','pid'=>2],
            22 => ['name'=>'江西11选5','pid'=>2],
            23 => ['name'=>'广东11选5','pid'=>2],
            24 => ['name'=>'重庆11选5','pid'=>2],
            25 => ['name'=>'江苏11选5','pid'=>2],
            26 => ['name'=>'山西11选5','pid'=>2],
            27 => ['name'=>'安徽11选5','pid'=>2],

            31 => ['name'=>'江苏快3','pid'=>3],
            32 => ['name'=>'安徽快3','pid'=>3],
            33 => ['name'=>'湖北快3','pid'=>3],
            34 => ['name'=>'河南快3','pid'=>3],

            41 => ['name'=>'香港六合彩','pid'=>4],

            51 => ['name'=>'大乐透','pid'=>5],
            52 => ['name'=>'7星彩','pid'=>5],
            53 => ['name'=>'排列','pid'=>5],

            61 => ['name'=>'福彩3D','pid'=>6],
            62 => ['name'=>'开乐彩','pid'=>6],
        ],
        
    'price'=>[//各种积分
        'question'=>10 //回答问题奖励积分
    ],

    'phone_code'=>[
        'china'=>[
            'api'=>'http://106.ihuyi.cn/webservice/sms.php?method=Submit',
            'account'=>'C37228123',
            'password'=>'05202266eb1dd842434abc9f9013da4c'
        ],
        'nation'=>[
            'api'=>'http://api.isms.ihuyi.com/webservice/isms.php?method=Submit',
            'account'=>'I96593071',
            'password'=>'eab92853e05ec462df401581ce29a194'
        ]

    ],
    'news_user_avatar'=>'/static/new_avatar.png',
    
    'view_config'=>[
            'news'=>['inhour'=>rand(70,105),'rand'=>rand(30,60)],
            'trends'=>['inhour'=>rand(70,105),'rand'=>rand(30,60)],
            'report'=>['inhour'=>rand(70,105),'rand'=>rand(30,60)],
            'userdata'=>['inhour'=>rand(70,105),'rand'=>rand(30,60)],
            'micro'=>['inhour'=>rand(70,105),'rand'=>rand(30,60)]
    ],

    'find' => ['博彩','赌博','赌徒'],

    'replace' => ['菠菜','菠菜','玩家'],

    'post_boniu'=>[
        'url'=>'http://www.boniu365.info/news/add-news.html',
        'url2'=>'http://www.boniu365.info/news/update-status.html',
        'token'=>'bn_iTeR19Y6'
    ],
    'post_betconsult'=>[
        'url'=>'http://47.89.51.84/api/news',
        'token'=>'bn_iTeR19Y6'
    ],
    'game_level'=>10,//游戏商等级
    
    'bzp_tocken'=>'9416772ae64db34008664b9b838c975d'  
];