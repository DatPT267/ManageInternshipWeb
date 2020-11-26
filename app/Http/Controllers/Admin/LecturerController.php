<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\StoreLecturerRequest;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LecturerController extends Controller
{
    private $lecturer;

    public function __construct(User $lecturer)
    {
        $this->lecturer = $lecturer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listLecturers = $this->lecturer->query();

        if($request->nameStudentSearch){
            $listLecturers = $listLecturers->where('name', 'LIKE', "%".trim($request->nameStudentSearch)."%");
        }
        if($request->emailSearch){
            $listLecturers = $listLecturers->where('email', 'LIKE', "%".trim($request->emailSearch)."%");
        }
        $listLecturers = $listLecturers->where('position', 2)->orderByDESC('id')->paginate(10);

        return view('admin.pages.manageLecturers.list', compact('listLecturers'));
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
    public function store(StoreLecturerRequest $request)
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
        $user->save();

        Toastr::success('Thêm thành công', 'success');
        return back();
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
        // $user = User::where('id', $id)->get()->first();
        $lecturer = $this->lecturer->where('id', $id)->get()->first();
        return view('admin.pages.manageLecturers.update', compact('lecturer'));
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
        $lecturer = $this->lecturer->findOrFail($id);

        $nameImage = $lecturer->image;
        if ($request->hasFile('image')){
            if($lecturer->image != ""){
                unlink("image/user/".$lecturer->image);
            }
            $nameImage = $this->uploadImage($request);
        }
        $status = 1;
        if(!$request->has('status')){
            $status = 0;
        }
        $lecturer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $status,
            'image' => $nameImage,
            'class_id' => $request->input('namedotthuctap')
        ]);

        Toastr::success('Cập nhật thành công', 'success');
        return redirect()->route('manageLecturer.edit', $id);
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
        Toastr::success('success', 'Xóa thành công');

        return back();
    }
    public function uploadImage($request){
        $nameImage = Str::random(3).'_'.Carbon::now()->timestamp."_".$request->file('image')->getClientOriginalName();
        $request->file('image')->move('image/user/', $nameImage);

        return $nameImage;
    }
}
