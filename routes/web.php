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


Route::get('/',function ()
{
	return view('admin.layouts.index');
});
// Route::group(['prefix' => 'admin'], function () {
//     Route::get('internshipClass', 'internshipclassController');
// });










//User
Route::get('trangchu',function ()
{
	return view('user/pages/trangchu');
});
Route::get('dangnhap',function ()
{
	return view('admin/login');
});

