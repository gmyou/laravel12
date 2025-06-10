<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IpgServerController;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route for the login form
Route::get('/admin', [LoginController::class, 'login'])->name('login');
Route::post('/admin', [LoginController::class, 'authenticate'])->name('login.store');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout.store');

Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

        // Customer routes
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
        Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('admin.customer.show');
        Route::post('/customer', [CustomerController::class, 'create'])->name('admin.customer.create');
        Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');
        Route::delete('/customer/{id}', [CustomerController::class, 'delete'])->name('admin.customer.delete');

        // IPG Server routes
        Route::get('/ipgserver', [IpgServerController::class, 'index'])->name('admin.ipgserver');
        Route::get('/ipgserver/{id}', [IpgServerController::class, 'show'])->name('admin.ipgserver.show');
        Route::post('/ipgserver', [IpgServerController::class, 'create'])->name('admin.ipgserver.create');
        Route::put('/ipgserver/{id}', [IpgServerController::class, 'update'])->name('admin.ipgserver.update');
        Route::delete('/ipgserver/{id}', [IpgServerController::class, 'delete'])->name('admin.ipgserver.delete');
    });
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('/cash', [ApiController::class, 'get_cash'])->name('api.get_cash');
    // Add more API routes as needed
});