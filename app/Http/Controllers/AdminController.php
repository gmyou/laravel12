<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login.form');
        }

        // Return the admin dashboard view
        return view('admin.dashboard');
    }
}
