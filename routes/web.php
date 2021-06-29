<?php

use App\Http\Controllers\Web\InventoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\BillController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\EntryController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\ItemController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DocumentController;
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

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'guest'], function () {
    foreach (config('oauth-clients') as $client => $enabled) {
        if ($enabled) {
            Route::group(['prefix' => $client, 'as' => "$client."], function () use ($client) {
                Route::get('redirect', function () use ($client) {
                    return Socialite::driver($client)->redirect();
                })->name('redirect');
                Route::get('callback', function () use ($client) {
                    $authController = new AuthController();
                    return $authController->auth($client);
                })->name('callback');
            });
        }
    }
});
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('items', ItemController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('bills', BillController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('entries', EntryController::class);
    Route::resource('inventories', InventoryController::class);


    Route::get('documents/{document}/print', [DocumentController::class,'printDocument'])->name('documents.print');
});
