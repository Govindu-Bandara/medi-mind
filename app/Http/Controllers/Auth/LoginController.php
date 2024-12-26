<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle login attempt with validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate login input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Attempt to log in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication passed
            $user = Auth::user();

            // Redirect based on role
            return redirect($user->role === 'doctor' ? route('doctor.dashboard') : route('dashboard'));
        }

        // Authentication failed, redirect back with error and old input
        return redirect()->back()
            ->withInput($request->only('email')) // Retain email field value
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the home page
        return redirect('/');
    }
}
