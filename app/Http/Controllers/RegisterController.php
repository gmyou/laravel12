<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Store the registration data
    public function store(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('admin/register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $validated = $validator->validated();
        

        // Check if the passwords match
        if ($validated['password'] !== $validated['password_confirmation']) {
            return back()->withErrors(['password' => 'The passwords do not match.'])->onlyInput('email', 'name');
        }

        // Check if the user already exists
        if (User::where('email', $validated['email'])->exists()) {
            return back()->withErrors(['email' => 'The email has already been taken.'])->onlyInput('email', 'name');
        }

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Log the user in
        auth()->login($user);
        // Redirect to the admin dashboard
        return redirect()->route('admin.index')->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
    }
}
