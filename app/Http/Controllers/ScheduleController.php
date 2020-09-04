<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(){
        $now = Carbon::now();
        $month = $now->month;
        $day_start_month = $now->startOfMonth()->isoFormat('Y-M-D');
        $day_end_month = $now->endOfMonth()->isoFormat('Y-M-D');
        // dd($day_end_week);
        $schedules = Schedule::select('user_id')
                        ->whereBetween('date', [$day_start_month, $day_end_month])
                        ->distinct()
                        ->get();
        // dd($schedules);
        return view('admin.pages.manageSchedule.list',['schedules' => $schedules, 'month' => $month]);
    }

    public function ajaxViewListSchedule(Request $request){
        $date_input = $request->input('date');
        $date = Carbon::createFromDate(null, $date_input, 1, 'asia/Ho_Chi_Minh');
        $day_start_month = $date->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end_month = $date->endOfMonth()->isoFormat('YYYY-MM-DD');
        $schedules = Schedule::select('user_id')
                            ->whereBetween('date', [$day_start_month, $day_end_month])
                            ->distinct()
                            ->get();
        $data = [];
        foreach ($schedules as $key => $value) {
            $data[$key] = [
                'id' => $key,
                'user_id' => $value->user_id,
                'name' => $value->user->name
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function viewSchedule($id, $month){
        $week = Carbon::now()->weekNumberInMonth;
        $now = Carbon::createFromDate(null, $month, 1)->week($week)->month($month);
        // dd($now);
        $day_start_week = $now->startOfWeek()->isoFormat('Y-M-D');
        $day_end_week = $now->endOfWeek()->isoFormat('Y-M-D');
        $name = User::find($id);
        $schedules = Schedule::where('user_id', $id)
                            ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                            ->get();
        // dd($day_end_week);
        return view('admin.pages.manageStudents.show-regSchedule',
                        [
                            'schedules' => $schedules,
                            'name' => $name->name,
                            'month' => $month,
                            'id' => $id
                        ]);
    }

    public function ajaxViewSchedule(Request $request){
        $month = $request->input('month');
        $week = $request->input('week');
        $id = $request->input('id');
        $date = Carbon::createFromDate(null, $month, 1)->week($week)->month($month);
        $day_start_week = $date->startOfWeek()->isoFormat('Y-M-D');
        $day_end_week = $date->endOfWeek()->isoFormat('Y-M-D');
        $schedules = Schedule::where('user_id', $id)
                    ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                    ->get();
        $data = [];
        foreach ($schedules as $key => $value) {
            $data[$key] = [
                'index' => $key,
                'englishDayOfWeek' => Carbon::parse($value->date)->englishDayOfWeek,
                'date' => Carbon::parse($value->date)->isoFormat('DD-MM-YYYY'),
                'session' => $value->session
            ];
        }
        return response()->json(['data' => $data, 'day_start_week' => $day_start_week, 'day_end_week' => $day_end_week]);
    }

}
