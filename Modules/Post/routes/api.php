<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('posts', PostController::class)->names('post');
});
