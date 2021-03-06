<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class FeedbackController extends Controller
{
    public function showlist($id_review){
        $review = Review::find($id_review);
        $feedbacks = Feedback::where('review_id', $id_review)->where('feedback_id', null)->orderByDESC('id')->get();
        return view('admin.pages.manageGroup.feedbacks.list-feedbackOfReview', [
            'feedbacks' => $feedbacks,
            'review' => $review,
            'id_review' => $id_review
        ]);
    }

    public function createFeedback($id, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Content không được để trống'
        ]);

        $feedback = new Feedback();
        $feedback->content = $request->input('content');
        $feedback->time = Carbon::now('asia/Ho_Chi_Minh')->isoFormat('Y-M-D H:m:s');
        $feedback->review_id = $id;
        $feedback->user_id = Auth::id();
        $feedback->save();

        return back()->with('success', 'Thêm thành công');
    }

    public function getAjaxFeedback($id){
        $feedbacks = Feedback::where('feedback_id', $id)->orderByDESC('id')->get();
        $data = [];
        foreach ($feedbacks as $key => $feedback) {
            $data[$key] = [
                'id' => $feedback->id,
                'user_id' => $feedback->user_id,
                'index' => $key,
                'name' => $feedback->user->name,
                'content' => $feedback->content,
                'time' => Carbon::parse($feedback->time)->isoFormat('HH:mm:ss D/M/Y')
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function createFeedbackOfFeedback($id, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Content không được để trống'
        ]);

        $feedback = new Feedback();
        $feedback->content = $request->input('content');
        $feedback->time = Carbon::now('asia/Ho_Chi_Minh')->isoFormat('Y-M-D H:m:s');
        $feedback->review_id = $id;
        $feedback->feedback_id = $request->input('id_feedback');
        $feedback->user_id = Auth::id();
        $feedback->save();
        return back()->with('success', 'Thêm thành công');
    }

    //===========================Task==============================
    public function getListFeedBackOfTask($id_review){
        $review = Review::find($id_review);
        $feedbacks = Feedback::where('review_id', $id_review)->where('feedback_id', null)->orderByDESC('id')->get();
        return view('admin.pages.manageTasks.feedbacks.list-feedbackOfTask', [
            'feedbacks' => $feedbacks,
            'review' => $review,
            'id_review' => $id_review
        ]);
    }

    public function ajaxDetailReview(Request $request){
        $id_review = $request->input('id');
        $feedbacks = Feedback::where('review_id', $id_review)->orderByDESC('id')->get();
        $data = [];
        foreach ($feedbacks as $key => $feedback) {
            $data[$key] = [
                'index' => $key+1,
                'id' => $feedback->user->id,
                'name' => $feedback->user->name,
                'content' => $feedback->content,
                'time' => Carbon::parse($feedback->time)->isoFormat('HH:mm:ss D/M/Y')
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function postCreateFeedback($id, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Nội dung feedback không được để trống'
        ]);

        $feedback = new Feedback();
        $feedback->content = $request->input('content');
        $feedback->time = Carbon::now('asia/Ho_Chi_Minh')->isoFormat('Y-M-D HH:mm:ss');
        $feedback->review_id = $request->input('id_review');
        $feedback->user_id = Auth::id();
        $feedback->save();
        Toastr::success('Bạn đăng feedback thành công!', 'success');
        return back();
    }
}
