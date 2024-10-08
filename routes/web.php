<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\AdminUserController; 
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\ProductsController; 
use App\Http\Controllers\ChartCotroller; 


Route::get('/', function () {
    return view('login');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/register',  'showregister')->name('register');
    Route::post('/register/action',  'register')->name('action.register');

    Route::get('/login',  'showlogin')->name('login');
    Route::post('/login/action',  'login')->name('action.login');

    Route::get('/verify-otp',  'showotp')->name('show.otp');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
    Route::post('/otp/resend',  'resendOtp')->name('otp.resend');

    Route::post('/logout/action',  'logout')->name('logout');

});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'admindashboard')->name('admin.dashboard');
    });

    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/admin/users', 'adminuser')->name('admin.users');

        Route::post('/users',  'store')->name('users.store');

        // Edit User Form
        Route::get('/users/{id}/edit',  'edit')->name('users.edit');
    
        // Update User
        Route::put('/users/{id}',  'update')->name('users.update');
    
           // Delete User Form
        Route::get('/users/{id}/delete',  'delete')->name('users.delete');
    
        // Delete User
        Route::delete('/users/{id}',  'destroy')->name('users.destroy');
    
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/admin/category', 'category')->name('category');

        Route::post('/category',  'store')->name('categories.store');
        // Edit User Form
        Route::get('/category/{id}/edit',  'edit')->name('categories.edit');
        // Update User
        Route::put('/category/{id}/update',  'update')->name('categories.update');
           // Delete User Form
        Route::get('/category/{id}/delete',  'delete')->name('categories.delete');
        // Delete User
        Route::delete('/category/{id}/destroy',  'destroy')->name('categories.destroy');
    
    });

    Route::controller(ProductsController::class)->group(function () {
        Route::get('/admin/products', 'index')->name('admin.products');
        Route::post('/products', 'store')->name('products.store');
        Route::get('/products/edit/{id}', 'edit')->name('products.edit');
        Route::put('/products/update/{id}', 'update')->name('products.update');
        Route::get('/products/delete/{id}', 'delete')->name('products.delete');
        Route::delete('/products/{id}', 'destroy')->name('products.destroy');
    });

    Route::get('/admin/charts', [ChartCotroller::class, 'showcharts'])->name('charts');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/user', 'userdashboard')->name('user.dashboard');
    });
});