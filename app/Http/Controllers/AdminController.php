<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Allowed IPs for admin access
    protected $allowedIps;
    public function __construct()
    {
        // Load allowed IPs from the configuration file
        $this->allowedIps = config('admin.allowed_ips', []);

        if (!in_array(request()->ip(), $this->allowedIps)) {
            abort(403, 'Unauthorized access');
        }
    }
    
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
