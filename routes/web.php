<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//ADMIN and GVHD

Route::get('admin/login', 'AuthenticationController@getLogin');
Route::post('admin/login', 'AuthenticationController@postLogin');

Route::get('admin/logout', 'AuthenticationController@getLogout');

Route::get('admin/losspassword', 'AuthenticationController@getLosspassword')->name('losspassword');
Route::post('admin/losspassword', 'AuthenticationController@postLosspassword');

Route::post('admin/sendemail/{email}', 'SendEmailController@send');



Route::get('/admin',function ()
{
	return view('admin.layout.index');
});
Route::group(['prefix' => 'admin'], function () {
    //quản lý đợt thực tập
    Route::resource('internshipClass', 'internshipclassController');
    Route::post('them', 'internshipclassController@postThem')->name('addclass');
    Route::post('internshipClass/sua/{id}', 'internshipclassController@postSua')->name('updateclass');
    Route::post('internshipClass/member/{nameclass}/{amount}', 'internshipclassController@postMember')->name('member');
    Route::get('internshipClass/list-member/{class_id}', 'internshipclassController@getList')->name('list');


    //Quản lý nhóm
    Route::resource('manageGroup', 'GroupController');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask')->name('listtask');;
    Route::get('manageGroup/list-evaluate/{id}', 'GroupController@getListEvaluate');
    Route::post('manageGroup/sua/{id}', 'GroupController@postSua')->name('updategroup');
    Route::post('them', 'GroupController@postThem')->name('addgroup');

    //Quản lý sinh viên
    Route::resource('manageStudents', 'UserController');
    Route::post('manageStudents/sua/{id}', 'UserController@postSua')->name('updatestudent');
    Route::post('them', 'UserController@postThem')->name('addstudent');
    Route::get('manageStudents/edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('manageStudents/resetpassword/{id}','UserController@resetpassword')->name('resetpass');


});

    //Quản lý task
    Route::resource('manageTask', 'TaskController');

    //Quản lý lịch thực tập
    Route::get('manageSchedule', 'ScheduleController@index')->name('manageSchedule.index');
    Route::get('manageSchedule/checkin-out', 'ScheduleController@getCheckinOut')->name('manageSchedule.checkin-out');

    //Quản lý đánh giá



//User









//User

Route::get('/updateInformation', function () {
    return view('user.pages.personalInformation.updateInformation');
});
Route::get('/',function ()
{
	return view('user/pages/trangchu');
})->name('home');
Route::post('login', 'UserController@postLogin');
Route::get('logout', 'UserController@getLogout')->name('logout');
Route::post('losspassword', 'UserController@postLosspassword')->name('losspassword');



Route::get('/user/{id}/edit', 'UserController@edit');
Route::post('/user/{id}', 'UserController@update')->name('user.update');

Route::post('/users/{id}/edit/changepassword', 'UserController@changepassword')->name('changepassword');



//cập nhật thông tin user và update mật khẩu



//cập nhật thông tin user và update mật khẩu
Route::resource('user', 'UserController');

