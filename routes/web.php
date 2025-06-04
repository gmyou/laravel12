<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route for the login form
// todo authentication
Route::get('/admin', [LoginController::class, 'login'])->name('login.form');
Route::get('/amdin/dashboard', [AdminController::class, 'index'])->name('admin.index');