<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreReplyAndReviewRequest;
use App\Http\Requests\Reviews\StoreReplyReviewRequest;
use App\Http\Requests\Reviews\StoreReviewRequest;
use App\Review;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private $review;
    private $group;
    public function __construct(Review $review, Group $group)
    {
        $this->review = $review;
        $this->group = $group;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOfGroup(Group $group)
    {
        $reviews = $this->review->where('reviewOf',1)->whereGroupId($group->id)->whereParentId(null)->orderBy('id', 'DESC')->get();

        return view('admin.pages.manageEvaluate.group.list', compact('reviews', 'group'));
    }

    public function getListReply(Review $review)
    {
        $replies = $this->review->where('group_id', $review->group_id)->where('parent_id', $review->id)->orderBy('id', 'DESC')->get();

        $data = [];
        $i = 0;
        foreach ($replies as $index => $reply) {
            $data[$index] = [
                    'index' => ++$i,
                    'id' => $reply->id,
                    'name' => $reply->reviewer->name,
                    'content' => $reply->content,
                    'time' => Carbon::parse($reply->created_at)->isoFormat('hh:mm:ss DD/MM/Y'),
                    'reviewer_id' => $reply->reviewer_id
                ];
        }
        return response()->json(['data' =>  $data]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Reviews\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReviewOfGroup(StoreReplyAndReviewRequest $request)
    {
        $content = $request->input('content');
        $group_id = $request->input('group_id');
        $reviewer_id = Auth::id();
        $reviewOf = 1;

        $this->review->create([
            'content' => $content,
            'group_id' => $group_id,
            'reviewer_id' => $reviewer_id,
            'reviewOf' => $reviewOf
        ]);

        $group = $this->group->find($group_id);

        Toastr::success('Success', 'Thêm thành công');
        return redirect()->route('group.list-review', $group);
    }

    public function storeReplyOfGroup(StoreReplyAndReviewRequest $request)
    {
        $content = $request->input('content');
        $group_id = $request->input('group_id');
        $parent_id = $request->input('review_id');
        $reviewer_id = Auth::id();
        $reviewOf = 1;

        $this->review->create([
            'content' => $content,
            'group_id' => $group_id,
            'reviewer_id' => $reviewer_id,
            'reviewOf' => $reviewOf,
            'parent_id' => $parent_id,
        ]);

        $group = $this->group->find($group_id);

        Toastr::success('Success', 'Thêm thành công');
        return redirect()->route('group.list-review', $group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
