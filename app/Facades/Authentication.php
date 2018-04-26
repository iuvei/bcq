<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Authentication extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'App\Providers\Authentication\AuthService';
    }
}