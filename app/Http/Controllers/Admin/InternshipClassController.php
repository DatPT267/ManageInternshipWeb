<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipClass\AddInternshipClassRequest;
use App\Http\Requests\InternshipClass\InternshipClassUpdateRequest;
use App\Internshipclass;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Brian2694\Toastr\Toastr as ToastrToastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Excel;
use App\Exports\UsersExport;

class InternshipClassController extends Controller
{
    private $internshipClass;
    private $user;
    private $excel;

    public function __construct(Internshipclass $internshipClass, User $user, Excel $excel)
    {
        $this->internshipClass = $internshipClass;
        $this->user = $user;
        $this->excel = $excel;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listClass = $this->internshipClass;
        $start_date = Carbon::parse($request->dateStartSearch);
        $end_date = Carbon::parse($request->dateEndSearch);
        if($request->nameSearch){
            $listClass = $listClass->where('name','LIKE',"%" . trim($request->nameSearch) . "%");
        }
        if($request->dateStartSearch){
            $listClass = $listClass->where('start_day', '>=', $start_date);
        }
        if($request->dateEndSearch){
            $listClass = $listClass->where('end_day', '<=', $end_date);
        }
        $listClass = $listClass->orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.internshipClass.list', compact('listClass'));
    }

    public function fetch_data(Request $request, $page){
        if($request->ajax()){
            $listClass = $this->internshipClass->orderBy('id', 'desc')->limit(5)->offset(($page - 1) * 5)->get();
            $index = 0;
            return response()->json(['data' => $listClass, 'index' => $index]);
        }
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
    public function store(AddInternshipClassRequest $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(InternshipClass $internshipClass)
    {
        $students = $this->user->where('class_id', $internshipClass->id)->get();
        return view('admin.pages.internshipClass.show', compact('internshipClass', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InternshipClass $internshipClass)
    {
        return view('admin.pages.internshipClass.update', compact('internshipClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InternshipClassUpdateRequest $request, Internshipclass $internshipClass)
    {
        $internshipClass->name = $request->name;
        $internshipClass->end_day = $request->end_day;
        $internshipClass->note = $request->note;

        $internshipClass->save();

        Toastr::success('Cập nhật thành công', 'Success');

        return redirect()->route('internshipClass.edit', $internshipClass->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InternshipClass $internshipClass)
    {
        $students = User::where('class_id', $internshipClass->id)->get();

        $numberOfStudents = count($students);
        if($numberOfStudents > 0){
            Toastr::warning('Xóa không thành công. Đợt có nhóm hoặc sinh viên đang hoạt động!', 'Warning');
            return redirect()->route('internshipClass.index');
        }

        $internshipClass->delete();
        Toastr::success('Xóa thành công', 'Success');

        return redirect()->route('internshipClass.index');
    }



    public function storeStudentsOfInternshipclass(Request $request, $internshipClass_slug){
        $amount = count($request->input('name_student'));
        $array_student = $request->input('name_student');


        $interclass = Internshipclass::where('name_unsigned', $internshipClass_slug)->get()->first();


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
            $user = new User;
            $user->account = $lastName;
            $user->password = Hash::make("123456");
            $user->name = $array_student[$i];
            $user->position = 1;
            $user->class_id = $interclass->id;
            $user->status = 1;
            $user->save();
        }

        $class_id = $interclass->id;
        Toastr::success('success', 'Thêm sinh viên thành công');
        return redirect()->route('listStudentsOfInternshipclass', ['class_id' => $class_id]);
    }

    public function listStudentsOfInternshipclass($class_id)
    {
      $usermember = User::Where('class_id', $class_id)->get();
      return view('admin/pages/internshipClass/memberclass',['usermember'=> $usermember, 'class_id'=>$class_id] );
    }
    public function classImport(Request $request, $internshipClass_slug)
    {
        $interclass = Internshipclass::where('name_unsigned', $internshipClass_slug)->get()->first();

        $file = $request->file('file')->store('import');
        $class_id = $interclass->id;
        $import = new UsersImport($class_id);
        $import->import($file);

        // if ($import->failures()->isNotEmpty()) {
        //     return back()->withFailures($import->failures());
        // }

        Toastr::success('success', 'Thêm sinh viên thành công');
        return redirect()->route('listStudentsOfInternshipclass', ['class_id' => $class_id]);
    }
    public function classExport($id)
    {

       $class = Internshipclass::find($id);

       if($class == null ){
            Toastr::warning('warning', 'Đợt thực tập không tồn tại');
            return back();

       }

       Toastr::success('success', 'Export Excel thành công');
       $name = $class->name_unsigned;

       $namefile = $name.'.xlsx';
        return $this->excel->download(new UsersExport($id), $namefile);
    }
}
