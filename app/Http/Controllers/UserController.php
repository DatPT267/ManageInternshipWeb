<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.pages.personalInformation.updateInformation', ['user'=>$user]);
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
            'name' => 'required|min:2|max:50',
            'email' => 'email'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên ký tự bắt buộc trên 2 ký tự',
            'name.max' => 'Tên ký tự bắt buộc trên 2 ký tự',
            'email.email' => 'Email chưa đúng'
            ]);
        $user = User::find($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('user/'.$id)->with('fail', 'Bạn chỉ được chọn file có đuổi png, jpg, jpeg');
            }
            // $imgName = $file->getClientOriginalName();
            // $hinh = Str::random(3).'_'.Carbon::now()->timestamp."_".$imgName;
            $imgPath = $file->store('profiles', 'public');
            $image = Image::make('storage/'.$imgPath)->fit(1000, 1000);
            $image->save();
            // $file->move("storage/uploads", $hinh);
            if($user->image != null){
                unlink('storage/'.$user->image);
            }
            $user->image = $imgPath;
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
}
