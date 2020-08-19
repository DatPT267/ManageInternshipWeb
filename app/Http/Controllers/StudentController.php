<?php

namespace App\Http\Controllers;

use App\Assign;
use App\Group;
use App\Member;
use App\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function infoGroupOfStudent($id)
    {
        $member = Member::where('user_id', $id)->firstOrFail();
        $group = Group::findOrFail($member->group_id);
        $members = Member::where('group_id', $group->id)->get();
        return view('user.pages.group.index',['group'=>$group, 'members'=>$members, 'user'=>$member->user_id]);
    }
}
