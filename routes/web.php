<?php

// routes/web.php
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Auth routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin routes with middleware
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::resource('articles', ArticleController::class);
    Route::get('/', function() {
        return redirect()->route('admin.articles.index');
    });
});

// Blog Routes
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/artikel/{article}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/kategori/{category}', [BlogController::class, 'category'])->name('blog.category');

// API Routes untuk AJAX (opsional)
Route::prefix('api')->group(function () {
    Route::get('/articles', function() {
        return \App\Models\Article::published()
            ->select('id', 'title', 'slug', 'excerpt', 'category', 'published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(6);
    });
});
