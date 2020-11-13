<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $month)
    {
        $now = Carbon::createFromDate(null, $month, null, 'asia/Ho_Chi_Minh');
        // dd($now);
        $day_start_week = $now->startOfWeek()->isoFormat('Y-M-D');
        $day_end_week = $now->endOfWeek()->isoFormat('Y-M-D');
        $name = User::find($id);
        $schedules = Schedule::where('user_id', $id)
                            ->whereRaw("date(date) BETWEEN '".$day_start_week."' AND '".$day_end_week."'")
                            ->get();
        // dd($schedules);
        return view('admin.pages.manageStudents.show-regSchedule',
                        [
                            'schedules' => $schedules,
                            'name' => $name->name,
                            'month' => $month,
                            'id' => $id,
                            'week' => $now->weekNumberInMonth,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
