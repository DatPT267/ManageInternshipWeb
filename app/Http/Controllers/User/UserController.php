<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordUserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
    public function edit(User $user)
    {
        $this->authorize('isAuthor', $user->id);

        return view('profiles.edit', ['user'=>$user]);
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
        $this->authorize('isAuthor', $id);

        $user = $this->user->findOrFail($id);
        $nameImage = NULL;
        if($request->hasFile('image')){

            $nameImage = $this->uploadImage($request);

            if($user->image != ""){
                unlink("image/user/".$user->image);
            }
        } else{
            $nameImage = $user->image;
        }

        $checkSaveSuccess = $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'image' => $nameImage
        ]);

        if($checkSaveSuccess){
            Toastr::success('Bạn đã cập nhật thông tin thành công', 'success');
            return redirect()->route('user.edit', $user->id);
        } else{
            Toastr::warning('Cập nhật lỗi! Vui lòng thử lại', 'warning');
            return redirect()->route('user.edit', $user->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changePasswordUser(ChangePasswordUserRequest $request, User $user){
        $this->authorize('isAuthor', $user->id);

        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $confirm_newPassword = $request->input('confirm_newPassword');

        if(Hash::check($oldPassword, $user->password)){
            $user->update(['password' => Hash::make($newPassword)]);

            Toastr::success('Cập nhật mật khẩu thành công', 'success');
            return redirect()->route('user.edit', $user->id);
        } else{

            Toastr::warning('Password cũ không đúng!', 'warning');
            return redirect()->route('user.edit', $user->id);
        }

    }

    public function uploadImage($request){
        $nameImage = Str::random(3).'_'.Carbon::now()->timestamp."_".$request->file('image')->getClientOriginalName();
        $request->file('image')->move('image/user/', $nameImage);

        return $nameImage;
    }
}
