<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Internshipclass;

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
        $listStudent = User::all();
        return view('admin.pages.manageStudents.list', ['listStudent'=>$listStudent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $class = Internshipclass::all();
        return view('admin.pages.manageStudents.add', ['class'=>$class]);
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
    public function edit(User $user, $id)
    {

        if($id == Auth::id()){
            $user = User::find(Auth::id());
            return view('user.pages.personalInformation.updateInformation', ['user'=>$user]);
        } else{
            $user = User::find(Auth::id());
            return redirect('user/'.Auth::id().'/edit')->with('user', $user);
        }
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
            'email' => 'email'
        ],[
            'email.email' => 'Email chưa đúng'
            ]);
        $user = User::find(Auth::id());

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
            if($user->image != null){
                unlink('image/user/'.$user->image);
            }
            $user->image = $hinh;
        }

        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->save();

        return redirect('user/'.Auth::id().'/edit')->with('success', 'Bạn đã cập nhật thành công');
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
    

    public function postSua(Request $request, $id)
    {
        
        $this->validate($request,
            [
                'name' =>'required',
                'email'=>'required|email',
                'phone'=>'required',
            ],
            [
                'name.required' =>'Bạn chưa nhập tên sinh viên',
                'email.required' => 'Bạn chưa nhập email sinh viên',  
              
                'email.unique' => 'Email đã tồn tại',
                'phone.required' => 'Bạn chưa nhập số điện thoại'           
            ]);
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address= $request->address;
              
            if ($request->hasFile('image')) 
            {   

                $file =$request->file('image');
                $duoi = $file->getClientOriginalExtension();
                if ($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg') {
                    return redirect('admin/manageStudents/'.$id.'/edit')->with('thongbao' ,'Bạn chỉ chọn được file có đuôi  jpg, png, jpeg ');
                }
                $name = $file->getClientOriginalName();
                $Hinh= Str::random(4)."_".$name;
                while (file_exists("image/user".$Hinh)) 
                {
                    $Hinh= Str::random(4)."_".$name;
                }
                $file->move("image/user",$Hinh);
                // unlink("image/user/".$user->image);
                $user->image = $Hinh;
            }  
            
            $user->save();
        return back()->with('thongbao','Cập nhật thành công');
    }

    public function postThem(Request $request)
    {
    
            $this->validate($request,
                [
                    'name' =>'required',
                    'email'=>'required|email',
                    'phone'=>'required',
                    'address'=>'required'
                ],
                [
                    'name.required' =>'Bạn chưa nhập tên sinh viên',
                    'email.email' => 'Bạn chưa nhập Email',
                    'phone' => 'Bạn chưa nhập SĐT',
                    'address'=> 'Bạn chưa nhập địa chỉ',
                ]);
            
                $fullName = $request->name;
                $name = changeTitle($fullName);
                $words = explode("-", $name);
                $lastName = array_pop($words); 
                $lastName = ucfirst( $lastName );
                $acronym = "";
                foreach ($words as $w) {
                
                  switch ($w[0]) {
                    case "a":
                        $w[0] = "A";
                      break;
                      case "b":
                        $w[0] = "B";
                      break;
                      case "c":
                        $w[0] = "C";
                      break;
                      case "d":
                        $w[0] = "D";
                      break;
                      case "e":
                        $w[0] = "E";
                      break;
                      case "f":
                        $w[0] = "F";
                      break;
                      case "g":
                        $w[0] = "G";
                      break;
                      case "h":
                        $w[0] = "H";
                      break;
                      case "i":
                        $w[0] = "I";
                      break;
                      case "j":
                        $w[0] = "J";
                      break;
                      case "k":
                        $w[0] = "K";
                      break;
                      case "l":
                        $w[0] = "L";
                      break;
                      case "m":
                        $w[0] = "M";
                      break;
                      case "n":
                        $w[0] = "N";
                      break;
                      case "o":
                        $w[0] = "O";
                      break;
                      case "p":
                        $w[0] = "P";
                      break;
                      case "q":
                        $w[0] = "Q";
                      break;
                      case "r":
                        $w[0] = "R";
                      break;
                      case "s":
                        $w[0] = "S";
                      break;
                      case "t":
                        $w[0] = "T";
                      break;
                      case "u":
                        $w[0] = "U";
                      break;
                      case "v":
                        $w[0] = "V";
                      break;
                      case "w":
                        $w[0] = "W";
                      break;
                      case "x":
                        $w[0] = "X";
                      break;
                      case "y":
                        $w[0] = "Y";
                      break;
                    default:
                      $w[0] = "Z";
                  }
                  $acronym .= $w[0];
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
            $user->position = 1;
            $user->class_id = $request->namedotthuctap;
            $user->account = $lastName;


            if ($request->hasFile('image')) 
            {   

                $file =$request->file('image');
                $duoi = $file->getClientOriginalExtension();
                if ($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg') {
                    return redirect('admin/manageStudents/create')->with('thongbao' ,'Bạn chỉ chọn được file có đuôi  jpg, png, jpeg ');
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
                $user->image="";
            }
            $user->save();
    
      
            return back()->with('thongbao','Thêm thành công');
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
    public function editUser(User $user, $id)
    {
        $user = User::where('id', $id)->get()->first();
        return view('admin.pages.manageStudents.update', ['user'=>$user]);
    }

}

