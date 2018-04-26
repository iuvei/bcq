<?php

namespace App\Providers\DisplaySystem;

interface DisplayContract{

    public function getList($Model,$skip,$limit,$opt=[]);//获取各种分类的列表 $Model模型名称 $skip已经获取条数 $limit还要取多少条 $opt 一些特殊条件查询

}