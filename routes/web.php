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
    Route::resource('internshipClass', 'InternshipclassController');
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
