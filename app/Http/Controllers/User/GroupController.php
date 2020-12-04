<?php

namespace App\Http\Controllers\User;

use App\Assign;
use App\DetailGroup;
use App\Group;
use App\Http\Controllers\Controller;
use App\Member;
use App\Task;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    private $group;
    private $detailGroup;
    private $task;
    private $assign;

    public function __construct(Group $group,
                                DetailGroup $detailGroup,
                                Task $task,
                                Assign $assign){
        $this->group = $group;
        $this->detailGroup = $detailGroup;
        $this->task = $task;
        $this->assign = $assign;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->authorize('isAuthor', $id);
        $groups = $this->detailGroup->where('user_id', $id)->get();
        return view('user.pages.group.listGroup', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $id_group)
    {
        $this->authorize('isAuthor', $id);

        $member = Member::where('user_id', $id)->firstOrFail();
        $group = Group::findOrFail($id_group);
        $members = Member::where('group_id', $id_group)->get();
        // dd($members);
        return view('user.pages.group.index',['group'=>$group, 'members'=>$members, 'user'=>$member->user_id]);

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
    public function destroy($id)
    {
        //
    }

    public function getListTaskUser($id, $group_id){
        $tasks = $this->task->where('group_id', $group_id)->get();
        $data = [];
        foreach ($tasks as $key => $task) {
            $assigns = $this->assign->where('task_id', $task->id)->get();
            $name_member = [];
            if(count($assigns) > 0){
                foreach ($assigns as $index => $assign) {
                    $name_member[$index] = $assign->member->user->name;
                }
            }
            $data[$key] = [
                'index' => $key + 1,
                'name' => $task->name,
                'status' => $task->status,
                'name_member' => $name_member,
                'note' => $task->note
            ];
        }
        return response()->json(['data'=>$data]);
    }
}
