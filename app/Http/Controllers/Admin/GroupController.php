<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Internshipclass;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Group\GroupCreateRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Member;

class GroupController extends Controller
{
    private $group;
    private $intenshipClass;

    public function __construct(Group $group, Internshipclass $intenshipClass)
    {
        $this->group = $group;
        $this->intenshipClass = $intenshipClass;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->group->orderBy('id', 'DESC')->get();

        return view('admin.pages.manageGroup.list', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $internshipClasses = $this->intenshipClass->orderBy('id', 'DESC')->get();

        return view('admin.pages.manageGroup.add', compact('internshipClasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupCreateRequest $request)
    {
        $group = Group::where('class_id', $request->input('internshipclass'))->get();
        foreach ($group as $gr) {
            if ($gr->name == $request->name) {
                Toastr::warning('Tên nhóm đã tồn tại', 'warning');
                return back();
            }
        }

        $this->group->create([
            'name' => $request->input('name'),
            'topic' => $request->input('topic'),
            'note' => $request->input('note'),
            'class_id' => $request->input('internshipclass'),
            'status' => $request->input('status')
        ]);

        Toastr::success('Thêm thành công', 'success');
        return redirect()->route('manageGroup.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->group->findOrFail($id);
        $internshipClasses = $this->intenshipClass->orderBy('id', 'DESC')->get();

        return view('admin.pages.manageGroup.update', compact('group', 'internshipClasses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdateRequest $request, $id)
    {
        $group = $this->group->find($id);
        $group->update([
            'name' => $request->input('name'),
            'topic' => $request->input('topic'),
            'note' => $request->input('note'),
            'class_id' => $request->input('internshipclass'),
            'status' => $request->input('status')
        ]);

        Toastr::success('Cập nhật thành công', 'Success');
        return redirect()->route('manageGroup.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = $this->group->find($id);
        $user = Member::where('group_id', $group->id)->get();
        $count = count($user);
        if($count != 0){
            Toastr::warning('Xóa không thành công.Nhóm có sinh viên đang hoạt động!', 'Warning');

            return redirect()->route('manageGroup.index');
        }
        $group->delete();
        Toastr::success('Xóa thành công', 'success');

        return redirect()->route('manageGroup.index');
    }
}
