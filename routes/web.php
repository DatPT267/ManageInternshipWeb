<?php

use Illuminate\Http\Request;
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
// Route::get('{id}/checkEmailAreadyExist/{email}', 'Admin\StudentController@checkEmailAreadyExist')->name('checkEmailAreadyExist');

Route::get('login', 'Auth\AuthenticationController@getLogin')->name('login');
Route::post('login', 'Auth\AuthenticationController@postLogin')->name('login');

Route::get('logout', 'Auth\AuthenticationController@getLogout')->name('logout');

Route::get('losspassword', 'Auth\AuthenticationController@getLosspassword')->name('losspassword');
Route::post('losspassword', 'Auth\AuthenticationController@postLosspassword')->name('post.losspassword');

Route::post('sendemail/{email}', 'Auth\AuthenticationController@send')->name('sendMail');


//=======================================ADMIN==================================================================================================
Route::get('/admin',function ()
{
	return view('admin.dashboard');
})->name('admin.home')->middleware('auth', 'can:isAdminANDGVHD');
Route::group( ['prefix' => 'admin', 'middleware' => ['auth', 'can:isAdminANDGVHD'] ], function () {
    //quản lý đợt thực tập
    Route::resource('internshipClass', 'Admin\InternshipClassController');
    Route::get('ajaxFetchDataPagination/page={page}' , 'Admin\InternshipClassController@fetch_data')->name('fetchDataPagination');
    Route::post('internshipClass/students/{nameclass}', 'Admin\InternshipclassController@storeStudentsOfInternshipclass')->name('storeStudentsOfInternshipclass');
    Route::get('internshipClass/list-students/{class_id}', 'Admin\InternshipclassController@listStudentsOfInternshipclass')->name('listStudentsOfInternshipclass');
    Route::post('internshipClass/import/{nameclass}', 'Admin\InternshipClassController@classImport')->name('classImport');
    Route::get('internshipClass/export/{id}', 'Admin\InternshipClassController@classExport')->name('classExport');
    //Quản lý nhóm
    Route::resource('manageGroup', 'Admin\GroupController');
    Route::get('manageGroup/list-task/{id}', 'GroupController@getListTask')->name('listtask');
    Route::get('manageGroup/list-reviews-of-group/{group}', 'Admin\ReviewController@indexOfGroup')->name('group.list-review');
    Route::post('manageGroup/review/store-review', 'Admin\ReviewController@storeReviewOfGroup')->name('post.group.store-group');
    Route::post('manageGroup/review/store-reply', 'Admin\ReviewController@storeReplyOfGroup')->name('post.group.store-reply');
    Route::get('manageGroup/getListReply/{review}', 'Admin\ReviewController@getListReply')->name('group.getListReply');
    Route::put('changeStatusGroup', 'Admin\GroupController@changeStatusGroup')->name('changeStatusGroup');
    Route::group(['prefix' => 'group'], function () {
        Route::get('/{group}/list-member', 'Admin\MemberController@show')->name('group.listMember');
        Route::get('/{group}/add-member', 'Admin\MemberController@create')->name('group.addMember');
        Route::post('/{id}/add-member/{id_member}', 'Admin\MemberController@store')->name('post.add-member');
        Route::get('/{id}/delMember/{id_member}', 'Admin\MemberController@destroy')->name('member.delete');
        Route::get('/{id}/list-review', 'ReviewController@listReviewGroup');
    });

    //quản lý sinh viên
    Route::resource('manageStudents', 'Admin\StudentController')->except('update');
    Route::put('admin/manageStudents/{user}', 'Admin\StudentController@update')->name('manageStudents.update');
    Route::get('checkEmailAreadyExist', 'Admin\StudentController@checkEmailAreadyExist')->name('checkEmailAreadyExist');
    Route::get('checkEmailAreadyExistAddStudent', 'Admin\StudentController@checkEmailAreadyExistAddStudent')->name('checkEmailAreadyExistAddStudent');
    Route::put('manageStudents/sua/{user}', 'UserController@updatestudent')->name('updatestudent');
    Route::post('addStudent', 'UserController@postThem')->name('addstudent');
    Route::get('manageStudents/edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('manageStudents/resetpassword/{user}','Admin\StudentController@resetpassword')->name('resetPasswordStudent');
    Route::put('changeStatusStudent', 'Admin\StudentController@changeStatusStudent')->name('changeStatusStudent');
    Route::get('list-schedule', 'ScheduleController@index')->name('list-schedule.index');
    Route::get('/ajax-view-schedule', 'ScheduleController@ajaxViewListSchedule')->name('ajax.view.schedule');

    Route::get('statistical-checkin-checkout', 'CheckController@index')->name('statistical.checkin-out');
    Route::get('ajax/statistical-checkin-checkout', 'CheckController@ajaxStatistical')->name('ajax.statistical');
    //lịch sử thực tập, lịch đăng ký thực tập của sinh viên (14-15)
    Route::group(['prefix' => 'student'], function () {
        Route::get('/{id}/view-schedule/month={number}', 'Admin\ScheduleController@show')->name('view-schedule');
        Route::get('/ajax/view-schedule/', 'Admin\ScheduleController@ajaxViewSchedule')->name('ajax.schedule');

        Route::get('/{id}/view-history-schedule/month={number}', 'Admin\CheckController@show')->name('view-history-check');
        Route::get('/ajax/{idcheck}/view-history-schedule', 'Admin\CheckController@ajaxTask')->name('ajax.view-task');
    });

    //đánh giá task
    Route::resource('manageTask', 'TaskController');
    Route::get('manageTask/list-reviews-of-task/{id}', 'ReviewController@getListReviewOfTask')->name('list-review');
    Route::post('manageTask/list-reviews-of-task/{id}/create', 'ReviewController@postReviewOfTask')->name('post-review');
    Route::get('manageGroup/list-evaluate/{id}', 'GroupController@getListEvaluate');
    Route::post('manageGroup/sua/{id}', 'GroupController@postSua')->name('updategroup');
    Route::post('addgroup', 'GroupController@postThem')->name('addgroup');

    Route::get('manageTask/add/{id}', 'TaskController@create')->name('addTask');
    Route::post('manageTask/add/{id}', 'TaskController@addTask')->name('addTask');
    Route::post('manageTask/delete/{id}', 'TaskController@delete')->name('deleteTask');
    Route::post('manageTask/update/{id}', 'TaskController@update')->name('updateTask');

    Route::get('assign/{id_task}/{id_member}', 'TaskController@assign')->name('assign');


    //     Route::get('/show-history-register-schedule', 'ScheduleController`@index');
    // });



    //================action feedback================
    Route::get('manageGroup/review/{id_review}/list-feedback', 'FeedbackController@showlist')->name('list.feedback');
    Route::post('manageGroup/review/{id_review}/list-feedback/review/create', 'FeedbackController@createFeedback')->name('create-feedback-review');

    Route::get('manageTask/review/{id_review}/list-feedback', 'FeedbackController@getListFeedBackOfTask')->name('list-feedbackOfTask');
    Route::post('manageTask/review/{id_review}/list-feedback/feedback/create', 'FeedbackController@createFeedbackOfFeedback')->name('create-feedback');

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('detail-feedback/{id}', 'FeedbackController@getAjaxFeedback')->name('ajax-feedback');
    });
    Route::resource('manageLecturer', 'Admin\LecturerController');
    // Route::post('addLecturer', 'Admin\LecturerController@store')->name('addlecturer');
    // Route::get('manageLecturer/edit/{id}', 'LecturerController@editLecturer')->name('editLecturer');

    //Quản lý task

    //Quản lý lịch thực tập
    Route::get('manageSchedule', 'ScheduleController@index')->name('manageSchedule.index');
    Route::get('manageSchedule/checkin-out', 'ScheduleController@getCheckinOut')->name('manageSchedule.checkin-out');
});
//=======================================ADMIN==================================================================================================










