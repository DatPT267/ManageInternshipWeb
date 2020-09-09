<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function getListReviewOfUser($id){
        $reviews = Review::where('user_id', $id)->where('group_id', null)->where('task_id', null)->orderByDESC('id')->get();
        return view('user.pages.review.list-review', ['reviews' => $reviews]);
    }


}
