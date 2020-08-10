<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QLDotThucTapController extends Controller
{
    public function getDanhSach()
    {
        return view('admin.pages.QLDotThucTap.danhsach');
    }
}
