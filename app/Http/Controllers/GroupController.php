<?php

namespace App\Http\Controllers;

use App\Group;
use App\Member;
use App\Task;
use App\Internshipclass;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listGroup = Group::all();
        return view('admin.pages.manageGroup.list', ['listGroup'=>$listGroup]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = Internshipclass::all();
 
        return view('admin.pages.manageGroup.add',['name'=>$name]);
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('admin.pages.manageGroup.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group, $id)
    {
        $group = Group::where('id', $id)->get()->first();
        return view('admin.pages.manageGroup.update',['group'=>$group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, $id)
    {
        $a = Group::find($id);
        $user = Member::where('group_id', $a->id)->get();
        $count = count($user);
        if($count != 0){
            return redirect('admin/manageGroup')->with('fail', 'Xóa không thành công.Nhóm có sinh viên đang hoạt động');
        }
        $a->delete();
        return redirect('admin/manageGroup')->with('success', 'Xóa thành công');
    }

    public function getListTask($id){
        $listTask = Task::where('group_id', $id)->get();
        $group = Group::find($id);
        // return $listTask->group->name->first();
        return view('admin.pages.manageGroup.list-task', ['listTask'=>$listTask, 'group'=>$group->name ]);
    }
    public function getListEvaluate($id){
        return view('admin.pages.manageGroup.list-Evaluate');
    }

    public function postSua(Request $request, $id)
    {
        
        $this->validate($request,
            [
                'name' =>'required',
                'topic'=>'required',
                'note'=>'required',
            ],
            [
                'name.required' =>'Bạn chưa nhập tên nhóm',
                'topic.required' => 'Bạn chưa nhập tên đề tài',               
            ]);
        $group = Group::find($id);
        $group->name = $request->name;
        $group->topic = $request->topic;
        $group->note = $request->note;
        $group->status = $request->status;
        $group->save();
        return back()->with('thongbao','Cập nhật thành công');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
        [
          
            'name' =>'required',
            'topic'=>'required',
            'note'=>'required',
        
        ],
        [
            'name.required' =>'Bạn chưa nhập tên nhóm',
            'topic.required' => 'Bạn chưa nhập đề tài nhóm',
          
        ]);
        $grounpcheck = Group::where('class_id', $request->namedotthuctap)->get();
        foreach ($grounpcheck as $gr) {
            if ($gr->name == $request->name) {
                return back()->with('thongbao', 'Tên nhóm đã tồn tại');
            }
        }

        
        
        $group = new Group;
        $group->name = $request->name;
        $group->topic = $request->topic;
        $group->note = $request->note;
        $group->class_id = $request->namedotthuctap;
        $group->status = $request->status;
        $group->save();

    
        return back()->with('thongbao','Thêm thành công');
    }
}
