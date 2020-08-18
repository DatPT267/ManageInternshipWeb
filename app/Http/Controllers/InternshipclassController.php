<?php

namespace App\Http\Controllers;

use App\Group;
use App\Internshipclass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
    public function edit(Internshipclass $internshipclass, $id)
    {
       $class = Internshipclass::where('id', $id)->get()->first();
        return view('admin.pages.internshipClass.update', ['class'=>$class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Internshipclass $internshipclass)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Internshipclass  $internshipclass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Internshipclass::find($id);
        $user = User::where('class_id', $a->id)->get();
        $count = count($user);
        if($count != 0){
            return redirect('admin/internshipClass')->with('fail', 'Xóa không thành công. Đợt có nhóm hoặc sinh viên đang hoạt động');
        }
        $a->delete();
        return redirect('admin/internshipClass')->with('success', 'Xóa thành công');
    }

    // public function getThem()
    // {   
       
    // 	return view('admin/pages/internshipClass/add');
    // }
    public function postThem(Request $request)
    {
        $this->validate($request,
            [
              
                'name' =>'required|unique:Internshipclass,name',
                'start_day'=>'required|date',
                'end_day'=>'required|date',
                'student_amount'=>'required'
                
            ],
            [
                'name.unique' => 'Tên đợt thực tập đã tồn tại',
                'name.required' =>'Bạn chưa nhập tên câu lạc bộ',
                'start_day.required' => 'Bạn chưa nhập ngày bắt đầu',
                'end_day.required' => 'Bạn chưa nhập ngày kết thúc',
                'student_amount.required'=> 'Bạn chưa nhập số lượng sinh viên'
                
            ]);

            for( $i=0 ; $i < $request->student_amount ; $i++){
                $member[$i] = $i;
            }       
            $fullName = "Nguyễn Văn Đạt A";
            $name = changeTitle($fullName);
            $words = explode("-", $name);
            $lastName = array_pop($words); 
            
            $acronym = "";
            
            foreach ($words as $w) {
              $acronym .= $w[0];
            }
            return $acronym;
        $internshipclass = new Internshipclass;
        $internshipclass->name = $words[0];
        $internshipclass->start_day = $request->start_day;
        $internshipclass->end_day = $request->end_day;
        $internshipclass->note = $request->note;
        $internshipclass->save();
        
        
        return view('admin/pages/internshipClass/memberinternshipclass', ['member' => $member, 'nameclass' => $request->name ])->with('thongbao','Thêm thành công');
    }

    public function postSua(Request $request, $id)
    {
        
        $this->validate($request,
            [
              
                'name' =>'required',
                'start_day'=>'required|date',
                'end_day'=>'required|date',
                
            ],
            [
                'name.required' =>'Bạn chưa nhập tên đợt thực tập',
                'start_day.required' => 'Bạn chưa nhập ngày bắt đầu',
                'end_day.required' => 'Bạn chưa nhập ngày kết thúc',
                
            ]);


        $internshipclass = Internshipclass::find($id);
        $internshipclass->name = $request->name;
        $internshipclass->end_day = $request->end_day;
        $internshipclass->note = $request->note;
       
      
        $internshipclass->save();
        return back()->with('thongbao','Cập nhật thành công');
    }

    public function postMember(Request $request, $nameclass, $amount){
        

        for($i =0 ; i<= $amount; $i++){

            $user = new User;

        }
        

    }

    public function getTest(){
        $fullName = "Nguyễn Văn Đạt A";
        $words = explode(" ", $fullName);
        $lastName = array_pop($words); 
        
        $acronym = "";
        foreach ($words as $w) {
            $acronym = changeTitle($acronym);
            $acronym .= $w[0];
        }
        return $acronym;
    }


    public function Test1(){
        $fullName = "Nguyễn Văn Đạt A";
        $words = explode(" ", $fullName);
        $lastName = array_pop($words); 
        
        $acronym = "";
        foreach ($words as $w) {
            $acronym = changeTitle($acronym);
            $acronym .= $w[0];
        }
    
        return view('admin.pages.internshipClass.test', ['acronym' => $acronym]);
    }
    
}
