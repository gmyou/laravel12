<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route for the login form
Route::get('/admin', [LoginController::class, 'login'])->name('login.form');
Route::get('/amdin/dashboard', [AdminController::class, 'index'])->name('admin.index');

// Customer routes
// todo include authentication middleware for admin routes
Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('admin.customer.show');
Route::post('/customer', [CustomerController::class, 'create'])->name('admin.customer.create');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'delete'])->name('admin.customer.delete');