//=======================================PROFILE==================================================================================================
Route::resource('user', 'User\UserController')->middleware('auth');
Route::put('user/{user}/changepassword', 'User\UserController@changePasswordUser')->middleware('auth')->name('changepassword');
//=======================================PROFILE==================================================================================================










//=======================================USER==================================================================================================
Route::get('/',function ()
{
	return view('user.dashboard');
})->name('user.home')->middleware('auth', 'can:isUser');

Route::group( ['prefix' => 'user', 'middleware' => ['auth', 'can:isUser'] ], function () {

    Route::get('{id}/list-group', 'User\GroupController@index')->name('user.listGroup');
    Route::get('{id}/group/{id_group}', 'StudentController@infoGroupOfStudent')->name('user.group');
    Route::get('{id}/show', 'MemberController@show')->name('info.member');
    Route::get('{id}/group/{id_group}/list-task', 'User\GroupController@getListTaskUser')->name('view-list-task');
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
    Route::get('{id}/list-review-user', 'ReviewController@getListReviewOfUser')->name('list-review-of-user');
    Route::post('{id}/list-review-user/feedback/create', 'FeedbackController@postCreateFeedback')->name('post-create-feedback');
    Route::get('ajax/detail-review-user', 'FeedbackController@ajaxDetailReview')->name('ajax-detail-review');

    //review
    Route::get('{id}/list-review-project', 'ReviewController@getListReviewOfProject')->name('list-review-of-project');
});

//=======================================USER==================================================================================================
