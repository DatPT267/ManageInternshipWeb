<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Group;
use App\Member;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.manageGroup.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.manageGroup.add');
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('admin.pages.manageGroup.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('admin.pages.manageGroup.update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function getListTask($id){
        $member = Member::where('user_id', $id)->firstOrFail();
        $members = Member::where('group_id', $member->group_id)->get();
        $arrTask = [];
        foreach ($members as $key => $value) {
            if(Assign::where('member_id', $value->id)->exists()){
                $assign = Assign::where('member_id', $value->id)->first();
                $arrTask[$key] = array([$assign->task->name => $value->user->name]);
            }
        }
        return response()->json(['data'=>$arrTask]);
    }
    public function getListEvaluate($id){
        return view('admin.pages.manageGroup.list-Evaluate');
    }
}
