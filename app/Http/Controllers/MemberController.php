<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show(Request $request, $id)
    {
        $members = Member::where('group_id', $request->input("group_id"))->where('user_id', $id)->first();
        $users = User::find($id);
        return response()->json(['data'=>$users, 'position'=>$members->position], 200);
    }
}
