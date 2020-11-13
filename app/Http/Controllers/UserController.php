<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Member;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Internshipclass;
use App\Mail\SendDataUser;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function postLogin(Request $request)
    {
        $this->validate($request,
    		[
    			'account'=>'required',
    			'password'=>'required|min:3|max:32',
    		],
    		[
    			'account.required'=>'Bạn Chưa Nhập Tài Khoản',
    			'password.required'=>'Bạn Chưa Nhập Password',
            ]);
        $account = $request->input('account');
        $password = $request->input('password');

        $user = User::where('account', $account)->get()->first();
        if($user != null &&  $user->status == 0 ){
            return redirect('../public/#login')->with('thongbao', 'Tài khoản của bạn đã bị khóa');
        }
        else {
            if (Auth::attempt(['account' => $account, 'password' => $password])) {
                return back();
            }
            else
            {
                return redirect('../public/#login')->with('thongbao', 'Đăng Nhập Không Thành Công');
            }
        }
    }
    public function getLogout()
    {

        Auth::logout();
		$arr = [
			"message" => 'Thành công',
			"status" => 1
		];
    	return $arr;
    }
    public function postLosspassword(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        if($user == null){

            return abort(response()->json(['message' => 'Not Found'], 404));
        }
        else{
            $str = Str::random(10);
            $data = array(
                'name'      =>  $user->name,
                'message'   =>   $str
            );
            $us = User::find($user->id);
            $us->password = bcrypt($str);
            $us->save();
            Mail::to($user->email)->send(new SendMail($data));
            return abort(response()->json(['message' => 'OK'], 200));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = $this->user->where('position', 1)->orderByDESC('id')->paginate(5);
        // $students = $this->user->where('position', 1)->limit(5)->offset(0)->get();
        return view('admin.pages.manageStudents.list', compact('students'));
    }

    public function getListStudents(Request $request){
        $page = $request->has('page') ? $request->get('page') : 1;

        $students = $this->user->where('position', 1)->limit(5)->offset(($page - 1) * 5)->get();

        return response()->json(['data' => $students], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Internshipclass::all();
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $members = Member::where('group_id', $request->input("group_id"))->where('user_id', $id)->first();
        $users = User::find($id);
        return response()->json(['data'=>$users, 'position'=>$members->position], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {

        $this->authorize('isAuthor', $id);

        $user = User::find($id);
        return view('profiles.edit', ['user'=>$user]);


        // if($id == Auth::id()){
        //     return view('user.pages.personalInformation.updateInformation', ['user'=>$user]);
        // } else{
        //     return redirect('/#login');
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                Toastr::warning('Bạn chỉ được chọn file có đuổi png, jpg, jpeg', 'Warning');
                return redirect()->route('user.edit', $id);
            }
            $imgName = $file->getClientOriginalName();
            $hinh = Str::random(3).'_'.Carbon::now()->timestamp."_".$imgName;
            $file->move("image/user/", $hinh);
            if($user->image != ""){
                unlink('image/user/'.$user->image);
            }
            $user->image = $hinh;
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->save();
        Toastr::success('Bạn đã cập nhật thông tin thành công', 'success');
        return redirect()->route('user.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user , $id)
    {
        $user = User::find($id);
        if(file_exists("image/user/".$user->image)==false){
            unlink("image/user/".$user->image);
        }
        $user->delete();
        Toastr::success('Xóa thành công', 'success');
        return redirect()->route('manageStudents.index');
    }

    public function viewSchedule($id){
        return view('admin.pages.manageStudents.show-regSchedule');
    }


    public function updatestudent(UserUpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address= $request->address;
        $user->status = $request->status;

        if ($request->hasFile('image'))
        {
            $file =$request->file('image');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg') {
                Toastr::warning('Bạn chỉ chọn được file có đuôi  jpg, png, jpeg!', 'warning');
                return redirect()->route('editUser', $user->id);
            }
            $name = $file->getClientOriginalName();
            $Hinh= Str::random(4)."_".$name;
            while (file_exists("image/user".$Hinh))
            {
                $Hinh= Str::random(4)."_".$name;
            }
            $file->move("image/user",$Hinh);
            if(file_exists("image/user".$user->image)==false){

                unlink("image/user/".$user->image);
            }
            $user->image = $Hinh;
        }

        $user->save();
        Toastr::success('Cập nhật thành công', 'success');
        return back();
    }


    public function changepassword( ChangePasswordUserRequest $request, $id){

        $matkhau = $request->password;
        $password = Auth::User()->password;
        $id = Auth::user()->id;
        if(Hash::check($matkhau, $password)){

            $user = User::find(Auth::user()->id);
            $user->password =  bcrypt($request->password2);
            $user->save();
            Toastr::success('Thay đổi mật khẩu thành công!', 'Success');
            return redirect()->route('user.edit', Auth::id());
        }
        else{
            Toastr::error('Thay đổi mật khẩu thất bại', 'error');
            return redirect()->route('user.edit', Auth::id());
        }

    }
    public function editUser($id)
    {
        $user = $this->user->findOrFail($id);
        return view('admin.pages.manageStudents.update', compact('user'));
    }

    public function resetpassword($id)
    {
        $user = $this->user->findOrFail($id);
        $password = "123456";
        $user->password = Hash::make($password);
        $user->save();
        Toastr::success('Làm mới mật khẩu thành công!', 'Success');
        return redirect()->route('editUser', $id)->with('thongbao', 'Mật khẩu mới của '.$user->account.' là: '.$password);
    }

}

