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

    //Quản lý giảng viên
    // Route::resource('manageLecturers', 'UserController');

    //Quản lý task
    Route::resource('manageTask', 'TaskController');

    //Quản lý lịch thực tập
    Route::get('manageSchedule', 'ScheduleController@index')->name('manageSchedule.index');
    Route::get('manageSchedule/checkin-out', 'ScheduleController@getCheckinOut')->name('manageSchedule.checkin-out');

    //Quản lý đánh giá


});










//User
Route::get('trangchu',function ()
{
	return view('user/pages/trangchu');
});
Route::get('dangnhap',function ()
{
	return view('admin/login');
});
