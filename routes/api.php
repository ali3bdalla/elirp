<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EntryController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('entries', EntryController::class);
    Route::resource('inventories', InventoryController::class);
});
