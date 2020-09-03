<?php

namespace App\Http\Controllers;

use App\Schedule;
use Carbon\Carbon;
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
        $now = Carbon::now();
        $day_startWeek = $now->startOfWeek()->isoFormat('Y-M-D');
        $day_endWeek = $now->endOfWeek()->isoFormat('Y-M-D');
        // dd($day_startWeek);
        $schedules = Schedule::select('user_id')->whereBetween('date', [$day_startWeek, $day_endWeek])->distinct()->get();
        // dd($schedules);
        return view('admin.pages.manageSchedule.list', ['schedules' => $schedules]);
    }

    public function getCheckinOut()
    {
        return view('admin.pages.manageSchedule.statistic-checkin-out');
    }
}
