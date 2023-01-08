<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\LoginAction;
use App\Http\Controllers\User\RegisterAction;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::prefix('users')
    ->name('users.')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('/', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

Route::prefix('user')
    ->name('user.')
    ->middleware('auth:api')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'me')->name('me');
        Route::put('/', 'update')->name('update');
    });

Route::prefix('profiles')
    ->name('profiles.')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/{user}', 'show')->name('show');
    });
