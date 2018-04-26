<?php
/**
 * Created by PhpStorm.
 * User: cao13
 * Date: 2017/11/9
 * Time: 17:54
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DisplaySystem extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'App\Providers\DisplaySystem\DisplayService';
    }
}