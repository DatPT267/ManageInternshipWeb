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

    //Quản lý nhóm
    Route::resource('manageGroup', 'GroupController');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask');
    Route::get('manageGroup/list-evaluate/{id}', 'GroupController@getListEvaluate');

    //Quản lý sinh viên
    // Route::group(['prefix' => 'manageStudent'], function () {
    //     Route::get('/show-history-register-schedule', 'ScheduleController@index');
    // });

    //Quản lý group: đã xong: add-member, list-review, list-member, del-member | ĐỢI REVIEW
    Route::group(['prefix' => 'group'], function () {
        Route::get('/{id}/add-member', 'MemberController@addMember');
        Route::get('/{id}/add-member/{id_member}', 'MemberController@storeMember');
        Route::get('/{id}/list-review', 'ReviewController@listReviewGroup');
        Route::get('/{id}/list-member', 'MemberController@listMemberGroup');
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


//cập nhật thông tin user và update mật khẩu
Route::resource('user', 'UserController');
