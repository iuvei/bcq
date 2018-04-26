<?php

return [

    'key_name' => "x-api-key",//api密钥名称

    'key_password' => "Ps17dFG7HJIp23DsmCC0co2F7Ip1G1",//api密钥

    'limit' => 50,

    'searchLimit' => 50,

    'lottery_list' => [ //彩种
        'cqssc' => [
            'model' => 'Cqssc',
            'exp' => '',
            'type' => 1,
            'desc' => '重庆时时彩',
        ],
        'hljssc' => [
            'model' => 'Hljssc',
            'exp' => '',
            'type' => 1,
            'desc' => '黑龙江时时彩',
        ],
        'tjssc' => [
            'model' => 'Tjssc',
            'exp' => '',
            'type' => 1,
            'desc' => '天津时时彩',
        ],
        'xjssc' => [
            'model' => 'Xjssc',
            'exp' => '',
            'type' => 1,
            'desc' => '新疆时时彩',
        ],
        'bjkl8' => [
            'model' => 'Bjkl8',
            'exp' => ' ',
            'type' => 1,
            'desc' => '北京快乐8',
        ],
        'bjpk10' => [
            'model' => 'Bjpk10',
            'exp' => ',',
            'type' => 1,
            'desc' => '北京pk拾赛车',
        ],
        'ssl' => [
            'model' => 'Ssl',
            'exp' => '',
            'type' => 1,
            'desc' => '上海时时乐',
        ],
        'sd11y' => [
            'model' => 'Sd11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '山东11选5',
        ],
        'gd11y' => [
            'model' => 'Gd11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '广东11选5',
        ],
        'jx11y' => [
            'model' => 'Jx11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '江西11选5',
        ],
        'jsk3' => [
            'model' => 'Jsk3',
            'exp' => '',
            'type' => 1,
            'desc' => '江苏快3',
        ],
        'ahk3' => [
            'model' => 'Ahk3',
            'exp' => '',
            'type' => 1,
            'desc' => '安徽快3',
        ],
        'hbk3' => [
            'model' => 'Hbk3',
            'exp' => '',
            'type' => 1,
            'desc' => '湖北快3',
        ],
        'hnk3' => [
            'model' => 'Hnk3',
            'exp' => '',
            'type' => 1,
            'desc' => '河南快3',
        ],
        'gsk3' => [
            'model' => 'Gsk3',
            'exp' => '',
            'type' => 1,
            'desc' => '甘肃快3',
        ],
        'sh11y' => [
            'model' => 'Sh11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '上海11选5',
        ],
        'ah11y' => [
            'model' => 'Ah11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '安徽11选5',
        ],
        'js11y' => [
            'model' => 'Js11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '江苏11选5',
        ],
        'sx11y' => [
            'model' => 'Sx11y',
            'exp' => ' ',
            'type' => 1,
            'desc' => '山西11选5',
        ],
        '3d' => [
            'model' => 'F3d',
            'exp' => '',
            'type' => 2,
            'desc' => '福彩3d',
        ],
        'p5' => [
            'model' => 'P5',
            'exp' => '',
            'type' => 2,
            'desc' => '排列五P5',
        ],
        'ssq' => [
            'model' => 'Ssq',
            'exp' => ' ',
            'type' => 2,
            'desc' => '双色球',
        ],
        'lhc' => [
            'model' => 'Lhc',
            'exp' => ' ',
            'type' => 2,
            'desc' => '六合彩',
        ],
        'qlc' => [
            'model' => 'Qlc',
            'exp' => '',
            'type' => 2,
            'desc' => '七乐彩',
        ],
        'dlt' => [
            'model' => 'Dlt',
            'exp' => '',
            'type' => 2,
            'desc' => '大乐透',
        ],
        'qxc' => [
            'model' => 'Qxc',
            'exp' => '',
            'type' => 2,
            'desc' => '七星彩',
        ],


    ]


];