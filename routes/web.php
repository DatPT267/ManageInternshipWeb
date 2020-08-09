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


//ADMIN

Route::get('admin/confirmemail', function () {
    return view('confirmemail');
});
Route::get('admin/losspassword', function () {
    return view('losspassword');
})->name('losspassword');


Route::get('admin/login', 'AuthenticationController@getLogin');
Route::post('admin/login', 'AuthenticationController@postLogin');