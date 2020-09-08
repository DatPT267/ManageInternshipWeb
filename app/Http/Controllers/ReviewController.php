<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Review;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function getListReviewOfGroup($id_group){
        $reviews = Review::where('group_id', $id_group)->where('task_id', null)->orderByDESC('id')->get();
        return view('admin.pages.manageGroup.list-reviewOfGroup', ['reviews' => $reviews, 'id_group' => $id_group]);
    }

    public function postReviewOfGroup($id, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Nội dung review không để trống!',
        ]);

        $review = new Review();
        $review->content = $request->input('content');
        $review->reviewer_id = Auth::id();
        $review->group_id = $id;

        $review->save();
        return back()->with('success', 'Thêm reivew thành công');
    }

    public function getAjaxReview($id){

        $feedbacks = Feedback::where('review_id', $id)->get();
        $data = [];
        foreach ($feedbacks as $key => $feedback) {
            $data[$key] = [
                'id' => $feedback->id,
                'index' => $key,
                'name' => $feedback->user->name,
                'content' => $feedback->content,
                'time' => Carbon::parse($feedback->time)->isoFormat('H:m:s D/M/Y'),
                'feedback' => $feedback->feedback_id
            ];
        }
        return response()->json(['data' => $data]);
    }

    //=============================TASK=====================
    public function getListReviewOfTask($id_task){
        $reviews = Review::where('task_id', $id_task)->where('group_id', null)->orderByDESC('id')->get();
        return view('admin.pages.manageTasks.list-reviews', ['reviews' => $reviews, 'id_task' => $id_task]);
    }

    public function postReviewOfTask($id_task, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Nội dung review không được để trống'
        ]);

        $review = new Review();
        $review->content = $request->input('content');
        $review->task_id = $id_task;
        $review->reviewer_id = Auth::id();
        $review->save();

        return redirect('admin/manageTask/list-reviews-of-task/'.$id_task)->with('success', 'Thêm thành công');

    }
}
