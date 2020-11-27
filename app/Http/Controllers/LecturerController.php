<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lecturer\StoreLecturerRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listLecturers = User::Where('position', 2)->orderBy('id', 'desc')->get();
        return view('admin.pages.manageLecturers.list', ['listLecturers'=> $listLecturers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.manageLecturers.add');
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
        $user = User::find($id);
        if(file_exists("image/user".$user->image)==false){

          unlink("image/user/".$user->image);
        }

        $user->delete();
        return back()->with('success', 'Xóa thành công');
    }
    public function postThem(StoreLecturerRequest $request)
    {

        $fullName = $request->name;
        $name = changeTitle($fullName);
        $words = explode("-", $name);
        $lastName = array_pop($words);
        $lastName = ucfirst( $lastName );
        $acronym = "";
        foreach ($words as $w) {
            $str = lowercaseToUppercase($w[0]);
            $acronym .= $str;
        }
        $lastName = $lastName .= $acronym;
        $lastName1 = $lastName;
        $dem = 0;
        do {
          $dem++;

          $lastName = $lastName1.''.$dem;
          $user = User::where('account', $lastName)->get()->first();
        } while ($user != null);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->password = bcrypt("123456789");
        $user->status = 1;
        $user->position = 2;
        $user->account = $lastName;


        if ($request->hasFile('image'))
        {

            $file =$request->file('image');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg') {
                Toastr::warning('Bạn chỉ chọn được file có đuôi  jpg, png, jpeg!', 'warning');
                return redirect()->route('manageStudents.create');
            }
            $name = $file->getClientOriginalName();
            $Hinh= Str::random(4)."_".$name;
            while (file_exists("image/user".$Hinh))
            {
                $Hinh= Str::random(4)."_".$name;
            }
            $file->move("image/user",$Hinh);
            $user->image = $Hinh;
        }
        else
        {
            $name = 'avatar';
            $Hinh= Str::random(4)."_".$name;
            while (file_exists("image/user".$Hinh))
            {
                $Hinh= Str::random(4)."_".$name;
            }
            $file = File::copy(base_path('public\image\user\avatar.jpg'),base_path('public/image/user/'.$Hinh));


            $user->image = $Hinh;
        }
        $user->save();

        Toastr::success('Thêm thành công', 'success');
        return back();
    }
    public function editLecturer(User $user, $id)
    {
        $user = User::where('id', $id)->get()->first();
        return view('admin.pages.manageLecturers.update', ['user'=>$user]);
    }
}
