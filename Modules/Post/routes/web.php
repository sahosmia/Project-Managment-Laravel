<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostAttachmentController;
use Modules\Post\Http\Controllers\PostCommentController;
use Modules\Post\Http\Controllers\PostController;
use Modules\Post\Http\Controllers\PostLikeController;
use Modules\Post\Http\Controllers\PostPinController;

// Route::prefix('projects')->name('projects')->group(function () {

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// });
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


Route::post('/post-like', [PostLikeController::class, 'toggle'])->name('post.like');
Route::post('/posts/{post}/pin', [PostPinController::class, 'toggle'])->name('post.pin');
Route::delete('/post-attachments/{attachment}', [PostAttachmentController::class, 'destroy'])->name('post-attachments.destroy');

Route::post('/comments', [PostCommentController::class, 'store'])->name('comments.store');
Route::put('/comments/{comment}', [PostCommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [PostCommentController::class, 'destroy'])->name('comments.destroy');
