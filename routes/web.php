<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DropdownController;
use Illuminate\Support\Facades\Route;

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
Route::get('/get-categories', [DropdownController::class, 'getCategories'])->name('get.categories');

require __DIR__.'/admin.php';

