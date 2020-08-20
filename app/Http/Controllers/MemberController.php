<?php

namespace App\Http\Controllers;

use App\Member;
use App\Group;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listMemberGroup($id){
        $members = Member::where('group_id', $id)->get();
        $group = Group::where('id', $id)->first();
        return view('admin.pages.manageGroup.list-member', ['members'=>$members, 'group'=>$group]);
    }

    public function deleteMemberGroup($id, $id_member){
        $member = Member::find($id_member);
        $name = $member->user->name;
        if(isset($member)){
            $member->delete();
            return response()->json(['data'=>0, 'name'=>$name]);
        } else{
            return response()->json(['data'=>1]);
        }
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
