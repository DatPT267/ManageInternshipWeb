<?php

namespace App\Http\Controllers;

use App\Check;
use App\DetailCheck;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
class ScheduleController extends Controller
{
    public function index(){
        $now = Carbon::now();
        $month = $now->month;
        $day_start_month = $now->startOfMonth()->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_month = $now->endOfMonth()->addMonth()->startOfWeek()->subDay()->isoFormat('YYYY-MM-DD');
        // dd($day_end_week);
        $schedules = Schedule::select('user_id')
                        ->whereBetween('date', [$day_start_month, $day_end_month])
                        ->distinct()
                        ->get();
        // dd($schedules);
        return view('admin.pages.manageSchedule.list',['schedules' => $schedules, 'month' => $month]);
    }

    public function ajaxViewListSchedule(Request $request){
        $date_input = $request->input('date');
        $date = Carbon::createFromDate(null, $date_input, 1, 'asia/Ho_Chi_Minh');
        $day_start_month = $date->startOfMonth()->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_month = $date->endOfMonth()->addMonth()->startOfWeek()->subDay()->isoFormat('YYYY-MM-DD');
        $schedules = Schedule::select('user_id')
                            ->whereBetween('date', [$day_start_month, $day_end_month])
                            ->distinct()
                            ->get();
        $data = [];
        foreach ($schedules as $key => $value) {
            $data[$key] = [
                'id' => $key,
                'user_id' => $value->user_id,
                'name' => $value->user->name
            ];
        }
        return response()->json([
            'data' => $data,
            'day_start_month' => $day_start_month,
            'day_end_month' => $day_end_month
        ]);
    }

    public function viewSchedule($id, $month){
        $todayMonth = Carbon::now()->month;
        // dd($week);
        $now = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
        // dd($now);
        $day_start_week = $now->startOfWeek()->isoFormat('Y-M-D');
        $day_end_week = $now->endOfWeek()->isoFormat('Y-M-D');
        $name = User::find($id);
        $schedules = Schedule::where('user_id', $id)
                            ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                            ->get();
        // dd($day_start_week);
        return view('admin.pages.manageStudents.show-regSchedule',
                        [
                            'schedules' => $schedules,
                            'name' => $name->name,
                            'month' => $month,
                            'id' => $id,
                            'numberWeekOfMonth' => Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->endOfMonth()->weekOfMonth
                        ]);
    }

    public function ajaxViewSchedule(Request $request){
        $month = $request->input('month');
        $week = $request->input('week');
        $id = $request->input('id');
        // $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week)->month($month);
        if($month == 1){
            $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->week($week);
        } elseif($month == 12){
            $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week+1)->month($month);
        }elseif($month == 11){
            if($week != 1){
                $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week-1)->month($month);
            } else{
                $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
            }
        } else{
            if($week != 1){
                $date = Carbon::createFromDate(null, $month - 1, 1, 'asia/Ho_Chi_Minh')->week($week)->month($month);
            } else{
                $date = Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh');
            }
        }
        $day_start_week = $date->startOfWeek()->isoFormat('YYYY-MM-DD');
        $day_end_week = $date->endOfWeek()->isoFormat('YYYY-MM-DD');
        $schedules = Schedule::where('user_id', $id)
                    ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                    ->get();
        $data = [];
        foreach ($schedules as $key => $value) {
            $data[$key] = [
                'index' => $key,
                'englishDayOfWeek' => Carbon::parse($value->date)->englishDayOfWeek,
                'date' => Carbon::parse($value->date)->isoFormat('DD-MM-YYYY'),
                'session' => $value->session
            ];
        }
        return response()->json([
            'data' => $data,
            'day_start_week' => $day_start_week,
            'day_end_week' => $day_end_week,
            'week2' => $date->weekNumberInMonth,
            'week' => Carbon::createFromDate(null, $month, 1, 'asia/Ho_Chi_Minh')->endOfMonth()->weekOfMonth,
            'date' => $date
        ]);
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
                Toastr::success('Bạn đăng ký lịch thực tập thành công!', 'success');
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
            Toastr::success('Bạn đăng ký lịch thực tập thành công!', 'success');
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
