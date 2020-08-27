<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Check;
use App\DetailCheck;
use App\Member;
use App\Schedule;
use App\Task;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    //=============================================Check-in===============================================
    public function checkin($id)
    {
        if($id == Auth::id()){
            $now = Carbon::now()->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
            $checkin = Check::whereRaw("date(date_start) = '".$now."'")->first();
            $isCheck = 0;
            $arrTask = null;
            if($checkin !== null){
                $isCheck = 1;
                $arrTask = DetailCheck::where('check_id', $checkin->id)->get();
            }
            $schedule = Schedule::whereRaw("date(date) = '" . $now. "'")->first();
            // dd($schedule);
            $member_id = Member::where('user_id', $id)->first();
            $tasks = Assign::where('member_id', $member_id->id)->get();
            // dd($checkin);
            return view('user.pages.manage.check-in', ['schedule' => $schedule, 'tasks' => $tasks, 'id'=>$id, 'isCheck'=>$isCheck, 'arrTask' => $arrTask, 'date_start'=>$checkin]);
        }else{
            return redirect('/');
        }
    }

    public function postCheckin(Request $request, $id)
    {
        $this->validate($request, [
            'chon-task' => 'required'
        ],[
            'chon-task.required' => 'Bạn chưa chọn task làm việc trong ngày'
        ]);
        $schedule = Schedule::whereRaw("date(date) = '" . $request->input('ngaythuctap'). "'")->first();
        $input = $request->input('chon-task');
        $now = Carbon::now('asia/Ho_Chi_Minh')->toDateTimeString();

        // dd($now);
        $check = new Check();
        // dd($check->id);
        $check->user_id = $id;
        // $check->task_id = $request->input('task');
        $check->date_start = $now;
        $check->schedule_id = $schedule->id;

        $check->save();
        foreach($input as $value){
            $detailCheck = new DetailCheck();
            $detailCheck->check_id = $check->id;
            $detailCheck->task_id = (int)$value;
            // dd($detailCheck);
            $detailCheck->save();
        }
        // dd($check->id);

        return redirect("user/".$id."/check-in")->with(['success'=>'Check-in thành công']);
    }

    //========================================END Check-in=======================================
    //========================================Check-out=======================================
    public function checkout($id)
    {
        $now = Carbon::now()->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
        $schedule = Schedule::whereRaw("date(date) = '" . $now. "'")->first();

        $member_id = Member::where('user_id', $id)->first();
        $tasks = Assign::where('member_id', $member_id->id)->get();
        // dd($tasks);
        $checkin = Check::whereRaw("date(date_start) = '".$now."'")->first();
        // dd($checkin);
        $isCheckout = 0;
        $arrTask = null;
        if($checkin !== null){
            $arrTask = DetailCheck::where('check_id', $checkin->id)->get();
        }
        if($checkin->date_end !== null){
            $isCheckout = 1;
        }
        // dd($arrTask);
        return view('user.pages.manage.check-out', ['schedule'=>$schedule, 'tasks'=>$tasks, 'arrTask'=>$arrTask, 'isCheckout'=>$isCheckout, 'note' => $checkin->note]);
    }

    public function postCheckout(Request $request, $id)
    {
        // dd($request->all());
        $now = Carbon::now('asia/Ho_Chi_Minh')->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
        $checkout = Check::whereRaw("date(date_start) = '".$now."'")->first();
        $checkout->note = $request->input('note');
        $checkout->date_end = $request->input('ngaythuctap');
        $checkout->save();
        $arrTask = $request->input('idTask');
        $arrStatusTask = $request->input('status');
        // dd($arrTask);
        foreach($arrTask as $key => $value)
        {
            $task = Task::find((int)$value);
            $task->status = (int)$arrStatusTask[$key];
            // dd($task->status);
            $task->save();
        }

        return redirect("user/".$id."/check-out")->with(['success'=>'Check-out thành công']);
    }
    //========================================END Check-out=======================================

    public function hisSchedule($id){
        $now = Carbon::now('asia/Ho_Chi_Minh');
        $start_week = $now->startOfWeek()->format('Y-m-d');
        $end_week = $now->endOfWeek()->format('Y-m-d');
        $checks = Check::whereRaw("date(date_start) BETWEEN '" . $start_week. "' AND '".$end_week."'")->where('user_id', $id)->get();
        // dd($checks);
        $timeTotal = 0;
        foreach ($checks as $key => $check) {
            $t1 = 0;
            $t2 = 0;
            if($check->date_start !== null && $check->date_end !== null){
                $arrTime = explode(" ", $check->date_start);
                $arrYMD = explode("-", $arrTime[0]);
                $year = (int)$arrYMD[0];
                $month = (int)$arrYMD[1];
                $day = (int)$arrYMD[2];
                $tz = 'asia/ho_chi_minh';
                $time_sang = Carbon::create($year, $month, $day, 12, 00, 00, $tz);
                $time_chieu = Carbon::create($year, $month, $day, 13, 30, 00, $tz);

                $hour_start = (int)Carbon::parse($check->date_start)->hour;
                $minute_start = (int)Carbon::parse($check->date_start)->minute;
                $hour_end = (int)Carbon::parse($check->date_end)->hour;
                $minute_end = (int)Carbon::parse($check->date_end)->minute;

                $start = Carbon::create($year, $month, $day, $hour_start, $minute_start, 00, $tz);
                $end = Carbon::create($year, $month, $day, $hour_end, $minute_end, 00, $tz);
                // dd($start);
                $t1 = $time_sang->diffInMinutes($start);
                // $t1 = $time_sang->diffInHours($start);
                $t2 = $time_chieu->diffInMinutes($end);
                $timeTotal += $t1 + $t2;
            }
        }
        // dd($timeTotal);
        $ngay = 0;
        $gio = 0;
        $phut = 0;
        //kiểm tra xem có qua ngày không
        $gio = floor($timeTotal / 60);
        $phut = $timeTotal % 60;

        if($gio >= 24){
            $ngay = floor($gio / 24);
            $gio = $gio % 24;
        }

        return view('user.pages.manage.view-history-check', ['checks' => $checks, 'timeTotal' => $timeTotal, 'ngay'=>$ngay, 'gio' => $gio, 'phut'=>$phut]);
    }
}
