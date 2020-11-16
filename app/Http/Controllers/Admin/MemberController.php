<?php

namespace App\Http\Controllers\Admin;

use App\DetailGroup;
use App\Group;
use App\Http\Controllers\Controller;
use App\Member;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $member;
    private $group;
    private $user;

    public function __construct(Member $member, Group $group, User $user)
    {
        $this->member = $member;
        $this->group = $group;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        $students = $this->user->where('class_id', $group->class_id)
                                ->whereStatus(1)
                                ->wherePosition(1)
                                ->whereNotExists(function ($query){
                                    $query->select('*')
                                        ->from('member')
                                        ->whereRaw('member.user_id = users.id');
                                })->get();


        return view('admin.pages.manageGroup.add-member', compact('students', 'group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id, $id_member)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $members = $this->member->where('group_id', $group->id)->get();

        return view('admin.pages.manageGroup.list-member', compact('group', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_member)
    {
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
}
