<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Check;
use App\DetailCheck;
use App\Schedule;
use App\User;
use App\Member;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class CheckController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // $now = Carbon::createFromDate(null, 9, 1, 'asia/Ho_Chi_Minh');
        $day_start_month =$now->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end_month = $now->endOfMonth()->isoFormat('YYYY-MM-DD');
        $checks = Check::select('user_id')
                        ->whereRaw("date(date_start) BETWEEN '".$day_start_month."' AND '".$day_end_month."'")
                        ->distinct()
                        ->get();
        //    dd($checks);
        return view('admin.pages.manageSchedule.statistic-checkin-out',
                    [
                        'checks' => $checks
                    ]);
    }

    public function ajaxStatistical(Request $request)
    {
        $month_input = $request->input('date');
        $date = Carbon::createFromDate(null, $month_input, 1, 'asia/Ho_Chi_Minh');
        $day_start_month = $date->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end_month = $date->endOfMonth()->isoFormat('YYYY-MM-DD');
        $checks = Check::select('user_id')
                        ->whereRaw("date(date_start) BETWEEN '".$day_start_month."' AND '".$day_end_month."'")
                        ->distinct()
                        ->get();
        // return response()->json(['data'=>$checks]);

        $data = [];
        $i=0;
        foreach ($checks as $key => $value) {
            $data[$key] = [
                'index' => ++$i,
                'name' => $value->user->name,
                'user_id' => $value->user_id
            ];
        }
        return response()->json([
            'data' => $data,
            'day_start_month' => $day_start_month,
            'day_end_month' => $day_end_month
        ]);
    }

    public function viewHisCheck($id, $number)
    {
        $monthNow = Carbon::now()->month;
        $date = Carbon::createFromDate(null, $number, 1, 'asia/Ho_Chi_Minh');
        $day_start = $date->startOfMonth()->isoFormat('YYYY-MM-DD');
        $day_end = $date->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($number == $monthNow){
            $checks = Check::where('user_id', $id)
                        ->whereRaw("date(date_start) BETWEEN '".$day_start."'AND'".Carbon::now()->subDay()->isoFormat('YYYY-MM-DD')."'")
                        ->orderByDesc('id')
                        ->get();
            $schedules = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$day_start, Carbon::now()->subDay()->isoFormat('YYYY-MM-DD')])
                        ->orderByDesc('id')
                        ->get();
            // dd($checks);
        } else{
            $checks = Check::where('user_id', $id)
                        ->whereRaw("date(date_start) BETWEEN '".$day_start."'AND'".$day_end."'")
                        ->orderByDesc('id')
                        ->get();
            $schedules = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$day_start, $day_end])
                        ->orderByDesc('id')
                        ->get();
            // dd($checks);
        }

        $sum_check = 0;
        foreach ($checks as $check) {
            if($check->date_end != null){
                $sum_check++;
            }
        }

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
        return response()->json(
                        [
                            'data'=>$data,
                            'note'=>$note,
                            'day_check' => $day_check
                        ], 200);
    }
    //=============================================Check-in===============================================
    public function checkin($id)
    {

        $this->authorize('isAuthor', $id);

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
        $member = Member::where('user_id', $id)->first();
        if($member !== null){
            $tasks = Assign::where('member_id', $member->id)->get();
            // dd($tasks);
            return view('user.pages.manage.check-in', ['schedule' => $schedule, 'tasks' => $tasks, 'isCheck'=>$isCheck, 'arrTask' => $arrTask, 'date_start'=>$checkin]);
        } else{
            return view('user.pages.manage.check-in', ['schedule' => $schedule, 'tasks' => 0, 'isCheck'=>$isCheck, 'arrTask' => $arrTask, 'date_start'=>$checkin]);
        }
    }

    public function postCheckin(Request $request, $id)
    {
        $schedule = Schedule::where('user_id', $id)->whereRaw("date(date) = '" . $request->input('ngaythuctap'). "'")->first();
        $input = $request->input('chon-task');
        $now = Carbon::now('asia/Ho_Chi_Minh')->toDateTimeString();

        $check = new Check();
        $check->user_id = $id;
        $check->date_start = $now;
        $check->schedule_id = $schedule->id;

        $check->save();

        if($input !== null){
            foreach($input as $value){
                $detailCheck = new DetailCheck();
                $detailCheck->check_id = $check->id;
                $detailCheck->task_id = (int)$value;
                $status = Task::find((int)$value);
                $detailCheck->status = $status->status;
                // dd($detailCheck->status);
                $detailCheck->save();
            }
        }
        Toastr::success('Bạn checkin thành công!', 'success');
        return redirect()->route('checkin', $id);
    }

    //========================================END Check-in=======================================
    //========================================Check-out=======================================
    public function checkout($id)
    {
        $this->authorize('isAuthor', $id);

        $now = Carbon::now()->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
        $schedule = Schedule::whereRaw("date(date) = '" . $now. "'")->first();

        $member = Member::where('user_id', $id)->first();
        $tasks = [];
        if($member !== null){
            $tasks = Assign::where('member_id', $member->id)->get();
        }
        // dd($tasks);
        $checkout = Check::whereRaw("date(date_start) = '".$now."'")->first();
        // dd($checkout);
        $arrTask = null;
        if($checkout !== null){
            $arrTask = DetailCheck::where('check_id', $checkout->id)->get();
            if($checkout->date_end !== null){
                return view('user.pages.manage.check-out',
                            [
                                'schedule'=>$schedule,
                                'tasks'=>$tasks,
                                'arrTask'=>$arrTask,
                                'isCheckout'=> 1,
                                'checkout' => $checkout
                            ]);
            }
            return view('user.pages.manage.check-out',
                        [
                            'schedule'=>$schedule,
                            'tasks'=>$tasks,
                            'arrTask'=>$arrTask,
                            'isCheckout'=> 2,
                            'checkout' => $checkout
                        ]);
        } else{
            return view('user.pages.manage.check-out',
                        [
                            'schedule'=>$schedule,
                            'tasks'=>$tasks,
                            'arrTask'=>$arrTask,
                            'isCheckout'=> 0,
                            'checkout' => $checkout
                        ]);
        }
    }

    public function postCheckout(Request $request, $id)
    {

        $now = Carbon::now('asia/Ho_Chi_Minh')->isoFormat('Y-M-D', 'asia/Ho_Chi_Minh');
        $checkout = Check::whereRaw("date(date_start) = '".$now."'")->first();
        $checkout->note = $request->input('note');
        $checkout->date_end = $request->input('ngaythuctap');
        $checkout->save();

        $arrTask = $request->input('idTask');
        $arrStatusTask = $request->input('status');

        if($arrTask !== null){
            foreach($arrTask as $key => $value)
            {
                $task = Task::find((int)$value);
                $task->status = (int)$arrStatusTask[$key];

                $detailCheck = DetailCheck::where('check_id',$checkout->id)
                                    ->where('task_id', $task->id)
                                    ->first();

                $detailCheck->status = (int)$arrStatusTask[$key];
                $detailCheck->save();
                $task->save();
            }
        }
        Toastr::success('Bạn checkout thành công!', 'Success');
        return redirect()->route('checkout', $id);
    }
    //========================================END Check-out=======================================
    //========================================START HISTORY SCHEDULE=======================================

    public function hisSchedule($id){

        $this->authorize('isAuthor', $id);

        $now = Carbon::now('asia/Ho_Chi_Minh');
        $end_month = $now->subDay()->format('Y-m-d');
        $start_month = $now->startOfMonth()->format('Y-m-d');
        $checks = Check::whereRaw("date(date_start) BETWEEN '" . $start_month. "' AND '".$end_month."'")
                        ->where('user_id', $id)
                        ->orderByDesc('id')
                        ->get();

        $schedules = Schedule::where('user_id', $id)
                            ->whereRaw("date(date) BETWEEN '" . $start_month. "' AND '".$end_month."'")
                            ->orderByDesc('id')
                            ->get();

        $day_work = 0;
        foreach ($schedules as $key => $schedule) {
            foreach ($checks as $key => $check) {
                if($check->schedule_id === $schedule->id && $check->date_end != null){
                    $day_work += 1;
                }
            }
        }
        $arrCheck = [];
        foreach ($checks as $key => $check) {
            $arrCheck[$key] = $check->schedule_id;
        }

        return view('user.pages.manage.view-history-check',
                    [
                        'schedules' => $schedules,
                        'checks' => $checks,
                        'arrCheck' => $arrCheck,
                        'count' => $day_work,
                    ]);

    }

    public function ajaxHisSchedule($id)
    {
        $details = DetailCheck::where('check_id', $id)->get();
        $check = Check::find($id);
        $data = [];
        foreach ($details as $key => $value) {
            $data[$key] = [
                'id' => $value->task_id,
                'name' => $value->task->name,
                'status' => $value->status
            ];
        }
        $note = $check->note;
        return response()->json(['data'=>$data, 'note'=>$note], 200);
    }
    //========================================START HISTORY SCHEDULE=======================================
}
