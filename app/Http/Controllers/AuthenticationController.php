<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function getLogin()
    {
        return view('admin.login');
    }
    public function postLogin()
    {
        # code...
    }
}
