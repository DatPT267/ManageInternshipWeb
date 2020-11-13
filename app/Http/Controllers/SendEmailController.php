<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;
use Illuminate\Support\Str;

class SendEmailController extends Controller
{

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
        return back()->with('thongbao', 'Tài khoản đã reset mật khẩu và gửi về mail của bạn');
    }


}

?>
