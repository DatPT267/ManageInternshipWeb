<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthenticationController extends Controller
{
    public function getLogin()
    {
        return view('admin.authentication.login');
    }
    public function getLogout()
    {
        Auth::logout();
    	return "Đăng xuất thành công";
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
            return back()->with('thongbao', 'Đăng Nhập Không Thành Công');
          
        }  
    }
    public function getLosspassword()
    {   
        return view('admin/authentication/losspassword');
    }
    public function postLosspassword(Request $request)
    {   
        $this->validate($request,
            [
                'email'=>'required|email',
               
            ],
            [
                'email.required'=>'Bạn Chưa Nhập Email',
                'email.email'=>'Email không đúng',
            ]);
        
        $user = User::where('email', $request->email)->get()->first();
        if($user == null){
            return redirect()->back()->with('thongbao', 'Email chưa đăng ký tài khoản');
        }  
        else
            return view('admin/authentication/confirmemail', ['user'=> $user]);
    }

}
