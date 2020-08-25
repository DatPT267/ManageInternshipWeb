<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
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
            if($time->isCurrentMonth() && $time->weekNumberInMonth >= $now->weekNumberInMonth){
                $day = Carbon::parse($value->date)->englishDayOfWeek;
                // $arrayDayOfWeek[$day] = array('session'=>$value->session);
                $arrayDayOfWeek[$value->date] = array('session'=>$value->session);
            }
        }
        // dd($arrayDayOfWeek);
        $index=0;
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrayDayOfWeek'=>$arrayDayOfWeek, 'index'=>$index]);
    }

    public function viewHisSchedule($id)
    {
        $now = Carbon::now();
        $start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->addWeek()->endOfWeek()->format('Y-m-d');
        // dd($start . " - " . $end);
        // $checks = Check::where('user_id', $id)->get();
        $checks = Check::whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
        // dd($checks);


        // dd($arrTask);
        $user = User::findOrFail($id);
        $index=0;
        return view('admin.pages.manageStudents.show-hisRegSchedule', ['checks'=>$checks, 'name'=>$user->name, 'index'=>$index]);
    }

    public function ajaxViewHisSchedule($id)
    {
        $arrTask = DetailCheck::where('check_id', $id)->get();
        $data = [];
        foreach ($arrTask as $key => $value) {
            $data[$key] = array(
                $value->check_id => $value,
            );
        }
        return response()->json(['data'=>$data]);
    }
}
