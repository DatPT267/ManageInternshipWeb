<?php

namespace App\Http\Controllers;

use App\Check;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

class StudentController extends Controller
{
    public function viewSchedule($id)
    {
        $student = User::find($id);
        $schedules = Schedule::where('user_id', $id)->get();
        // $ngay = Carbon::parse($schedules->date)->format('l');
        // $gio = Carbon::parse($schedules->date)->format('H');
        // $phut = Carbon::parse($schedules->date)->format('i');
        $arrayDayOfWeek = array();
        foreach ($schedules as $value) {
            $now = Carbon::now();
            $time = Carbon::parse($value->date);
            if($time->isCurrentMonth() && $time->weekNumberInMonth == $now->weekNumberInMonth){
                $day = Carbon::parse($value->date)->englishDayOfWeek;
                $arrayDayOfWeek[$day] = array('session'=>$value->session);
            }
        }
        // dd($arrayDayOfWeek);
        $i=0;
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrayDayOfWeek'=>$arrayDayOfWeek, 'index'=>$i]);
    }

    public function viewHisSchedule($id)
    {
        $checks = Check::where('user_id', $id)->get();
        $user = User::find($id);
        return view('admin.pages.manageStudents.show-hisRegSchedule', ['checks'=>$checks, 'name'=>$user->name]);
    }
}
