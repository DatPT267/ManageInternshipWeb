<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $day_start_month =$now->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end_month = $now->endOfMonth()->isoFormat('YYYY-MM-DD');
        $checks = Check::select('user_id')
                        ->whereRaw("date(date_start) BETWEEN '".$day_start_month."' AND '".$day_end_month."'")
                        ->distinct()
                        ->get();
        //    dd($checks);
        return view('admin.pages.manageSchedule.statistic-checkin-out', ['checks' => $checks]);
    }

    public function ajaxStatistical(Request $request)
    {
        $data_input = $request->input('date');
        $date = Carbon::createFromDate(null, $data_input, 1, 'asia/Ho_Chi_Minh');
        $day_start_month = $date->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end_month = $date->endOfMonth()->isoFormat('YYYY-MM-DD');
        $checks = Check::select('user_id')
                ->whereRaw("date(date_start) BETWEEN '".$day_start_month."' AND '".$day_end_month."'")
                ->distinct()
                ->get();
        $data = [];
        foreach ($checks as $key => $value) {
            $data[$key] = [
                'id' => $key,
                'name' => $value->user->name,
                'user_id' => $value->user_id
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function viewHisCheck($id, $number)
    {
        $monthNow = Carbon::now()->month;
        $date = Carbon::createFromDate(null, $number, 1, 'asia/Ho_Chi_Minh');
        $day_start = $date->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end = $date->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($number == $monthNow){
            $checks = Check::where('user_id', $id)
                        ->where('date_end', '!=', 'null')
                        ->whereRaw("date(date_start) BETWEEN '".$day_start."'AND'".Carbon::now()->subDay()->isoFormat('YYYY-MM-DD')."'")
                        ->orderByDesc('id')
                        ->get();
            // dd($checks);
            $sum_check = count($checks);
            // dd($sum_check);
            $schedules = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$day_start, Carbon::now()->subDay()->isoFormat('YYYY-MM-DD')])
                        ->orderByDesc('id')
                        ->get();
        } else{
            // dd($date);
            $checks = Check::where('user_id', $id)
                        ->where('date_end', '!=', 'null')
                        ->whereRaw("date(date_start) BETWEEN '".$day_start."'AND'".$day_end."'")
                        ->orderByDesc('id')
                        ->get();
            // dd($checks);
            $sum_check = count($checks);
            // dd($sum_check);
            $schedules = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$day_start, $day_end])
                        ->orderByDesc('id')
                        ->get();
        }
        // dd($schedules);
        $dataSch = [];
        foreach ($checks as $key => $value) {
            array_push($dataSch, $value->schedule_id);
        }
        // dd($dataSch);
        $user = User::findOrFail($id);
        $index=0;
        return view('admin.pages.manageStudents.show-hisRegSchedule',
                [
                    'schedules'=> $schedules,
                    'checks'=>$checks,
                    'user'=>$user,
                    'index'=>$index,
                    'dataSch' => $dataSch,
                    'sum_check' => $sum_check
                ]);
    }

    public function ajaxTask($id)
    {
        $arrTask = DetailCheck::where('check_id', $id)->get();
        $check = Check::find($id);
        $data = [];
        foreach ($arrTask as $key => $value) {
            $data[$key] = [
                'id' => $key,
                'name' => $value->task->name,
                'status' => $value->status
            ];
        }
        $note = $check->note;
        $day_check = $check->schedule->date;
        return response()->json(['data'=>$data, 'note'=>$note, 'day_check' => $day_check], 200);
    }
}
