<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json(new CommentCollection($comments));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' =>  'required|string|max:255',
            'rating' =>  'required|integer|min:1|max:5',
            'plan_id' =>  'required|integer|max:255',
            'user_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan = Plan::find($request->plan_id);
        if (is_null($plan)) {
            return response()->json('Plan not found', 404);
        }

        $comment = Comment::create([
            'content' => $request->content,
            'rating' => $request->rating,
            'plan_id' => $request->plan_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'Comment created' => new CommentResource($comment)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($comment_id)
    {
        $comment = Comment::find($comment_id);
        if (is_null($comment)) {
            return response()->json('Comment not found', 404);
        }
        return response()->json(new CommentResource($comment));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' =>  'required|string|max:255',
            'rating' =>  'required|integer|min:1|max:5',
            'plan_id' =>  'required|integer|max:255',
            'user_id' =>  'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }

        $plan = Plan::find($request->plan_id);
        if (is_null($plan)) {
            return response()->json('Plan not found', 404);
        }

        $comment->content = $request->content;
        $comment->rating = $request->rating;
        $comment->plan_id = $request->plan_id;
        $comment->user_id = $request->user_id;

        $comment->save();

        return response()->json([
            'Comment updated' => new CommentResource($comment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json('Comment deleted');
    }
}
