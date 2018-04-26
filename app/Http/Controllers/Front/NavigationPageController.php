<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UrlCategory as UrlCategory;
class NavigationPageController extends Controller
{
    public function render(){

        $nav_obj = new UrlCategory();

        $navList = $nav_obj->getNavigationList();

        return json_encode(['navList'=>$navList]);
    }
}
