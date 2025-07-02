<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Register user (create user)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'profile' => ['nullable', 'image', 'max:2048'], // profile picture optional
            'name' => ['required', 'min:3', 'max:20'],
            'role' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'max:200'],
        ]);

        if ($request->hasFile('profile')) {
            $validated['profile'] = $request->file('profile')->store('profiles', 'public');
        }

        // Hash password (if you don't rely on model casting)
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return redirect('/users')->with('success', 'User registered successfully!');
    }

    // Login user
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $validated['username'], 'password' => $validated['password']])) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }



    // List users
    public function index()
    {
        $users = User::all();
        return view('pages.users', compact('users'));
    }

    // Show a single user
    public function show(User $user)
    {
        return view('pages.user_action.view ', compact('user'));
    }

    // Show edit form
    public function edit(User $user)
    {
        return view('pages.user_action.update', compact('user'));
    }

    // Handle update form submission
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'profile' => ['nullable', 'image', 'max:2048'],
            'name' => ['required', 'min:3', 'max:50'],
            'role' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'password' => ['nullable', 'min:8', 'max:200'],
        ]);

        if ($request->hasFile('profile')) {
            $validated['profile'] = $request->file('profile')->store('profiles', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // Keep old password if none provided
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }



}
