<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCommentCanBeCreated()
    {
        $comment = Comment::create([
            'post_id' => 41,
            'name' => 'Nikola',
            'email' => 'nikola@mail.com',
            'content' => 'moj content'
        ]);
        $this->assertCount(1,Comment::all());
    }
    public function testCommentReplyCanBeMade()
    {
        $comment = Comment::create([
            'post_id' => 41,
            'name' => 'Nikola',
            'email' => 'nikola@mail.com',
            'content' => 'moj content'
        ]);
        $commentReply = CommentReply::create([
            'comment_id' => $comment->id,
            'email' => 'novmail@mail.com',
            'name' => 'Mihajlo',
            'content' => 'Nov reply',
        ]);
        $this->assertCount(1,CommentReply::all());
        
    }
    public function testIfCommentCanBeUpdated()
    {
        $comment = Comment::create([
            'post_id' => 41,
            'name' => 'Nikola',
            'email' => 'nikola@mail.com',
            'content' => 'moj content'
        ]);
        $comment->name = 'Mihajlo';
        $comment->save();
        $this->assertEquals('Mihajlo',Comment::first()->name);
    }
    public function testCommentCanBeDeleted()
    {
         $comment = Comment::create([
            'post_id' => 41,
            'name' => 'Nikola',
            'email' => 'nikola@mail.com',
            'content' => 'moj content'
        ]);
        $comment->delete($comment);
        $this->assertCount(0,Comment::all());
    }
    public function testCommentReplyCanBeEdited()
    {
        $comment = Comment::create([
            'post_id' => 41,
            'name' => 'Nikola',
            'email' => 'nikola@mail.com',
            'content' => 'moj content'
        ]);
        $commentReply = CommentReply::create([
            'comment_id' => $comment->id,
            'email' => 'novmail@mail.com',
            'name' => 'Mihajlo',
            'content' => 'Nov reply',
        ]);
        $commentReply->name = "Nikola";
        $commentReply->save();
        $this->assertEquals('Nikola',CommentReply::first()->name);
    }
}
