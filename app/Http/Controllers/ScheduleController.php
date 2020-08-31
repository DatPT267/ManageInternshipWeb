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
    public function viewSchedule($id)
    {
        $student = User::findOrFail($id);
        $arrayDayOfWeek = array();
        $i = 0;
        $now = Carbon::now();
        for($i = 0; $i < 2; $i++){
            $day_start = $now->startOfWeek()->isoFormat('Y-M-D');
            $day_end = $now->endOfWeek()->isoFormat('Y-M-D');
            $schedules = Schedule::where('user_id', $id)
                                ->whereRaw("date(date) BETWEEN '".$day_start."' AND '".$day_end."'")
                                ->get();
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

        $index=0;
        return view('admin.pages.manageStudents.show-regSchedule', ['studentName'=>$student->name, 'arrWeek1' => $arrWeek1, 'arrWeek2' => $arrWeek2, 'index'=>$index]);
    }

    public function viewHisSchedule($id)
    {
        $now = Carbon::now();
        $start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->addWeek()->endOfWeek()->format('Y-m-d');
        // $checks = Check::where('user_id', $id)->whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
        $checks = Check::where('user_id', $id)->get();
        // dd($checks);
        $user = User::findOrFail($id);
        $index=0;
        return view('admin.pages.manageStudents.show-hisRegSchedule', ['checks'=>$checks, 'user'=>$user, 'index'=>$index]);
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
        return response()->json(['data'=>$data, 'note'=>$note], 200);
    }

    public function ajaxViewHisSchedule($id, $number)
    {
        $now = Carbon::now();
        if($number == 0){
            $start = $now->startOfWeek()->format('Y-m-d');
            $end = $now->endOfWeek()->format('Y-m-d');
            $checks = Check::where('user_id', $id)->whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
            return response()->json(['data'=>$checks]);
        } else if($number == 2){
            $start = $now->addWeek()->startOfWeek()->format('Y-m-d');
            $end = $now->addWeek()->endOfWeek()->format('Y-m-d');
            $checks = Check::where('user_id', $id)->whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
            return response()->json(['data'=>$checks]);
        } else{
            $start = $now->subWeek()->startOfWeek()->format('Y-m-d');
            $end = $now->subWeek()->endOfWeek()->format('Y-m-d');
            $checks = Check::where('user_id', $id)->whereRaw("date(date_start) BETWEEN '".$start."' AND '". $end ."'")->get();
            return response()->json(['data'=>$checks]);
        }
    }
}
