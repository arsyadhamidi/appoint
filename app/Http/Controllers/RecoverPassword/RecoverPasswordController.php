<?php

namespace App\Http\Controllers\RecoverPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
    public function index()
    {
        return view('recover-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'konfirmasipassword' => 'required|min:8|same:password',
        ], [
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter.',
            'konfirmasipassword.required' => 'Confirm Password wajib diisi!',
            'konfirmasipassword.min' => 'Confirm Password minimal 8 karakter.',
            'konfirmasipassword.same' => 'Password dan Konfirmasi Password harus sama.',
        ]);

        $user = Auth::user(); // Retrieve the authenticated user

        // Update the user's password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::logout(); // Log the user out after password change
        $request->session()->invalidate();

        return redirect('/login')->with('success', 'Selamat ! Anda berhasil memperbaharui password terbaru');
    }
}
