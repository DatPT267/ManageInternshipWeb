<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\LostPasswordRequest;
use App\Mail\SendMail;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function postLogin(AuthRequest $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        if(Auth::attempt(['account' => $account, 'password' => $password])){
            if(Auth::user()->status == 0){
                return redirect()->route('login')->with('thongbao', 'Tài khoản của bạn đã bị khóa');
            } else{
                if(Auth::user()->position == 1){
                    return redirect()->route('user.home');
                }else return redirect()->route('admin.home');
            }
        } else{
            return redirect()->route('login')->with('thongbao', 'Sai thông tin tài khoản');
        }
    }
    public function getLosspassword()
    {
        return view('auth.losspassword');
    }
    public function postLosspassword(LostPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        if($user == null){
            return redirect()->route('losspassword')->with('thongbao', 'Email chưa đăng ký tài khoản');
        }
        else
            return view('auth.confirmemail', ['user'=> $user]);
    }

    public function send($email)
    {

        $user = User::where('email', $email)->get()->first();
        $str = Str::random(10);
        $data = array(
            'name'      =>  $user->name,
            'message'   =>   $str
        );
        $us = User::find($user->id);
        $us->password = bcrypt($str);
        $us->save();
        Mail::to($user->email)->send(new SendMail($data));
        return redirect()->route('login')->with('thongbao', 'Tài khoản đã reset mật khẩu và gửi về mail');
    }


}
