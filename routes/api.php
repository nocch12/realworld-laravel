<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', fn () => 'hello');

// /users/*
Route::prefix('users')
    ->name('users.')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('/', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

// /user/*
Route::prefix('user')
    ->name('user.')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'me')->name('me');
        Route::put('/', 'update')->name('update');
    });

// /profiles/*
Route::prefix('profiles')
    ->name('profiles.')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/{user}', 'show')->name('show');
        Route::post('/{user}/follow', 'follow')->name('follow');
        Route::delete('/{user}/follow', 'unfollow')->name('unfollow');
    });

// /articles/*
Route::prefix('articles')
    ->name('articles.')
    ->controller(ArticleController::class)
    ->group(function () {
        Route::get('/', 'list')->name('list');
        Route::post('/', 'store')->name('store');
        Route::get('/feed', 'feed')->name('feed');
        Route::get('/{article}', 'show')->name('show');
        Route::put('/{article}', 'update')->name('update');
        Route::delete('/{article}', 'destroy')->name('destroy');
    });

// /articles/:slug/comments/*
Route::prefix('articles')
    ->name('comments.')
    ->controller(CommentController::class)
    ->group(function () {
        Route::get('/{article}/comments', 'list')->name('list');
        Route::post('/{article}/comments', 'store')->name('store');
        Route::delete('/{article}/comments/{id}', 'destroy')->name('destroy');
    });
