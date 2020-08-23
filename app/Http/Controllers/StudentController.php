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
        $student = User::findOrFail($id);
        $schedules = Schedule::where('user_id', $id)->get();
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
        $index=0;
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrayDayOfWeek'=>$arrayDayOfWeek, 'index'=>$index]);
    }

    public function viewHisSchedule($id)
    {
        $checks = Check::where('user_id', $id)->get();
        // foreach ($checks as $check) {
        //     dd($check->date_end);
        //     dd(\Carbon\Carbon::parse($check->date_end)->isoFormat('M/D'));
        // }
        // dd($checks);
        $user = User::findOrFail($id);
        return view('admin.pages.manageStudents.show-hisRegSchedule', ['checks'=>$checks, 'name'=>$user->name]);
    }
}
