<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::latest()->get();
        return view('admin.guru.index', [
            'gurus' => $gurus,
        ]);
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'telp' => 'required|min:11',
            'email' => 'required',
            'alamat' => 'required',
            'foto_guru' => 'required|mimes:png,jpeg,jpg|max:2048',
        ], [
            'nip.required' => 'NIP Guru wajib diisi',
            'nip.unique' => 'NIP Guru sudah tersedia',
            'nama.required' => 'Nama Lengkap sudah tersedia',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis kelamin wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 11 karakter',
            'email.required' => 'Alamat Email wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
            'foto_guru.required' => 'Foto Guru wajib diisi',
            'foto_guru.mimes' => 'Foto Guru harus memiliki format berupa PNG, JPG, atau JPEG',
            'foto_guru.max' => 'Foto Guru maksimals 2 MB',
        ]);

        $emails = $request->email;
        $users = User::where('email', $emails)->first();
        $fotoGuru = '';

        if (!empty($users)) {
            return back()->with('error', 'Alamat Email sudah tersedia');
        }

        if ($request->file('foto_guru')) {
            $fotoGuru = $request->file('foto_guru')->store('foto_guru');
        }

        $gurusId = Guru::create([
            'nip' => $request->nip ?? '-',
            'nama' => $request->nama ?? '-',
            'tmp_lahir' => $request->tmp_lahir ?? '-',
            'tgl_lahir' => $request->tgl_lahir ?? '-',
            'jk' => $request->jk ?? '-',
            'telp' => $request->telp ?? '-',
            'email' => $request->email ?? '-',
            'alamat' => $request->alamat ?? '-',
            'foto_guru' => $fotoGuru ?? null,
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
            'level_id' => '3',
            'telp' => $request->telp,
            'guru_id' => $gurusId->id,
        ]);

        return redirect('/data-guru')->with('success', 'Selamat | Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        return view('admin.guru.edit', [
            'gurus' => Guru::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'telp' => 'required|min:11',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis kelamin wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 11 karakter',
            'alamat.required' => 'Alamat Domisili wajib diisi',
        ]);

        $fotoGuru = '';
        $gurus = Guru::where('id', $id)->first();
        if ($request->file('foto_guru')) {
            if ($gurus->foto_guru) {
                Storage::delete($gurus->foto_guru);
            }
            $fotoGuru = $gurus->foto_guru;
        }

        $gurus->update([
            'nama' => $request->nama ?? '-',
            'tmp_lahir' => $request->tmp_lahir ?? '-',
            'tgl_lahir' => $request->tgl_lahir ?? '-',
            'jk' => $request->jk ?? '-',
            'telp' => $request->telp ?? '-',
            'alamat' => $request->alamat ?? '-',
            'foto_guru' => $fotoGuru ?? null,
        ]);

        return redirect('/data-guru')->with('success', 'Selamat | Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $gurus = Guru::where('id', $id)->first();
        $gurus->delete();

        return redirect('/data-guru')->with('success', 'Selamat | Anda berhasil menghapus data');
    }
}
