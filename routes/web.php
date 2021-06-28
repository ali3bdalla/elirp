<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\ItemController;
use App\Http\Controllers\Web\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

Route::group(['prefix' => 'auth', 'as' => '.auth', 'middleware' => 'guest'], function () {
    foreach (config('oauth-clients') as $client => $enabled) {
        if ($enabled) {
            Route::group(['prefix' => $client, 'as' => ".$client"], function () use ($client) {
                Route::get('redirect', function () use ($client) {
                    return Socialite::driver($client)->redirect();
                });
                Route::get('callback', function () use ($client) {
                    $authController = new AuthController();
                    return $authController->auth($client);
                });
            });
        }
    }
});
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Web\DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
});
