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
        // dd($schedules);
        $arrayDayOfWeek = array();
        $i = 0;
        // dd($day_start);
        // dd($schedules);
        $now = Carbon::now();
        for($i = 0; $i < 2; $i++){
            $day_start = $now->startOfWeek()->isoFormat('Y-M-D');
            $day_end = $now->endOfWeek()->isoFormat('Y-M-D');
            $schedules = Schedule::where('user_id', $id)
                                ->whereRaw("date(date) BETWEEN '".$day_start."' AND '".$day_end."'")
                                ->get();
            // dd($schedules);
            foreach($schedules as $key => $value)
            {
                array_push($arrayDayOfWeek, array('session'=> $value->session, 'ngay' => $value->date, 'tuan' => $i));
            }
            $now->addWeek();
        }
        $arrWeek1 = [];
        $arrWeek2 = [];
        foreach ($arrayDayOfWeek as $value) {
            if($value['tuan'] == 0){
                array_push($arrWeek1, $value);
            } else{
                array_push($arrWeek2, $value);
            }
        }
        // dd($arrWeek2);
        // foreach ($schedules as $value) {
        //     $now = Carbon::now();
        //     $time = Carbon::parse($value->date)->timestamp;
        //     $day_start = $now->startOfWeek()->timestamp;
        //     $day_end = $now->addWeek()->endOfWeek()->timestamp;

        //     // dd($day_end);
        //     if($time >= $day_start && $time <= $day_end){
        //         // dd(Carbon::parse($time));
        //         $arrayDayOfWeek[$value->date] = array('session'=>$value->session);
        //     }
        // }
        // foreach ($schedules as $value) {
        //     $now = Carbon::now();
        //     $time = Carbon::parse($value->date);
        //     if($time->isCurrentMonth() && $time->weekNumberInMonth >= $now->weekNumberInMonth){
        //         $day = Carbon::parse($value->date)->englishDayOfWeek;
        //         // $arrayDayOfWeek[$day] = array('session'=>$value->session);
        //         $arrayDayOfWeek[$value->date] = array('session'=>$value->session);
        //     }
        // }
        $index=0;
        // return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrayDayOfWeek'=>$arrayDayOfWeek, 'check'=>$check, 'index'=>$index]);
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrWeek1' => $arrWeek1, 'arrWeek2' => $arrWeek2, 'index'=>$index]);
    }

    public function ajaxViewSchedule($id, $page){

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
                'status' => $value->status
            ];
        }
        $note = $check->note;
        return response()->json(['data'=>$data, 'note'=>$note], 200);
    }
}
