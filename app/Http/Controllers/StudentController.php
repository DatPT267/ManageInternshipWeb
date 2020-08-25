<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


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
        $index=0;
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrayDayOfWeek'=>$arrayDayOfWeek, 'index'=>$index]);
    }

    public function viewHisSchedule($id)
    {
        $now = Carbon::now();
        $start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->addWeek()->endOfWeek()->format('Y-m-d');
        $checks = Check::where('user_id', $id)->whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
        $user = User::findOrFail($id);
        $index=0;
        return view('admin.pages.manageStudents.show-hisRegSchedule', ['checks'=>$checks, 'name'=>$user->name, 'index'=>$index]);
    }

    public function ajaxViewHisSchedule($id)
    {
        $arrTask = DetailCheck::where('check_id', $id)->get();
        $check = Check::find($id);
        $data = [];
        foreach ($arrTask as $key => $value) {
            $data[$key] = [
                'id' => $key,
                'name' => $value->task->name,
                'status' => $value->task->status
            ];
        }
        $note = $check->note;
        return response()->json(['data'=>$data, 'note'=>$note], 200);
    }
}
