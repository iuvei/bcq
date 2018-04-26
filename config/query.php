<?php

return [
    'functionList'=>[
        'wgi8',
        'winner365',
        'mm1396',
        'mlc365',
        'imastv',
        'kbet',
        'ultraegaming',
        'google',
        'winnermacau',
        'toutiao888',
        'bohecai',
        'caitong',
        'pinnacle',
        'pukexinwen',
        'betping',
        'ilcaca'
    ],

    1886 => [
        'origin' => '環球博訊',
        'page_header' => 'https://www.wgi8.com/',
        'content_reg' => [
            'content' => ['.m-d-content','html','-div']
        ],
        'content_rang' => '.main-detail',
        'content_img_replace' => 'src="../../../'
    ],

    1887 => [
        'origin' => '天天大赢家',
        'page_header' => 'http://www.365winner.biz/',
        'content_reg' => [
            'content' => ['#post_con','html','-div -script']
        ],
        'content_rang' => '.gambling_tips',
        'content_img_replace' => 'src="/'
    ],

    1888 => [
        'origin' => '博世界',
        'page_header' => 'https://www.1396mm.com/',
        'content_reg' => [
            'content' => ['.bw_Detail_info #con','html']
        ],
        'content_rang' => '.bw_main',
        'content_img_replace' => ''
    ],

    1889 => [
        'origin' => '名利场',
        'page_header' => '',
        'content_reg' => [
            'content' => ['.yh-nei','html']
        ],
        'content_rang' => '.col-xs-12',
        'content_img_replace' => ''
    ],

    1890 => [
        'origin' => '奥创娱乐',
        'page_header' => '',
        'content_reg' => [
            'content' => ['.entry-content','html','-.addtoany_share_save_container addtoany_content addtoany_content_top -#text_h -.addtoany_share_save_container addtoany_content addtoany_content_bottom',function($content){
                $len = mb_strlen($content)-84;
                $content = mb_substr($content,0,$len);
                return $content;
            }]
        ],
        'content_rang' => '#main',
        'content_img_replace' => ''
    ],

    1891 => [
        'origin' => '谷歌菲律宾',
        'page_header' => '',
        'content_reg' => [
            'content' => ['','']
        ],
        'content_rang' => '',
        'content_img_replace' => ''
    ],

    1892 => [
        'origin' => '澳门赢家',
        'page_header' => 'http://www.winnermacau.com/',
        'content_reg' => [
            'content' => ['.pane-content .field-items .field-item','html','-#gallery -a']
        ],
        'content_rang' => '#content',
        'content_img_replace' => ''
    ],

    1893 => [
        'origin' => '888头条',
        'page_header' => '',
        'content_reg' => [
            'content' => ['.entry-content','html','.image-full -div']
        ],
        'content_rang' => '#main',
        'content_img_replace' => ''
    ],

    1894 => [
        'origin' => '博和彩',
        'page_header' => 'http://www.bohecai.com/',
        'content_reg' => [
            'content' => ['.left22_b','html']
        ],
        'content_rang' => '.left22',
        'content_img_replace' => 'src="/'
    ],

    1574 => [
        'origin' => '新浪彩通',
        'page_header' => '',
        'content_reg' => [
            'content' => ['.article-txt','html','-.img_wrapper -.article-kw']
        ],
        'content_rang' => '.q-box-news',
        'content_img_replace' => ''
    ],

    1895 => [
        'origin' => '平博Pinnacle',
        'page_header' => 'https://www.pinnacle.com/',
        'content_reg' => [
            'content' => ['.content>div:last','html','-.articleV2 -a']
        ],
        'content_rang' => '.common-wrap',
        'content_img_replace' => 'src="/'
    ],

    1899 => [
        'origin' => '博评网',
        'page_header' => 'http://www.betping.net/',
        'content_reg' => [
            'content' => ['.det-content .detcon-info','html']
        ],
        'content_rang' => '.bp-details',
        'content_img_replace' => 'src="/'
    ],

    1900 => [
        'origin' => '海燕资讯网',
        'page_header' => 'http://www.ilcaca.co/',

        'content_reg' => [
            'content' => ['.text','html','-.hsplit -.pcd_ad -.mbd_ad -.bk20 -#fx -.pagination -.pcd_ad -.mbd_ad -.tit12 -p:last -script',function($content){
                $len = mb_strlen($content)-53;
                $content = mb_substr($content,0,$len);
                return $content;
            }]
        ],
        'content_rang' => '.main-left',
        'content_img_replace' => 'src="/'
    ],
];

