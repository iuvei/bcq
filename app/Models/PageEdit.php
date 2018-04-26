<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageEdit extends Model
{
    protected $table = 'page_edit';

    public function getPageLayout($page_id){//获取页面右部分配置布局

        if (!isset($page_id)){
            return [];
        }

        $components = PageEdit::where('page_id',$page_id)->orderBy('sort','desc')->pluck('component_id');

        return $components;
    }
}
