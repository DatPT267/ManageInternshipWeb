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

    //Quản lý nhóm
    Route::resource('manageGroup', 'GroupController');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask');
    Route::get('manageGroup/list-evaluate/{id}', 'GroupController@getListEvaluate');

    //Quản lý sinh viên
    // Route::group(['prefix' => 'manageStudent'], function () {
    //     Route::get('/', function ($id) {

    //     });
    // });


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


//cập nhật thông tin user và update mật khẩu
Route::resource('user', 'UserController');

//checkin - checkout
Route::get('user/{id}/check-in', 'CheckController@checkin');
Route::post('user/{id}/check-in', 'CheckController@postCheckin')->name('checkin.post');
Route::get('user/{id}/check-out', 'CheckController@checkout');
Route::post('user/{id}/check-out', 'CheckController@postCheckout')->name('checkout.post');
// Checkin-out
Route::get('/user/{id}/reg-schedule', 'ScheduleController@getRegSchedule');
Route::get('/user/{id}/test', 'ScheduleController@test');
Route::post('/user/{id}/reg-schedule', 'ScheduleController@postRegSchedule')->name('reg.schedule');
