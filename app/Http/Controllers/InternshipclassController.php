<?php

namespace App\Http\Controllers;

use App\Group;
use App\Internshipclass;
use Illuminate\Http\Request;

class InternshipclassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listClass = Internshipclass::all();
        return view('admin.pages.internshipClass.list', ['listClass'=>$listClass]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.internshipClass.add');
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
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    public function show(Internshipclass $internshipclass)
    {
        return view('admin.pages.internshipClass.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    public function edit(Internshipclass $internshipclass)
    {
        return view('admin.pages.internshipClass.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Internshipclass $internshipclass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Internshipclass::find($id);
        $group = Group::where('class_id', $a->id)->get();
        $count = count($group);
        if($count != 0){
            return redirect('admin/internshipClass')->with('fail', 'Xóa không thành công.');
        }
        $a->delete();
        return redirect('admin/internshipClass')->with('success', 'Xóa thành công');
    }
}
