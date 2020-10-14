<?php

namespace App\Http\Controllers;

use App\DetailGroup;
use App\Member;
use App\Group;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function listMemberGroup($id){
        $members = Member::where('group_id', $id)->get();
        $group = Group::where('id', $id)->firstOrFail();
        return view('admin.pages.manageGroup.list-member', ['members'=>$members, 'group'=>$group]);
    }

    public function deleteMemberGroup($id, $id_member){
        $member = Member::findOrFail($id_member);

        if(isset($member)){
            $name = $member->user->name;
            $group_id = $member->group_id;
            $user_id = $member->user_id;
            $detailGroup = DetailGroup::where('group_id', $group_id)->where('user_id', $user_id)->first();
            $detailGroup->delete();
            $member->delete();
            return response()->json(['data'=>0, 'name'=>$name]);
        } else{
            return response()->json(['data'=>1]);
        }
    }

    public function addMember($id){
        $group = Group::find($id);
        $students = User::where('class_id', $group->class_id)->where('status', '=', '1')->where('position', "<>", '3')->whereNotExists(function ($query){
            $query->select('*')
                ->from('member')
                ->whereRaw('member.user_id = users.id');
        })->get();

        // dd($students);
        return view('admin.pages.manageGroup.add-member', ['students'=>$students, 'group'=>$group]);
    }

    public function storeMember(Request $request, $id, $id_member){

        $memberNew = new Member();
        $memberNew->group_id = $id;
        $memberNew->user_id = $id_member;

        $position = $request->input('position');
        if($position == 0){
            $memberNew->position = $position;
            $memberNew->save();
            $detailGroup = new DetailGroup();
            $detailGroup->user_id = $id_member;
            $detailGroup->group_id = $id;
            $detailGroup->save();
            return response()->json(['data'=> 0, 'position'=> 0, 'name'=>$memberNew->user->name]);
        } else{
            $member = Member::where('group_id', $id)->where('position', $position)->first();
            if($member == null){
                $memberNew->position = $request->position;
                $memberNew->save();
                $detailGroup = new DetailGroup();
                $detailGroup->user_id = $id_member;
                $detailGroup->group_id = $id;
                $detailGroup->save();
                return response()->json(['data'=> 0, 'position'=> 0, 'name'=>$memberNew->user->name]);
            }else{
                return response()->json(['data'=> 1,'position'=> 1]);
            }
        }
    }

}
