<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function getLogin()
    {
        return view('admin.authentication.login');
    }
    public function postLogin(Request $request)
    {   
        $this->validate($request,
    		[
    			'account'=>'required',
    			'password'=>'required|min:3|max:32',
    		],
    		[
    			'account.required'=>'Bạn Chưa Nhập Tài Khoản',
    			'password.required'=>'Bạn Chưa Nhập Password',
            ]);
        $account = $request->input('account');
        $password = $request->input('password');
        if (Auth::attempt(['account' => $account, 'password' => $password])) {
            
            return "ok";
        }
        else
        {
            return redirect('admin/authentication/login')->with('thongbao', 'Đăng Nhập Không Thành Công');
          
        }  
    }
    public function getLosspassword()
    {   
        return view('admin/authentication/losspassword');
    }

}
