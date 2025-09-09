<?php

use Illuminate\Support\Facades\Route;
use Lnq\Blog\Http\Controllers\Admin\PostAdminController;

Route::prefix(config('blog.admin_prefix', 'dashboard/blog'))
    ->middleware(array_merge(config('blog.admin_middleware', ['web', 'auth']), ['permission:blog.view']))
    ->name('blog.admin.')
    ->group(function () {
        Route::get('/', [PostAdminController::class, 'index'])->name('index');         // /dashboard/blog
        Route::get('/create', [PostAdminController::class, 'create'])->name('create')->middleware('permission:blog.create'); // /dashboard/blog/create
        Route::post('/', [PostAdminController::class, 'store'])->name('store')->middleware('permission:blog.create');
        Route::get('/{post}/edit', [PostAdminController::class, 'edit'])->name('edit')->middleware('permission:blog.edit');
        Route::put('/{post}', [PostAdminController::class, 'update'])->name('update')->middleware('permission:blog.edit');
        Route::delete('/{post}', [PostAdminController::class, 'destroy'])->name('destroy')->middleware('permission:blog.delete');
        Route::patch('/{post}/toggle', [PostAdminController::class, 'toggle'])->name('toggle')->middleware('permission:blog.publish'); // publicar/despublicar
    });
