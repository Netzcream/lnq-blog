<?php

use Illuminate\Support\Facades\Route;
use Lnq\Blog\Http\Controllers\PostController;

Route::prefix(config('blog.public_prefix', 'blog'))
    ->middleware(['web'])
    ->name('blog.')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');        // /blog
        Route::get('/{slug}', [PostController::class, 'show'])->name('show');    // /blog/{slug}
    });
