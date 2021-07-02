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

Route::middleware(['auth', 'verified'])->group(
    function () {
        Route::resource('users', UserController::class);
        Route::resource('items', ItemController::class);
        Route::resource('contacts', ContactController::class);
        Route::resource('documents', DocumentController::class);
        Route::group(
            ['prefix' => 'documents/{document}','as' => 'documents.'],
            function () {
                Route::put('received', [DocumentController::class,'recieved'])->name('received');
                Route::put('paid', [DocumentController::class,'paid'])->name('paid');
                Route::put('refunded', [DocumentController::class,'refunded'])->name('refunded');
                Route::put('invoice_returned', [DocumentController::class,'invoiceReturned'])->name('invoice_returned');
                Route::put('bill_returned', [DocumentController::class,'billReturned'])->name('bill_returned');
                Route::put('delivered', [DocumentController::class,'delivered'])->name('delivered');
            }
        );
        Route::resource('accounts', AccountController::class);
        Route::resource('entries', EntryController::class);
        Route::resource('inventories', InventoryController::class);
    }
);
