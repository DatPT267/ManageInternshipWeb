<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Group;
use App\Member;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function infoGroupOfStudent($id)
    {
        if(Auth::id() == $id){
            $member = Member::where('user_id', $id)->firstOrFail();
            $group = Group::findOrFail($member->group_id);
            $members = Member::where('group_id', $group->id)->get();
            return view('user.pages.group.index',['group'=>$group, 'members'=>$members, 'user'=>$member->user_id]);
        } else{
            return redirect('/#login');
        }
    }
}
