<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('users', UserController::class);

// Password Controller Routes

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('reset.password');

Route::get('/catagory', function () {
    return view('admin.catagory.index');
});

// Dropdown Routes

Route::controller(DropdownController::class)->name('get.')->group(function(){
    Route::get('/get-categories','getCategories')->name('categories');
    Route::get('/get-sub-categories','getSubCategories')->name('sub-categories');
    Route::get('/get-products','getProducts')->name('products');
});


//Pos Routes

Route::controller(PosController::class)->prefix('pos')->name('pos.')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/','store')->name('store');
    Route::post('/add-to-cart','addToCart')->name('addToCart');
    Route::delete('/remove','destroy')->name('destroy');
});

//Order Routes
Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function(){
    Route::get('/','index')->name('index');
   Route::get('/show/{id}', 'show')->name('show');
});

require __DIR__.'/admin.php';
