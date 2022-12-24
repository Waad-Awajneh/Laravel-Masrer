<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use App\Http\Traits\AuthResponse;

class CommentController extends Controller
{
    use AuthResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return response()->json($comments);
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
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|integer'
        ]);
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->post_id,
            'comment' => $request->comment
        ]);

        return $this->success('', 'comment created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
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
        if (!$this->isAuthorize($comment)) {
            return $this->error('', 'you are not authorize to update', 403);
        }
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment->update([
            'comment' => $request->comment
        ]);

        return $this->success('', 'comment updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        return $this->isAuthorize($comment) ? $comment->delete() : $this->error('', 'you are not authorize to delete this comment', 403);
    }

    protected function isAuthorize($comment)
    {
        return Auth::user()->id == $comment->user_id ? true : false;
    }


    public function getCommentByPost(Post $post)
    {

        $comments_info = CommentResource::collection($post->comments);

        return response()->json($comments_info);
    }
}
