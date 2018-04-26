<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $passField = [
        'name','password','group','regip','lastloginip','status'
    ];

    public function login(Request $request){
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|min:2',
                'password' => 'required|min:6|max:30',
                'captcha' => 'required|captcha',
                'online' => 'integer'
            ]);
            $user = request(['name', 'password']);
            $online = boolval(request('online'));
            if (Auth::guard('admin')->attempt($user,$online)) {
                return redirect('/'.config('base.admin').'/index');
            }

            return \Redirect::back()->withErrors("用户名密码错误");
        }else{
            $object = array();
        }
        return view('Admin.login.login',compact('object'));
    }

    public function logout(Request $request){
        \Auth::guard('admin')->logout();
        return redirect('/'.config('base.admin').'/login');
    }

}
