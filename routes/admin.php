<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Auth\PasswordResetController;



//Login and Register Routes//

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login-check', 'loginAction')->name('login.action');
    Route::post('/logout','logout')->name('logout');
    Route::get('/register','registerView')->name('register');
    Route::post('/register','register')->name('register.action');
    Route::get('/verify-email/{token}/{email}','verify')->name('verify.email');

});

//Profile update Routes//

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password-update', [AuthController::class, 'updatePassword'])
    ->name('profile.password.update');
});

//Category Routes//

Route::middleware(['auth'])->controller(CategoryController::class)->group(function(){
    Route::get('/category','index')->name('category.index');
    Route::post('/category','store')->name('category.store');
});

//Sub Category Routes//
Route::middleware(['auth'])->controller(SubCategoryController::class)->group(function(){
    Route::get('/sub-category','index')->name('sub_category.index');
    Route::post('/sub-category','store')->name('sub-category.store');
});







//Forget Password and Reset Form Routes//

Route::get('/forgot-password', function(){
    return view('auth.forget-password');
})->name('forgot.password.form');
Route::get('/reset-password-form', function () {
    return view('auth.reset-password'); // Blade file you will create
})->name('reset.password.form');
