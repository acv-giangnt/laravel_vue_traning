<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdateliststatusRequest;
use App\Http\Requests\UsersRequest;
use App\Model\Services\UsersService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function danhsachnguoidung(){
        return view("danhsachnguoidung");
    }
    public function login()
    {

        if(Auth::guard('login')->check())
        {
            if(Auth::guard("login")->user()->auth == 1)
            {
                return redirect()->guest(route('admin.danhsachnguoidung'));
            }
        }
        return view("login");
    }
    public function profile()
    {
        return view("profile");
    }
    public function register()
    {
        return view("register");
    }
    public function post_register(UsersRequest $request)
    {
        return ["sc" =>UsersService::insertUser($request)];
    }

}
