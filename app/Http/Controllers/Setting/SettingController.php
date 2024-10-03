<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();
        return view('setting.index', [
            'users' => $users,
        ]);
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'telp' => 'required|min:11',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 11 karakter',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'name' => $request->name ?? '-',
            'telp' => $request->telp ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui profile');
    }

    public function updateemail(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns|unique:users,email',
        ], [
            'email.required' => 'Email Baru wajib diisi',
            'email.dns' => 'Email harus memiliki format valid~',
            'email.unique' => 'Alamat Email ini sudah tersedia',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'email' => $request->email ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui alamat email');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'konfirmasipassword' => 'required|min:8|same:password',
        ], [
            'password.required' => 'Password wajib diisi',
            'konfirmasipassword.required' => 'Konfirmasi Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'konfirmasipassword.min' => 'Konfirmasi Password minimal 8 karakter',
            'konfirmasipassword.same' => 'Password dan Konfirmasi harus sama',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'password' => bcrypt($request->password) ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui password');
    }

    public function updategambar(Request $request)
    {
        $request->validate([
            'foto_profile' => 'required|mimes:png,jpg,jpeg|max:2048',
        ], [
            'foto_profile.required' => 'Foto Profile wajib diisi',
            'foto_profile.mimes' => 'Foto Profile memiliki format berupa PNG, JPEG, atau JPG',
            'foto_profile.max' => 'Foto Profile maximal 2 MB',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        if ($request->file('foto_profile')) {
            // Hapus foto profil lama jika ada
            if ($users->foto_profile) {
                Storage::delete($users->foto_profile);
            }

            // Simpan foto profil baru
            $fotoProfile = $request->file('foto_profile')->store('foto_profile');
            $users->update([
                'foto_profile' => $fotoProfile,
            ]);
        }

        return redirect('setting')->with('success', 'Selamat! Anda berhasil memperbaharui foto profile');
    }

    public function hapusgambar()
    {
        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        if ($users->foto_profile) {
            Storage::delete($users->foto_profile);
        }

        $users->update([
            'foto_profile' => null,
        ]);

        return redirect('setting')->with('success', 'Selamat! Anda berhasil menghapus foto profile');
    }

}
