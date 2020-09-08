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
    Route::post('manageGroup/sua/{id}', 'GroupController@postSua')->name('updategroup');
    Route::post('them', 'GroupController@postThem')->name('addgroup');

    Route::get('manageGroup/list-review-of-group/{id}', 'ReviewController@getListReviewOfGroup')->name('group.list-review');
    Route::post('manageGroup/list-review-of-group/{id}/create', 'ReviewController@postReviewOfGroup')->name('post.group.list-review');


    Route::resource('manageTask', 'TaskController');
    Route::get('manageTask/list-reviews-of-task/{id}', 'ReviewController@getListReviewOfTask')->name('list-review');
    Route::post('manageTask/list-reviews-of-task/{id}/create', 'ReviewController@postReviewOfTask')->name('post-review');
    //================action feedback================
    Route::get('manageGroup/review/{id_review}/list-feedback', 'FeedbackController@showlist')->name('list.feedback');
    Route::post('manageGroup/review/{id_review}/list-feedback/review/create', 'FeedbackController@createFeedback')->name('create-feedback-review');
    Route::post('review/{id_review}/list-feedback/feedback/create', 'FeedbackController@createFeedbackOfFeedback')->name('create-feedback');
    Route::get('manageTask/review/{id_review}/list-feedback', 'FeedbackController@getListFeedBackOfTask')->name('list-feedbackOfTask');

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('detail-feedback/{id}', 'FeedbackController@getAjaxFeedback')->name('ajax-feedback');
    });
});

    //Quản lý task

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

