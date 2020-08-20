<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('admin.pages.manageGroup.list-task');
    }
    public function getListEvaluate($id){
        return view('admin.pages.manageGroup.list-Evaluate');
    }

    public function listMemberGroup($id){
        $members = Member::where('group_id', $id)->get();
        $nameGroup = Group::where('id', $id)->first();

        return view('admin.pages.manageGroup.list-member', ['members'=>$members, 'nameGroup'=>$nameGroup->name]);
    }

    public function deleteStudentGroup($id, $id_member){
        $user = User::find($id_member);
        $member = Member::where([
            ['group_id', (int)$id],
            ['user_id', (int)$id_member]
        ])->first();
        $member->delete();

        return redirect('admin/group/'.$id.'/list-member')->with('success','Bạn đã xóa thành viên <strong>'.$user->name.'</strong> thành công!');
    }

    public function addMember($id){
        $group = Group::find($id);
        $students = User::where('class_id', $group->class_id)->where('status', '<>', '1')->whereNotExists(function ($query){
            $query->select('*')
                ->from('member')
                ->whereRaw('member.user_id = users.id');
        })->get();

        // dd($students);
        return view('admin.pages.manageGroup.add-member', ['students'=>$students, 'group'=>$group->id]);
    }

    public function storeMember($id, $id_member){
        $user = User::find($id_member);
        $group = Group::find($id);

        $memberNew = new Member();
        $memberNew->group_id = $group->id;
        $memberNew->user_id = $user->id;
        $memberNew->position = 0;
        $memberNew->save();

        return redirect('admin/group/'.$id.'/add-member')->with('success', 'Bạn đã thêm thành công thành viên <strong>'.$user->name.'</strong> vào nhóm <strong>'.$group->name.'</strong>');
    }
}
