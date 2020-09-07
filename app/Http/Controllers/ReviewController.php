<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Review;
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
        // dd($request->input('content'));
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
}
