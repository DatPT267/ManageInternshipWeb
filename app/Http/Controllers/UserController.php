<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
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
            
            return back();
        }
        else
        {
            return back()->with('thongbao', 'Đăng Nhập Không Thành Công');
          
        }  
    }
    public function getLogout()
    {   
        
        Auth::logout();
		$arr = [
			"message" => 'Thành công',
			"status" => 1
		];
    	return $arr;
    }
    public function postLosspassword(Request $request)
    {   
        $user = User::where('email', $request->email)->get()->first();
        if($user == null){
         
            return abort(response()->json(['message' => 'Not Found'], 404));
        }  
        else{
            $str = Str::random(10);
            $data = array(
                'name'      =>  $user->name,
                'message'   =>   $str
            );
            $us = User::find($user->id);
            $us->password = bcrypt($str);
            $us->save();
            Mail::to($user->email)->send(new SendMail($data));
            return abort(response()->json(['message' => 'OK'], 200));
        }
    }
}
