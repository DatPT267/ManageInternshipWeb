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
        return redirect()->route('login');
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
                'password.min'=>'Mật khẩu quá ngắn',
                'password.max'=>'Mật khẩu quá dài',
            ]);
        $account = $request->input('account');
        $password = $request->input('password');
        $user = User::where('account', $account)->get()->first();
        if($user != null &&  $user->status == 0 ){
            return back()->with('thongbao', 'Tài khoản của bạn đã bị khóa');
        }
        else {
            if (Auth::attempt(['account' => $account, 'password' => $password])) {
                $user = Auth::user();
                if($user->position == 1){
                    return redirect()->route('user.home');
                }else return redirect()->route('admin.home');

            }
            else
            {
                return back()->with('thongbao', 'Đăng Nhập Không Thành Công');
            }
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
