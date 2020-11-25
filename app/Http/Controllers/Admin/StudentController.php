<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Internshipclass;
use App\Mail\SendDataUser;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    private $user;
    private $internshipClass;

    public function __construct(User $user, Internshipclass $internshipClass)
    {
        $this->user = $user;
        $this->internshipClass = $internshipClass;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $students = $this->user->wherePosition(1)->orderByDESC('id')->paginate(10);
        $students = $this->user->select('users.*');

        if($request->nameStudentSearch){
            $students = $students->where('users.name', 'LIKE', "%".trim($request->nameStudentSearch)."%");
        }
        if($request->nameStudentSearch){
            $students = $students->where('email', 'LIKE', "%".trim($request->emailSearch)."%");
        }
        if($request->nameInternshipclassSearch){
            $students = $students->join('internshipclass', 'users.class_id', '=', 'internshipclass.id')->where("internshipclass.name", "LIKE", "%" . trim($request->nameInternshipclassSearch) . "%");
        }
        $students = $students->wherePosition(1)->orderByDESC('users.id')->paginate(10);

        return view('admin.pages.manageStudents.list', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = $this->internshipClass->all();

        return view('admin.pages.manageStudents.add', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
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
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone_number');
        $user->address = $request->input('address');

        $user->password = Hash::make('123456');
        $user->status = 1;
        $user->position = 1;
        $user->class_id = $request->input('namedotthuctap');
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
        $data = [
            'name' => $user->name,
            'account' => $user->account,
            'password' => '123456'
        ];
        Mail::to($user->email)->send(new SendDataUser($data));
        Toastr::success('Thêm thành công! Thông tin tài khoản đã gửi qua mail của sinh viên', 'success');
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
        $student = $this->user->findOrFail($id);
        $classes = $this->internshipClass->all();
        return view('admin.pages.manageStudents.update', compact('student', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);

        $nameImage = $user->image;
        if ($request->hasFile('image')){
            if($user->image != ""){
                unlink("image/user/".$user->image);
            }
            $nameImage = $this->uploadImage($request);
        }
        $status = 1;
        if(!$request->has('status')){
            $status = 0;
        }
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $status,
            'image' => $nameImage,
            'class_id' => $request->input('namedotthuctap')
        ]);

        Toastr::success('Cập nhật thành công', 'success');
        return redirect()->route('manageStudents.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);
        if($user->image != ""){
            unlink('image/user/'.$user->image);
        }
        $user->delete();
        Toastr::success('Xóa thành công', 'success');
        return redirect()->back();
    }

    public function resetpassword(User $user)
    {
        if($user->email != null){
            $password = Str::random(6);
            $user->password = Hash::make($password);
            $user->save();
            $data = [
                'name' => $user->name,
                'account' => $user->account,
                'password' => $password
            ];
            Mail::to($user->email)->send(new SendDataUser($data));
            Toastr::success('Làm mới mật khẩu thành công!', 'Success');
            return redirect()->back()->with('thongbao', 'Mật khẩu mới đã được gửi tới mail của '. $user->name);
        } else{
            Toastr::warning($user->name.' chưa nhập thông tin email', 'Success');
            return redirect()->back();
        }
    }

    public function uploadImage($request){
        $nameImage = Str::random(3).'_'.Carbon::now()->timestamp."_".$request->file('image')->getClientOriginalName();
        $request->file('image')->move('image/user/', $nameImage);

        return $nameImage;
    }

    public function checkEmailAreadyExist(Request $request){
        $user = $this->user->find($request->id);
        // dd(1);
        if($user->email != $request->email){
            $emailExist = $this->user->where('email', $request->email)->get();
            if(!$emailExist->isEmpty()){
                return "false";
            } else{
                return "true";
            }
        }else{
            return "true";
        }
    }
    public function checkEmailAreadyExistAddStudent(Request $request){
        $emailExist = $this->user->where('email', $request->email)->get();
        if(!$emailExist->isEmpty()){
            return "false";
        } else{
            return "true";
        }
    }

    public function changeStatusStudent(Request $request){
        $user = $this->user->findOrFail($request->id);
        if($request->status == "1"){
            $user->update([
                'status' => 0
            ]);
        } else{
            $user->update([
                'status' => 1
            ]);
        }

    }
}
