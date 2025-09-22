<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;

// Login and Register Routes//

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login-check', 'loginAction')->name('login.action');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'registerView')->name('register');
    Route::post('/register', 'register')->name('register.action');
    Route::get('/verify-email/{token}/{email}', 'verify')->name('verify.email');

});

//dashboard//
Route::get('/dashboard',function(){
    return view('admin.dashboard.index');
})->name('dashboard.index');

// Profile update Routes//

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password-update', [AuthController::class, 'updatePassword'])
        ->name('profile.password.update');
});

// Category Routes//

Route::middleware(['auth'])->controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('/destroy/{id}','destroy')->name('destroy');
});

// Sub Category Routes//
Route::middleware(['auth'])->controller(SubCategoryController::class)->prefix('sub-category')->name('sub-category.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
});

// Product Routes//
Route::middleware('auth')->controller(ProductController::class)->prefix('product')->name('product.')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/','store')->name('store');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('/destroy/{id}','destroy')->name('destroy');
});

// Forget Password and Reset Form Routes//

Route::get('/forgot-password', function () {
    return view('auth.forget-password');
})->name('forgot.password.form');
Route::get('/reset-password-form', function () {
    return view('auth.reset-password'); // Blade file you will create
})->name('reset.password.form');
