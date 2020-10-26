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

Route::get('user/login', 'AuthenticationController@getLogin')->name('login');
Route::post('user/login', 'AuthenticationController@postLogin')->name('login');

Route::get('user/logout', 'AuthenticationController@getLogout')->name('logout');

Route::get('user/losspassword', 'AuthenticationController@getLosspassword')->name('losspassword');
Route::post('user/losspassword', 'AuthenticationController@postLosspassword');

Route::post('user/sendemail/{email}', 'SendEmailController@send');


//=======================================ADMIN==================================================================================================
Route::get('/admin',function ()
{
	return view('admin.dashboard');
})->name('admin.home')->middleware('auth', 'can:isAdmin');
Route::group( ['prefix' => 'admin', 'middleware' => ['auth', 'can:isAdmin'] ], function () {
    //quản lý đợt thực tập
    Route::resource('internshipClass', 'internshipclassController');
    Route::post('them1', 'internshipclassController@postThem')->name('addClass');
    Route::post('internshipClass/sua/{id}', 'internshipclassController@postSua')->name('updateclass');
    Route::post('internshipClass/member/{nameclass} ', 'internshipclassController@postMember')->name('member');
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
    Route::post('addgroup', 'GroupController@postThem')->name('addgroup');

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
    //================action feedback================
    Route::get('manageGroup/review/{id_review}/list-feedback', 'FeedbackController@showlist')->name('list.feedback');
    Route::post('manageGroup/review/{id_review}/list-feedback/review/create', 'FeedbackController@createFeedback')->name('create-feedback-review');

    Route::get('manageTask/review/{id_review}/list-feedback', 'FeedbackController@getListFeedBackOfTask')->name('list-feedbackOfTask');
    Route::post('manageTask/review/{id_review}/list-feedback/feedback/create', 'FeedbackController@createFeedbackOfFeedback')->name('create-feedback');

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('detail-feedback/{id}', 'FeedbackController@getAjaxFeedback')->name('ajax-feedback');
    });
    Route::resource('manageLecturer', 'LecturerController');
    Route::post('addLecturer', 'LecturerController@postThem')->name('addlecturer');
    Route::get('manageLecturer/edit/{id}', 'LecturerController@editLecturer')->name('editLecturer');

    //Quản lý task

    //Quản lý lịch thực tập
    Route::get('manageSchedule', 'ScheduleController@index')->name('manageSchedule.index');
    Route::get('manageSchedule/checkin-out', 'ScheduleController@getCheckinOut')->name('manageSchedule.checkin-out');
});
//=======================================ADMIN==================================================================================================

//=======================================PROFILE==================================================================================================
Route::resource('user', 'UserController')->middleware('auth');
Route::post('user/{id}/edit/changepassword', 'UserController@changepassword')->middleware('auth')->name('changepassword');
//=======================================PROFILE==================================================================================================

//=======================================USER==================================================================================================
Route::get('/',function ()
{
	return view('user.dashboard');
})->name('user.home')->middleware('auth', 'can:isUser');

Route::group( ['prefix' => 'user', 'middleware' => ['auth', 'can:isUser'] ], function () {

    Route::get('{id}/list-group', 'GroupController@listGroup')->name('user.listGroup');
    Route::get('{id}/group/{id_group}', 'StudentController@infoGroupOfStudent')->name('user.group');
    Route::get('{id}/show', 'MemberController@show')->name('info.member');
    Route::get('{id}/group/{id_group}/list-task', 'GroupController@getListTaskUser')->name('view-list-task');
    //đổi mật khẩu

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

//=======================================USER==================================================================================================
