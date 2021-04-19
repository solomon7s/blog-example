<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Blog\CommentController;


Route::get('/', [PostController::class, 'index'])->name('list');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/', [PostController::class, 'create'])->name('create');
    Route::put('/{id}', [PostController::class, 'update'])->name('update');
    Route::delete('/{id}', [PostController::class, 'delete'])->name('delete');
});


Route::get('/{id}/comments', [CommentController::class, 'index'])->name('comments.list');

Route::prefix('/{id}/comment')
    ->middleware('auth:sanctum')
    ->name('comments.')
    ->group(function () {
        Route::post('/', [CommentController::class, 'create'])->name('create');
        Route::put('/{cid}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{cid}', [CommentController::class, 'delete'])->name('delete');
});
