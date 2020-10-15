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

        $this->authorize('isAuthor', $id);

        $now = Carbon::now();
        $startDayOfWeek = $now->startOfWeek()->format('Y-m-d');
        $endDayOfWeek = $now->endOfWeek()->format('Y-m-d');
        $scheduleUser = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$startDayOfWeek, $endDayOfWeek])
                        ->get();
        //kiểm tra tuần hiện tại đã đăng ký chưa.
        // Nếu chưa cho đăng ký tuần hiện tại.
        // nếu đăng ký rồi. cho đăng ký tuần tiếp theo
        if(count($scheduleUser) > 0)
        {
            $now->addWeek();
            $startDayOfWeek = $now->startOfWeek()->format('Y-m-d');
            $endDayOfWeek = $now->endOfWeek()->format('Y-m-d');
            $scheduleUser = Schedule::where('user_id', $id)
                        ->whereBetween('date', [$startDayOfWeek, $endDayOfWeek])
                        ->get();
            //Kiểm tra tuần tiếp theo đã đăng ký chưa.
            // nếu chưa cho đăng ký,
            // nếu rồi. show danh sách lịch đăng ký từ tuần này đến tuần sau đã đăng ký
            if(count($scheduleUser) > 0)
            {
                $check = 1;
                $startDayOfWeek = $now->subWeek()->startOfWeek()->format('Y-m-d');
                $endDayOfWeek = $now->addWeek()->endOfWeek()->format('Y-m-d');
                $scheduleUser = Schedule::where('user_id', $id)
                            ->whereBetween('date', [$startDayOfWeek, $endDayOfWeek])
                            ->get();

                return view('user.pages.manage.register-schedule',
                            ['user'=>$id,
                            'check'=>$check,
                            'day_start'=>$startDayOfWeek,
                            'day_end'=>$endDayOfWeek,
                            'schedules' => $scheduleUser,
                            'message'=> 'Bạn đã đăng ký lịch thực tập tuần này và tuần sau rồi!']);
            }
            else
            {
                $startDayOfWeek = $now->startOfWeek()->format('Y-m-d');
                $endDayOfWeek = $now->endOfWeek()->format('Y-m-d');
                return view('user.pages.manage.register-schedule',
                        ['user'=>$id,
                        'check'=> 0,
                        'message'=> 'Bạn nên đăng ký lịch thực tập cho tuần sau',
                        'week' => 1,
                        'day_start'=>$startDayOfWeek,
                        'day_end'=>$endDayOfWeek ]);
            }
        }
        else
        {
            return view('user.pages.manage.register-schedule',
                        ['user'=>$id,
                        'check'=> 0,
                        'week' => 0,
                        'message'=> '',
                        'day_start'=>$startDayOfWeek,
                        'day_end'=>$endDayOfWeek ]);
        }
    }

    public function postRegSchedule(Request $request, $id){
        $user = User::find($id);
        $arrCaLam = array($request->input('thu2'),$request->input('thu3'),$request->input('thu4'),$request->input('thu5'),$request->input('thu6'));
        $now = Carbon::now();
        if($request->input('week') == 0){
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
        } else{
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
