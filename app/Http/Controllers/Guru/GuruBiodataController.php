<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruBiodataController extends Controller
{
    public function index()
    {
        $gurus = Guru::where('id', Auth::user()->guru_id)->first();
        return view('guru.biodata.index', [
            'gurus' => $gurus,
        ]);
    }

    // Guru
    public function edit($id)
    {
        $gurus = Guru::where('id', $id)->first();
        return view('guru.biodata.edit', [
            'gurus' => $gurus,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'nullable|unique:gurus,nip,' . $id,
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'telp' => 'required|min:11',
            'alamat' => 'required',
        ], [
            'nip.unique' => 'NIP sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis kelamin wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 11 karakter',
            'alamat.required' => 'Alamat Domisili wajib diisi',
        ]);

        $gurus = Guru::findOrFail($id);

        $fotoGuru = $gurus->foto_guru; // default to existing photo
        if ($request->hasFile('foto_guru')) {
            // Delete old photo if it exists
            if ($fotoGuru) {
                Storage::delete($fotoGuru);
            }
            // Store new photo
            $fotoGuru = $request->file('foto_guru')->store('foto_guru');
        }

        $gurus->update([
            'nip' => $request->nip ?? $gurus->nip,
            'nama' => $request->nama ?? '-',
            'tmp_lahir' => $request->tmp_lahir ?? '-',
            'tgl_lahir' => $request->tgl_lahir ?? '-',
            'jk' => $request->jk ?? '-',
            'telp' => $request->telp ?? '-',
            'alamat' => $request->alamat ?? '-',
            'foto_guru' => $fotoGuru,
        ]);

        return redirect('/biodata-guru')->with('success', 'Selamat | Anda berhasil memperbaharui data');
    }
}
