<?php

namespace App\Http\Controllers;

use App\Task;
use App\Member;
use App\Assign;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class TaskController extends Controller
{
 
    public function getUpdate($id)
    {   
        $arr[1]="Todo";
        $arr[2]="Doing";
        $arr[3]="Review";
        $arr[4]="Done";
        $arr[5]="Pending";
        $task = Task::find($id);
        return view('admin.pages.manageTasks.update', ['task'=>$task, 'arr'=>$arr]);
    }
    public function postUpdate($id, Request $request)
    {   
        $this->validate($request, [
            'nameTask' => 'required',
           
        ],[
            'nameTask.required' => 'Bạn chưa nhập tên task',
            
        ]);
        $task = Task::find($id);
        $task->name = $request->nameTask;
        $task->status = $request->statusTask;
        $task->note = $request->noteTask;
        $task->save();
        return back()->with('thongbao', 'Cập nhật task thành công');
    }
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();
        Toastr::success('success', 'Xóa task thành công');
        return back();
    }
    public function getDetail()
    {
        return view('admin.pages.manageTasks.detail'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.manageTasks.list');
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.pages.manageTasks.add', [ 'id' => $id]);
    }
    public function addTask(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
            
        ],[
            'name.required' => 'Bạn chưa nhập tên Task',
            
        ]);
        // $tasks = Task::where('group_id', $id)->get();
        // foreach( $tasks as $t){
        //     if ( $t->name ==  $request->name) {
                
        //     }
        // }
        
        $task = new Task;
        $task->name = $request->name;
        $task->group_id = $id;
        $task->note = $request->note;
        $task->status = $request->optradio;
        $task->save();
        return back()->with('thongbao', 'Thêm task thành công');
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('admin.pages.manageTasks.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {      
        $task = Task::find($id);
        $member = Member::where('group_id', $task->group_id)->get();
        $assign = Assign::where('task_id', $id)->get();
     
        return view('admin.pages.manageTasks.update', [ 'task' => $task, 'member' => $member, 'assign' => $assign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
       
        $this->validate($request, [
            'name' => 'required',
            
        ],[
            'name.required' => 'Bạn chưa nhập tên Task',
          
            
        ]);
        $task = Task::find($id);
        $task->name = $request->name;
        $task->note = $request->note;
        $task->status = $request->optradio;
        $task->save();
        return back()->with('thongbao', 'Cập nhật task thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
    public function assign($id_task, $id_member)
    {   
        $assign = Assign::where('task_id', $id_task)->get();
        foreach($assign as $as){
            if($as->member_id == $id_member){
                $delete = Assign::where('member_id', $id_member )->where('task_id', $id_task)->take(1) ;
                $delete->delete();
                return 0;
            }
        }   
        $add = new Assign();
        $add->task_id = $id_task;
        $add->member_id = $id_member;
        $add->save();
        return 1;
    }
}
