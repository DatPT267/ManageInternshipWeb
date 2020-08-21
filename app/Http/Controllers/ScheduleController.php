<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\User;
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
        return view('admin.pages.manageSchedule.list');
    }

    public function getCheckinOut()
    {
        return view('admin.pages.manageSchedule.statistic-checkin-out');
    }

    public function getRegSchedule($id){
        $user = User::find($id);
        return view('admin.pages.manageSchedule.reg-schedule', ['user'=>$user]);
    }

    public function postRegSchedule(Request $request, $id){
        $user = User::find($id);
        $arrCaLam = array($request->input('thu2'),$request->input('thu3'),$request->input('thu4'),$request->input('thu5'),$request->input('thu6'));
        foreach ($arrCaLam as $key => $calam) {
            if($calam !== 'null'){
                echo $key.'-'.$calam."<br>";
            }
        }
        return view('admin.pages.manageSchedule.reg-schedule', ['user'=>$user]);
    }
}
