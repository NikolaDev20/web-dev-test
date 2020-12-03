<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('posts')->group(function () {
        Route::get('', [PostsController::class, 'index'])->name('post.index');
        Route::get('create', [PostsController::class, 'create'])->name('post.create');
        Route::get('edit/{id}', [PostsController::class, 'edit'])->name('post.edit');
        Route::post('store/{id?}', [PostsController::class, 'store'])->name('post.store');
        Route::delete('destroy/{id?}', [PostsController::class, 'destroy'])->name('post.destroy');
    });

    Route::prefix('news')->group(function () {
        Route::get('', [NewsController::class, 'index'])->name('news.index');
        Route::get('create', [NewsController::class, 'create'])->name('news.create');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('store/{id?}', [NewsController::class, 'store'])->name('news.store');
        Route::delete('destroy/{id?}', [NewsController::class, 'destroy'])->name('news.destroy');
    });
});
//Routes for comment replies
Route::resource('comments',CommentController::class)->name('*','comments');


Route::resource('comment_replies', CommentReplyController::class)->name('*','comment_replies');
Route::get('comment_reply/approve/{id}', [CommentReplyController::class, 'approveComment'])->name('comment_replies');
//Routes for Post Comments
Route::get('post_comments/{id}', [CommentController::class, 'showPostComments'])->name('post.comments');
Route::get('news.comments/{id}', [CommentController::class, 'showNewsComments'])->name('news.comments');
Route::get('comment/approve/{id}', [CommentController::class, 'approveComment'])->name('comment.approve');
Route::get('comment/replies/{id}', [CommentController::class, 'commentReplies'])->name('comment.replies');


require __DIR__.'/auth.php';
Route::get('', [FrontendController::class, 'home'])->name('home');
Route::get('/posts', [FrontendController::class, 'posts'])->name('posts');
Route::get('/posts/{id}', [FrontendController::class, 'postShow'])->name('post.show');
Route::get('/news', [FrontendController::class, 'news'])->name('news');
Route::get('/news/{id}', [FrontendController::class, 'newsShow'])->name('news.show');
