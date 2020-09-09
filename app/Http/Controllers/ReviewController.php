<?php

namespace App\Http\Controllers;

use App\Group;
use App\Review;
use App\Task;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function listReviewGroup($id){
        $review = Review::where('group_id', $id)->where('user_id', null)->where('task_id', null)->get();
        $nameGroup = Group::find($id)->first();

        return view('admin.pages.manageEvaluate.group.list', ['review'=>$review, 'nameGroup'=>$nameGroup->name]);
    }
}
