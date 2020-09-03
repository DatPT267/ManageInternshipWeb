<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
use App\Schedule;
use Illuminate\Http\Request;

class CheckController extends Controller
{
   public function index()
   {
       $checks = Check::select('user_id')->distinct()->get();
    //    dd($checks);
       return view('admin.pages.manageSchedule.statistic-checkin-out', ['checks' => $checks]);
   }

   public function detail($user_id){
        $checks = Check::where('user_id', $user_id)->get();
        $schedules = Schedule::where('user_id', $user_id)->get();
        return view('admin.pages.manageSchedule.detail-statistic-checkin-checkout',
                    [
                        'checks' => $checks,
                        'schedules' => $schedules
                    ]);
   }

    public function AjaxDetail(Request $request){
        $check_id = $request->input('id');
        $detailCheck = DetailCheck::where('check_id', $check_id)->get();
        $check = Check::find($check_id);
        $data = [];
        foreach($detailCheck as $key => $item){
            $data[$key] = [
                'id' => $key,
                'name' => $item->task->name,
                'status' => $item->status
            ];
        }
        $note = $check->note;
        return response()->json(['data' => $data, 'note' => $note]);
    }
}
