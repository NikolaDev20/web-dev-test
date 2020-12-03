<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatus;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
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
    public function commentReplies(int $id)
    {
        // we could use ->replies as relationship here but we won't get paginate so
        $comment = Comment::findOrFail($id);
        $commentReplies = CommentReply::where('comment_id', $id)->paginate(10);

        return view('comments.replies', compact('commentReplies'));
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
    public function store(CommentCreateRequest $request)
    {
        try {
            $comment = Comment::create($request->validated());
            if ($comment->post_id == null) {
                $email = News::find($comment->news_id)->author->email;
                $link = route('news.show', $comment->news_id);
                Mail::to($email)->send(new \App\Mail\NewPostCommentNotification($link));
                return back()->with('success_message', "Comment succesfully posted, admin will review it shortly");
            } else {
                $email = Post::find($comment->post_id)->author->email;
                $link = route('post.show', $comment->post_id);
                Mail::to($email)->send(new \App\Mail\NewPostCommentNotification($link));
                return back()->with('success_message', "Comment succesfully posted, admin will review it shortly");
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function approveComment(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = CommentStatus::APPROVED;
        $comment->save();
        if ($comment->post_id == null) {
            $news = News::find($comment->news_id);
            $link = route('news.show', $news->id);
            Mail::to($news->author->email)->send(new \App\Mail\PostCommentApprovedUserMail($link));
            return back()->with('success_message', "Comment successfuly published");
        } else {
            $post = Post::find($comment->post_id);
            $link = route('post.show', $post->id);
            Mail::to($post->author->email)->send(new \App\Mail\PostCommentApprovedUserMail($link));
            return back()->with('success_message', "Comment successfuly published");
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPostComments(int $id)
    {
        $postComments = Comment::where('post_id', $id)->paginate(10);
        return view('posts.comments', compact('postComments'));
    }
    public function showNewsComments(int $id)
    {
        $newsComments = Comment::where('news_id', $id)->paginate(10);
        return view('news.comments', compact('newsComments'));
    }
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateRequest $request, $id)
    {
        $comment =  Comment::findOrFail($id);
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
        Comment::destroy($id);

        return back()->with('success', 'Comment Deleted!');
    }
}
