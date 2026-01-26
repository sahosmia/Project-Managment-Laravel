<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;


// Route::prefix('projects')->name('projects')->group(function () {

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    // });
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

Route::post('/post-like', [PostLikeController::class, 'toggle'])->name('post.like');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/posts/{post}/pin', [PostPinController::class, 'toggle'])->name('post.pin');
