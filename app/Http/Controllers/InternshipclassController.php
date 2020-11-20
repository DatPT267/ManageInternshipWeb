<?php

namespace App\Http\Controllers;

use App\Group;
use App\Internshipclass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Controllers\changeTitle;
use App\Http\Middleware\checkIsAdmin;
use App\Http\Requests\InternshipClass\AddInternshipClassRequest;
use Brian2694\Toastr\Facades\Toastr;

class InternshipclassController extends Controller
{ 
    public function __construct()
    {
        // $this->middleware(checkIsAdmin::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listClass = Internshipclass::orderBy('id', 'desc')->paginate(10);
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
        $intership = Internshipclass::find($id);
        $user = User::where('class_id', $intership->id)->get();
        $count = count($user);
        if($count > 0){
            Toastr::warning('Xóa không thành công. Đợt có nhóm hoặc sinh viên đang hoạt động!', 'Warning');
            return redirect()->route('internshipClass.index');
        }
        $intership->delete();
        Toastr::success('Xóa thành công', 'Success');
        return redirect()->route('internshipClass.index');
    }


    public function postThem(AddInternshipClassRequest $request)
    {

        $internshipclass = new Internshipclass;
        $internshipclass->name = $request->name;
        $internshipclass->start_day = $request->start_day;
        $internshipclass->end_day = $request->end_day;
        $internshipclass->note = $request->note;
        $name_unsigned = changeTitle($request->name);
        $internshipclass->name_unsigned = $name_unsigned;
        $internshipclass->save();

        Toastr::success('Thêm thành công', 'Success');
        return view('admin/pages/internshipClass/memberinternshipclass', compact('name_unsigned'));
    }

    public function postSua(Request $request, $id)
    {

        $this->validate($request,
            [

                'name' =>'required',
                'start_day'=>'required|date|before:end_day',
                'end_day'=>'required|date',

            ],
            [
                'name.required' =>'Bạn chưa nhập tên đợt thực tập',
                'start_day.required' => 'Bạn chưa nhập ngày bắt đầu',
                'end_day.required' => 'Bạn chưa nhập ngày kết thúc',
                'start_day.before' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu'

            ]);


        $internshipclass = Internshipclass::find($id);
        $internshipclass->name = $request->name;
        $internshipclass->end_day = $request->end_day;
        $internshipclass->note = $request->note;


        $internshipclass->save();
        Toastr::success('Cập nhật thành công', 'Success');
        return back();
    }

    public function postMember(Request $request, $nameclass){
        $amount = count($request->input('name_student'));
        $array_student = $request->input('name_student');


        $interclass = Internshipclass::where('name_unsigned', $nameclass)->get()->first();


        for($i =0 ; $i< $amount; $i++){

            if($array_student[$i] == null){
              continue;
            }
            $name = changeTitle($array_student[$i]);
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
            $user = new User;
            $user->account = $lastName;
            $user->password = bcrypt("123456789");
            $user->name = $array_student[$i];
            $user->position = 1;
            $user->class_id = $interclass->id;
            $user->status = 1;
            $user->save();
        }

        $class_id = $interclass->id;
        return redirect()->route('list', ['class_id' => $class_id]);
    }
    public function getList($class_id)
    {
      $usermember = User::Where('class_id', $class_id)->get();
      return view('admin/pages/internshipClass/memberclass',['usermember'=> $usermember] );
    }

  public function getshow($id){

    $show = User::where('class_id', $id)->get();
    $sinhvien =  Internshipclass::where('id', $id)->firstOrFail();

    return view('admin.pages.internshipClass.show',['show'=>$show, 'sinhvien'=>$sinhvien]);
  }



}
