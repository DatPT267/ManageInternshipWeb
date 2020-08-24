<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Check;
use App\Member;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function checkin($id)
    {
        if($id == Auth::id()){
            $now = Carbon::now()->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
            $checkin = Check::whereRaw("date(date_start) = '".$now."'")->first();
            $task_id = $checkin->task->id;
            $check = 0;
            if($checkin !== null){
                $check = 1;
            }
            $schedule = Schedule::whereRaw("date(date) = '" . $now. "'")->first();
            $member_id = Member::where('user_id', $id)->first();
            $task = Assign::where('member_id', $member_id->id)->get();
            return view('user.pages.manage.check', ['schedule' => $schedule, 'tasks' => $task, 'id'=>$id, 'check'=>$check, 'taskID'=>$task_id]);
        }else{
            return redirect('/');
        }
    }

    public function postCheckin(Request $request, $id)
    {
        $this->validate($request, [
            'task' => 'required'
        ],[
            'task.required' => 'Bạn chọn task làm việc trong ngày'
        ]);
        $schedule = Schedule::whereRaw("date(date) = '" . $request->input('ngaythuctap'). "'")->first();

        $now = Carbon::now('asia/Ho_Chi_Minh')->toDateTimeString();

        $check = new Check();
        $check->user_id = $id;
        $check->task_id = $request->input('task');
        $check->date_start = $now;
        $check->schedule_id = $schedule->id;

        $check->save();

        return redirect("user/".$id."/checkin")->with(['success'=>'Check-in thành công']);
    }
}
