<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatus;
use App\Http\Requests\PostComment\PostCommentCreateRequest;
use App\Http\Requests\PostComment\PostCommentUpdateRequest;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function showComments(int $id)
    {
        $postComments = PostComment::where('post_id', $id)->paginate(10);
        return view('posts.comments', compact('postComments'));
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
    public function store(PostCommentCreateRequest $request)
    {
        try {
            PostComment::create($request->validated());
            $post = Post::findOrFail($request->post_id);
            $link = route('post.show', $post->id);
            \Mail::to($post->author->email)->send(new \App\Mail\NewPostCommentNotification($link));
            return back()->with('success_message', "Comment succesfully posted, admin will review it shortly");
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
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

        $comment = PostComment::findOrFail($id);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCommentUpdateRequest $request, $id)
    {
        $comment =  PostComment::findOrFail($id);
        $comment->update($request->validated());
        return redirect(route('post.comments', $comment->post_id))->with('success', 'Comment Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostComment::destroy($id);

        return back()->with('success', 'Comment Deleted!');
    }
}
