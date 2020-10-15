<?php

use App\Assign;
use App\Task;
use App\User;
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

Route::get('admin/login', 'AuthenticationController@getLogin')->name('login.admin');
Route::post('admin/login', 'AuthenticationController@postLogin');

Route::get('admin/logout', 'AuthenticationController@getLogout');

Route::get('admin/losspassword', 'AuthenticationController@getLosspassword')->name('losspassword');
Route::post('admin/losspassword', 'AuthenticationController@postLosspassword');

Route::post('admin/sendemail/{email}', 'SendEmailController@send');



Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/',function ()
    {
        return view('admin.layout.index');
    })->name('home.admin');
    //quản lý đợt thực tập
    Route::resource('internshipClass', 'internshipclassController');
    Route::post('them1', 'internshipclassController@postThem')->name('addClass');
    Route::post('internshipClass/sua/{id}', 'internshipclassController@postSua')->name('updateclass');
    Route::post('internshipClass/member/{nameclass}/{amount}', 'internshipclassController@postMember')->name('member');
    Route::get('internshipClass/list-member/{class_id}', 'internshipclassController@getList')->name('list');


    //Quản lý nhóm
    Route::resource('manageGroup', 'GroupController');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask')->name('listtask');;
    Route::post('manageGroup/sua/{id}', 'GroupController@postSua')->name('updategroup');
    Route::post('them', 'GroupController@postThem')->name('addgroup');

    //đánh giá group
    Route::get('manageGroup/list-reviews-of-group/{id}', 'ReviewController@getListReviewOfGroup')->name('group.list-review');
    Route::post('manageGroup/list-reviews-of-group/{id}/create', 'ReviewController@postReviewOfGroup')->name('post.group.list-review');

    //đánh giá task
    Route::resource('manageTask', 'TaskController');
    Route::get('manageTask/list-reviews-of-task/{id}', 'ReviewController@getListReviewOfTask')->name('list-review');
    Route::post('manageTask/list-reviews-of-task/{id}/create', 'ReviewController@postReviewOfTask')->name('post-review');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask')->name('listtask');
    Route::get('manageGroup/list-evaluate/{id}', 'GroupController@getListEvaluate');
    Route::post('manageGroup/sua/{id}', 'GroupController@postSua')->name('updategroup');
    Route::post('them', 'GroupController@postThem')->name('addgroup');

    //Quản lý sinh viên
    Route::resource('manageStudents', 'UserController');
    Route::post('manageStudents/sua/{id}', 'UserController@postSua')->name('updatestudent');
    Route::post('addStudent', 'UserController@postThem')->name('addstudent');
    Route::get('manageStudents/edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('manageStudents/resetpassword/{id}','UserController@resetpassword')->name('resetpass');

    //================action feedback================
    Route::get('manageGroup/review/{id_review}/list-feedback', 'FeedbackController@showlist')->name('list.feedback');
    Route::post('manageGroup/review/{id_review}/list-feedback/review/create', 'FeedbackController@createFeedback')->name('create-feedback-review');

    Route::get('manageTask/review/{id_review}/list-feedback', 'FeedbackController@getListFeedBackOfTask')->name('list-feedbackOfTask');
    Route::post('manageTask/review/{id_review}/list-feedback/feedback/create', 'FeedbackController@createFeedbackOfFeedback')->name('create-feedback');

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









//=======================================USER=================================================
Route::post('login', 'UserController@postLogin');
Route::get('logout', 'UserController@getLogout')->name('logout');
Route::post('losspassword', 'UserController@postLosspassword')->name('losspassword');




Route::get('/',function ()
{
	return view('user.pages.index');
})->name('home')->middleware('auth', 'can:isUser');
Route::resource('user', 'UserController')->middleware('auth');
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'can:isUser']], function () {

    Route::get('{id}/list-group', 'GroupController@listGroup')->name('user.listGroup');
    Route::get('{id}/group/{id_group}', 'StudentController@infoGroupOfStudent')->name('user.group');
    Route::get('{id}/show', 'MemberController@show')->name('info.member');
    Route::get('{id}/group/{id_group}/list-task', 'GroupController@getListTask')->name('view-list-task');
    //đổi mật khẩu
    Route::post('{id}/edit/changepassword', 'UserController@changepassword')->name('changepassword');
    //checkin - checkout
    Route::get('{id}/check-in', 'CheckController@checkin')->name('checkin');
    Route::post('{id}/check-in', 'CheckController@postCheckin')->name('checkin.post');
    Route::get('{id}/check-out', 'CheckController@checkout')->name('checkout');
    Route::post('{id}/check-out', 'CheckController@postCheckout')->name('checkout.post');
    // register Checkin-out
    Route::get('{id}/reg-schedule', 'ScheduleController@getRegSchedule')->name('user.regSchedule');
    Route::post('{id}/reg-schedule', 'ScheduleController@postRegSchedule')->name('reg.schedule');
    //history checkin-out
    Route::get('{id}/history-schedule', 'CheckController@hisSchedule')->name('user.hisSchedule');
    Route::get('ajax/{id}/history-schedule', 'CheckController@ajaxHisSchedule')->name('ajax.His-schedule');
    //đánh giá
    Route::get('{id}/list-review', 'ReviewController@getListReviewOfUser')->name('list-review-of-user');
    Route::post('{id}/list-review/feedback/create', 'FeedbackController@postCreateFeedback')->name('post-create-feedback');
    Route::get('ajax/detail-review', 'FeedbackController@ajaxDetailReview')->name('ajax-detail-review');
});

//=======================================USER=================================================
