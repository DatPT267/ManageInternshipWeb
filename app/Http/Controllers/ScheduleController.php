<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.manageSchedule.list');
    }

    public function getCheckinOut()
    {
        return view('admin.pages.manageSchedule.statistic-checkin-out');
    }

    public function getRegSchedule($id){
        if($id == Auth::id()){
            $now = Carbon::now();
            $startDayOfWeek = '';
            $endDayOfWeek = '';
            $check = 0;
            if($now->dayOfWeekIso >= 1){
                $now->addWeek();
                $startDayOfWeek = $now->startOfWeek()->format('Y-m-d');
                $endDayOfWeek = $now->endOfWeek()->format('Y-m-d');
                $scheduleUser = Schedule::select('date')
                            ->where('user_id', $id)
                            ->whereBetween('date', [$startDayOfWeek, $endDayOfWeek])
                            ->get();
                if(count($scheduleUser) > 0){
                    $check = 1;
                    return view('user.pages.manage.register-schedule', ['user'=>$id, 'check'=>$check, 'day_start'=>$startDayOfWeek, 'day_end'=>$endDayOfWeek, 'message'=> 'Bạn đã đăng ký lịch thực tập trước đó!']);
                }
            }
            return view('user.pages.manage.register-schedule', ['user'=>$id, 'check'=> 0, 'message'=> '','day_start'=>$startDayOfWeek, 'day_end'=>$endDayOfWeek ]);
        } else{
            return redirect('/#login');
        }
    }

    public function postRegSchedule(Request $request, $id){
        $user = User::find($id);
        $arrCaLam = array($request->input('thu2'),$request->input('thu3'),$request->input('thu4'),$request->input('thu5'),$request->input('thu6'));
        $now = Carbon::now();
        if($now->dayOfWeekIso >= 1){
            $now->addWeek();
            foreach ($arrCaLam as $key => $calam) {
                $now->startOfWeek()->format('Y-m-d');
                if($calam !== 'null'){
                    $scheduleSt = new Schedule();
                    $scheduleSt->user_id = $user->id;
                    $scheduleSt->session = $calam;
                    if($key == 0) $scheduleSt->date = $now;
                    else if($key == 1) $scheduleSt->date = $now->addDay();
                    else if($key == 2) $scheduleSt->date = $now->addDay(2);
                    else if($key == 3) $scheduleSt->date = $now->addDay(3);
                    else if($key == 4) $scheduleSt->date = $now->addDay(4);
                    $scheduleSt->save();
                }
            }
        }
        return redirect('user/'.$user->id.'/reg-schedule')->with(['user'=>$user, 'success'=>'Bạn đã tạo lịch đăng ký thực tập thành công']);
    }
}
