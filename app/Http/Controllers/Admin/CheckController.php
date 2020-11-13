<?php

namespace App\Http\Controllers\Admin;

use App\Check;
use App\DetailCheck;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckController extends Controller
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
    public function show($id, $number)
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
        // dd($checks);
        $sum_check = 0;
        foreach ($checks as $check) {
            if($check->date_end != null){
                $sum_check++;
            }
        }
        // dd($sum_check);
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
