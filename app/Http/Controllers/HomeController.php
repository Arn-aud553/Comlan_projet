<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    // Display the home page
    public function index()
    {
        return view('home');
    }

    // Handle login logic
    public function login(Request $request)
    {
        $request->validate([
            'nom' => 'required|regex:/^[^0-9<>]+$/',
            'prenom' => 'required|regex:/^[^0-9<>]+$/',
            'email' => 'required|email',
            'telephone' => 'required|digits_between:8,15',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('register');
        }

        Auth::login($user);

        return redirect()->route('welcome');
    }

    // Redirect to registration page
    public function register()
    {
        return view('auth.register');
    }
}