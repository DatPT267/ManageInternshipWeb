<?php

namespace App\Http\Controllers;

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

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit($id)
    {
        if($id == Auth::id()){
            $user = User::find($id);
            return view('user.pages.profiles.edit', ['user'=>$user]);
        } else{
            return abort('403');
        }

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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'email',
            'name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11'
        ],[
            'email.email' => 'Email chưa đúng',
            'name.required' => 'Bạn chưa nhập tên',
            'phone.required' => "Bạn chưa nhập số điện thoại",
            'phone.regex' => "Số điện thoại không đúng",
            'phone.min' => 'Số điện thoại từ 10 kí tự số.'
        ]);
        $user = User::find($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('user/'.Auth::id())->with('fail', 'Bạn chỉ được chọn file có đuổi png, jpg, jpeg');
            }
            $imgName = $file->getClientOriginalName();
            $hinh = Str::random(3).'_'.Carbon::now()->timestamp."_".$imgName;
            // $imgPath = $file->store('profiles', 'public');
            // $image = Image::make('storage/'.$imgPath)->fit(1000, 1000);
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

        return redirect('user/'.$id.'/edit')->with('success', 'Bạn đã cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function changepassword( Request $request, $id){
        $this->validate($request, [
            'password' => 'required',
            'password1' => 'required|min:6|max:50',
            'password2'=> 'required|same:password1',
        ],[
            'password.required' => 'Bạn chưa nhập mật khẩu cũ',
            'password1.required' => 'Bạn chưa nhập mật khẩu mới',
            'password1.min' => 'Mật khẩu ít nhất phải có 6 kí tự',
            'password1.max' => 'Mật khẩu nhiều nhất chỉ có 50 kí tự',
            'password2.required' => 'Bạn chưa nhập mật khẩu mới',
            'password2.min' => 'Mật khẩu ít nhất phải có 6 kí tự',
            'password2.max' => 'Mật khẩu nhiều nhất chỉ có 50 kí tự',
            'password2.same'=>  'Mật khẩu mới không khớp',
        ]);

        if(Auth::check()){
            $matkhau = $request->password;
            $password = Auth::User()->password;
            $id = Auth::user()->id;
            if(Hash::check($matkhau, $password)){

                $user = User::find(Auth::user()->id);
                $user->password =  bcrypt($request->password2);
                $user->save();
                return redirect('user/'.$id.'/edit#changepassword')->with('thongbao', 'Đổi mật khẩu thành công ');
            }

            else{
                return redirect('user/'.$id.'/edit#changepassword')->with('thongbao', 'Mật khẩu cũ không đúng');
            }
        }

    }

}
