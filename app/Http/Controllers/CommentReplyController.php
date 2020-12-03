<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatus;
use App\Http\Requests\CommentReply\CommentReplyCreateRequest;
use App\Http\Requests\CommentReply\CommentReplyUpdateRequest;
use App\Models\CommentReply;
use App\Models\News;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentReplyController extends Controller
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

    public function approveComment(int $id)
    {
        $reply = CommentReply::findOrFail($id);
        $reply->approved = CommentStatus::APPROVED;
        $reply->save();
        if ($reply->comment->post_id == null) {
            $news = News::find($reply->comment->news_id);
            $link = route('news.show', $news->id);
            Mail::to($news->author->email)->send(new \App\Mail\PostCommentApprovedUserMail($link));
            return back()->with('success_message', "Comment successfuly published");
        } else {
            $post = Post::find($reply->comment->post_id);
            $link = route('post.show', $post->id);
            Mail::to($post->author->email)->send(new \App\Mail\PostCommentApprovedUserMail($link));
            return back()->with('success_message', "Comment successfuly published");
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentReplyCreateRequest $request)
    {
        try {
            $commentReply = CommentReply::create($request->validated());
            if ($commentReply->comment->post_id == null) {
                $email = News::find($commentReply->comment->news_id)->author->email;
                $link = route('news.show', $commentReply->comment->news_id);
                Mail::to($email)->send(new \App\Mail\NewNewsCommentNotification($link));
                return back()->with('success_message', "Comment succesfully posted, admin will review it shortly");

            } else {
                $email = Post::find($commentReply->comment->post_id)->author->email;
                $link = route('post.show', $commentReply->comment->post_id);
                Mail::to($email)->send(new \App\Mail\NewPostCommentNotification($link));
                return back()->with('success_message', "Comment succesfully posted, admin will review it shortly");
            }
        } catch (\Exception $e) {
            return info($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CommentReply $commentReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentReply $commentReply)
    {
        return view('comments.replies.edit', compact('commentReply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentReplyUpdateRequest $request, CommentReply $commentReply)
    {
        try {
            $commentReply->update($request->validated());
            return back()->with('message', 'Sucess');
            return redirect(route('posts.show'))->with('success', 'Comment Updated!');
        } catch (\Exception $e) {
            return info($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentReply $commentReply)
    {
        $commentReply->delete($commentReply);
        return back();
    }
}
