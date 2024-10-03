<?php

namespace App\Http\Controllers\ForgotPassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot-password');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required',
        ], [
            'email.required' => 'Email Address wajib diisi',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/recover-password');
        }

        return back()->with('error', 'Email tidak ditemukan!');
    }
}
