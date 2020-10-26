<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAdd($id)
    {   
        return view('admin.pages.manageTasks.add', ['id'=>$id]);
    }
    public function postAdd($id , Request $request)
    {   
        $this->validate($request, [
            'nameTask' => 'required',
           
        ],[
            'nameTask.required' => 'Bạn chưa nhập tên task',
            
        ]);
        $task = new Task;
        $task->name = $request->nameTask;
        $task->group_id = $id;
        $task->note = $request->noteTask;
        $task->status = 1;
        $task->save();
        return back()->with('thongbao', 'Thêm task thành công');
    }
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
        return back()->with('thongbao', 'Xóa task thành công');
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
    public function create()
    {
        return view('admin.pages.manageTasks.add');
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
    public function edit(Task $task)
    {
        return view('admin.pages.manageTasks.update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
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
}
