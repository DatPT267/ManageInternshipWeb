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
    public function infoGroupOfStudent($id, $id_group)
    {

        $this->authorize('isAuthor', $id);

        $member = Member::where('user_id', $id)->firstOrFail();
        $group = Group::findOrFail($id_group);
        $members = Member::where('group_id', $id_group)->get();
        // dd($members);
        return view('user.pages.group.index',['group'=>$group, 'members'=>$members, 'user'=>$member->user_id]);

    }
}
