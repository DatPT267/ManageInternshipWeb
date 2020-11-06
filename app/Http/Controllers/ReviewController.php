<?php

namespace App\Http\Controllers;

use App\Group;
use App\Review;
use App\Task;
use App\Feedback;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function listReviewGroup($id){
        $review = Review::where('group_id', $id)->where('user_id', null)->where('task_id', null)->get();
        $nameGroup = Group::find($id)->first();

        return view('admin.pages.manageEvaluate.group.list', ['review'=>$review, 'nameGroup'=>$nameGroup->name]);
    }
    public function getListReviewOfGroup($id_group){
        $reviews = Review::where('group_id', $id_group)
                        ->where('task_id', null)
                        ->where('user_id', null)
                        ->orderByDESC('id')
                        ->get();
        $name_group = Group::find($id_group)->first();

        // dd($reviews);
        return view('admin.pages.manageGroup.list-reviewOfGroup', ['reviews' => $reviews, 'id_group' => $id_group, 'name_group' => $name_group->name]);
    }

    public function postReviewOfGroup($id, Request $request){
        $this->validate($request, [
            'content' => 'required'
        ], [
            'content.required' => 'Nội dung review không để trống!',
        ]);
        $memberID = Member::where('user_id', Auth::id())->first();
        $review = new Review();
        $review->content = $request->input('content');
        $review->reviewer_id = $memberID->id;
        $review->group_id = $id;

        $review->save();
        return back()->with('success', 'Thêm review thành công');
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
        $reviews = Review::where('task_id', $id_task)
                        ->where('group_id', null)
                        ->where('user_id', null)
                        ->orderByDESC('id')
                        ->get();
        $name_task = '';
        foreach ($reviews as $key => $review) {
            $name_task = $review->task->name;
        }
        return view('admin.pages.manageTasks.list-reviews', ['reviews' => $reviews, 'id_task' => $id_task, 'name_task' => $name_task]);
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

    public function getListReviewOfUser($id){
        $this->authorize('isAuthor', $id);
        $reviews = Review::where('user_id', $id)->where('group_id', null)->where('task_id', null)->orderByDESC('id')->get();
        return view('user.pages.review.list-review', ['reviews' => $reviews]);
    }

    //==============================REVIEW PROJECT======================================
    public function getListReviewOfProject($id)
    {
        $this->authorize('isAuthor', Auth::id());
        $groupName = Group::find($id);
        $reviews = Review::where('user_id', null)->where('group_id', $id)->where('task_id', null)->orderByDESC('id')->get();
        // dd($reviews);
        return view('user.pages.group.review.list-review', ['reviews' => $reviews, 'groupName' => $groupName->name]);
    }
}
