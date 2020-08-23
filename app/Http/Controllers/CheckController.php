<?php

namespace App\Http\Controllers;

use App\Check;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function checkin($id)
    {
        return view('user.pages.manage.check');
    }
}
