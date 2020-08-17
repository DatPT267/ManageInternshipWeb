<?php

namespace App\Http\Controllers;

use App\Group;
use App\Member;
use App\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function infoGroupOfStudent($id)
    {
        $user = Member::where('user_id', $id)->first();
        $group = Group::find($user->group_id);
        $members = Member::where('group_id', $group->id)->get();
        return view('user.pages.group.index',['group'=>$group, 'members'=>$members]);
    }
}
