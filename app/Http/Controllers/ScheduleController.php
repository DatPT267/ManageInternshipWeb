<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.manageSchedule.list');
    }

    public function getCheckinOut()
    {
        return view('admin.pages.manageSchedule.statistic-checkin-out');
    }


}
