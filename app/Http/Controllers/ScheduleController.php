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
        $day_start_month = $now->startOfMonth()->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_month = $now->endOfMonth()->addMonth()->startOfWeek()->subDay()->isoFormat('YYYY-MM-DD');
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
        $day_start_month = $date->startOfMonth()->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_month = $date->endOfMonth()->addMonth()->startOfWeek()->subDay()->isoFormat('YYYY-MM-DD');
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
        return response()->json([
            'data' => $data,
            'day_start_month' => $day_start_month,
            'day_end_month' => $day_end_month
        ]);
    }

    public function viewSchedule($id, $month){
        $todayMonth = Carbon::now()->month;
        // dd($week);
        $now = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
        // dd($now);
        $day_start_week = $now->startOfWeek()->isoFormat('Y-M-D');
        $day_end_week = $now->endOfWeek()->isoFormat('Y-M-D');
        $name = User::find($id);
        $schedules = Schedule::where('user_id', $id)
                            ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                            ->get();
        // dd($day_start_week);
        return view('admin.pages.manageStudents.show-regSchedule',
                        [
                            'schedules' => $schedules,
                            'name' => $name->name,
                            'month' => $month,
                            'id' => $id,
                            'numberWeekOfMonth' => Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->endOfMonth()->weekOfMonth
                        ]);
    }

    public function ajaxViewSchedule(Request $request){
        $month = $request->input('month');
        $week = $request->input('week');
        $id = $request->input('id');
        // $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week)->month($month);
        if($month == 1){
            $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->week($week);
        } elseif($month == 12){
            $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week+1)->month($month);
        }elseif($month == 11){
            if($week != 1){
                $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week-1)->month($month);
            } else{
                $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
            }
        } else{
            if($week != 1){
                $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week)->month($month);
            } else{
                $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
            }
        }
        $day_start_week = $date->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_week = $date->endOfWeek()->isoFormat('YYYY-MM-DD');
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
        return response()->json([
            'data' => $data,
            'day_start_week' => $day_start_week,
            'day_end_week' => $day_end_week,
            'week2' => $date->weekNumberInMonth,
            'week' => Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->endOfMonth()->weekOfMonth,
            'date' => $date
        ]);
    }

}
