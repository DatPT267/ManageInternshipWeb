<?php

use Carbon\Carbon;
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

Route::get('admin/login', 'AuthenticationController@getLogin')->name('login');
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
    Route::post('them1', 'internshipclassController@postThem')->name('addClass');
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
    // Route::group(['prefix' => 'manageStudent'], function () {
    //     Route::get('/show-history-register-schedule', 'ScheduleController@index');
    // });
    Route::resource('manageStudents', 'UserController');
    Route::post('manageStudents/sua/{id}', 'UserController@postSua')->name('updatestudent');
    Route::post('addStudent', 'UserController@postThem')->name('addstudent');
    Route::get('manageStudents/edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('manageStudents/resetpassword/{id}','UserController@resetpassword')->name('resetpass');

    //Quản lý group: đã xong: add-member, list-review, list-member, del-member | ĐỢI REVIEW
    Route::group(['prefix' => 'group'], function () {
        Route::get('/{id}/list-member', 'MemberController@listMemberGroup')->name('group.listMember');
        Route::get('/{id}/add-member', 'MemberController@addMember')->name('group.addMember');
        Route::post('/{id}/add-member/{id_member}', 'MemberController@storeMember')->name('post.add-member');
        // Route::get('/{id}/add-member/{id_member}', 'MemberController@storeMember');
        Route::get('/{id}/list-review', 'ReviewController@listReviewGroup');
        // Route::get('/{id}/delMember/{id_member}', 'MemberController@deleteMemberGroup')->name('member.delete');
        Route::get('/{id}/delMember/{id_member}', 'MemberController@deleteMemberGroup')->name('member.delete');
    });

});

    //Quản lý task
    Route::resource('manageTask', 'TaskController');

    //Quản lý lịch thực tập
    Route::get('manageSchedule', 'ScheduleController@index')->name('manageSchedule.index');
    Route::get('manageSchedule/checkin-out', 'ScheduleController@getCheckinOut')->name('manageSchedule.checkin-out');



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

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    //checkin - checkout
    Route::get('{id}/check-in', 'CheckController@checkin');
    Route::post('{id}/check-in', 'CheckController@postCheckin')->name('checkin.post');
    Route::get('{id}/check-out', 'CheckController@checkout');
    Route::post('{id}/check-out', 'CheckController@postCheckout')->name('checkout.post');
    // register Checkin-out
    Route::get('{id}/reg-schedule', 'ScheduleController@getRegSchedule');
    Route::post('{id}/reg-schedule', 'ScheduleController@postRegSchedule')->name('reg.schedule');
    //history checkin-out
    Route::get('{id}/history-schedule', 'CheckController@hisSchedule');
    Route::get('ajax/{id}/history-schedule', 'CheckController@ajaxHisSchedule')->name('ajax.His-schedule');
});
