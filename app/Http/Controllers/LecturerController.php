<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    public function postThem(Request $request)
    {
        $this->validate($request,
        [
            'name' =>'required',
            'email'=>'required|email',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address'=>'required'
        ],
        [
            'name.required' =>'Bạn chưa nhập tên sinh viên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn nhập sai định dạng email',
            'phone.required' => 'Bạn chưa nhập SĐT',
            'phone.regex' => 'Số điện thoại sai định dạng',
            'address.required'=> 'Bạn chưa nhập địa chỉ',

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
        $file = \File::copy(base_path('public\image\user\avatar.jpg'),base_path('public/image/user/'.$Hinh));


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
