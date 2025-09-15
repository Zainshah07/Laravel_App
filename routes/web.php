<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login-check', 'loginAction')->name('login.action');
    Route::post('/logout','logout')->name('logout');
    Route::get('/register','registerView')->name('register');
    Route::post('/register','register')->name('register.action');
    Route::get('/verify-email/{token}','verify')->name('verify.email');

});

// Route::get('/login', [AuthController::class , 'login'])->name('login');
// Route::post('/login-check',[AuthController::class,'loginAction'])->name('login.action');
// Route::post('/logout',[AuthController::class,'logout'])->name('logout');



// Route::get('/register', function(){
//     return view('Auth.register');;
// })->name('register');

// Route::post('/register', [AuthController::class, 'register']);



// Route::get('/verify-email/{token}', [AuthController::class, 'verify'])->name('verify.email');


Route::resource('users', UserController::class);

// Show the form
Route::get('/forgot-password', function(){
    return view('auth.forget-password');
})->name('forgot.password.form');
Route::get('/reset-password-form', function () {
    return view('auth.reset-password'); // Blade file you will create
})->name('reset.password.form');

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('reset.password');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password-update', [AuthController::class, 'updatePassword'])
    ->name('profile.password.update');
});
