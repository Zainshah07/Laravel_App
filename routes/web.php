<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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

require __DIR__.'/admin.php';

Route::get('/test-email', function () {
    return view('emails.password-reset', [
        'token' => '123456',
        'email' => 'demo@example.com',
    ]);
});

