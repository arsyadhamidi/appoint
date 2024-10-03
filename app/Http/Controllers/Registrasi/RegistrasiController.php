<?php

namespace App\Http\Controllers\Registrasi;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::latest()->get();
        return view('registrasi', [
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8',
            'telp' => 'required|min:11',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'email.required' => 'Email Lengkap wajib diisi',
            'email.dns' => 'Email harus berformat valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 11 karakter',
        ]);

        User::create([
            'name' => $request->name ?? '-',
            'email' => $request->email ?? '-',
            'password' => bcrypt($request->password),
            'level' => 'Konsumen',
            'telp' => $request->telp ?? '-',
        ]);

        return redirect('/login')->with('success', 'Selamat ! Anda berhasil melakukan registrasi');
    }

    public function jqueryRegistrasiSiswa(Request $request)
    {
        $id_jurusan = $request->id_jurusan;

        $kelass = Kelas::where('jurusan_id', $id_jurusan)->get();

        foreach ($kelass as $data) {
            echo "<option value='$data->id'>$data->kelas</option>";
        }
    }
}
