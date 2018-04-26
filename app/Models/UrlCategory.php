<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UrlCategory extends Model
{
    protected $table = 'url_category';

    public function getNavigationList(){

        $categories = UrlCategory::where('status',1)->orderBy('sort','desc')->get();

        $navigation_list = [];

        $url_obj = new Url();

        foreach ($categories as $key=>$category){

            $navigation_list[$category->cname]['navs'] = $url_obj->getUrlInfo($category->id);

        }

        return $navigation_list;

    }
}
