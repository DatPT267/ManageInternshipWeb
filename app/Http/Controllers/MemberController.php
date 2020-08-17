<?php

namespace App\Http\Controllers;

use App\Member;
use App\Group;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function listMemberGroup($id){
        $members = Member::where('group_id', $id)->get();
        $nameGroup = Group::where('id', $id)->first();

        return view('admin.pages.manageGroup.list-member', ['members'=>$members, 'nameGroup'=>$nameGroup->name]);
    }

    public function deleteMemberGroup($id, $id_member){
        $member = Member::where([
            ['group_id', (int)$id],
            ['user_id', (int)$id_member]
        ])->first();
        $name = $member->user->name;
        $member->delete();

        return redirect('admin/group/'.$id.'/list-member')->with('success','Bạn đã xóa thành viên <strong>'.$name.'</strong> thành công!');
    }

    public function DeleteAjax($id)
    {
        $member = Member::find($id);
        if($member){
            $member->delete();
            return response()->json(['ok'=>'ok']);
        } else
        {
            return response()->json(['fail'=>'fail']);
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
