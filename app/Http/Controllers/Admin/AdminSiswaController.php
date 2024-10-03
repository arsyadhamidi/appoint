<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data jurusan untuk dropdown
        $jurusans = Jurusan::latest()->get();

        // Query dasar untuk mengambil data siswa
        $siswas = Siswa::query();

        // Filter berdasarkan jurusan jika ada
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $siswas->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan kelas jika ada
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $siswas->where('kelas_id', $request->kelas_id);
        }

        // Mengambil semua data siswa setelah filter
        $siswas = $siswas->latest()->get();

        return view('admin.siswa.index', [
            'siswas' => $siswas,
            'jurusans' => $jurusans,
        ]);
    }

    public function create()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.siswa.create', [
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nisn' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telp_ortu' => 'required|max:255',
            'alamat' => 'required|max:255',
            'foto_siswa' => 'nullable|mimes:png,jpg,jpeg|max:10240',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi.',
            'kelas_id.required' => 'Kelas wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.max' => 'NISN tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tmp_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Format Tanggal Lahir tidak valid.',
            'jk.required' => 'Jenis Kelamin wajib diisi.',
            'jk.max' => 'Jenis Kelamin tidak boleh lebih dari 255 karakter.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'telp_ortu.required' => 'Nomor Telepon Orang Tua wajib diisi.',
            'telp_ortu.max' => 'Nomor Telepon Orang Tua tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'foto_siswa.mimes' => 'Foto harus berupa file dengan format png, jpg, atau jpeg.',
            'foto_siswa.max' => 'Ukuran Foto tidak boleh lebih dari 10MB.',
        ]);

        if ($request->file('foto_siswa')) {
            $validated['foto_siswa'] = $request->file('foto_siswa')->store('foto_siswa');
        } else {
            $validated['foto_siswa'] = null;
        }

        $siswas = Siswa::create($validated);

        User::create([
            'name' => $request->nama ?? '-',
            'email' => $request->email ?? '-',
            'password' => bcrypt('12345678'),
            'level_id' => '2',
            'telp' => $request->telp,
            'siswa_id' => $siswas->id,
        ]);

        return redirect('/data-siswa')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $jurusans = Jurusan::latest()->get();
        $siswas = Siswa::where('id', $id)->first();
        return view('admin.siswa.edit', [
            'jurusans' => $jurusans,
            'siswas' => $siswas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nisn' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telp_ortu' => 'required|max:255',
            'alamat' => 'required|max:255',
            'foto_siswa' => 'nullable|mimes:png,jpg,jpeg|max:10240',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi.',
            'kelas_id.required' => 'Kelas wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.max' => 'NISN tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tmp_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Format Tanggal Lahir tidak valid.',
            'jk.required' => 'Jenis Kelamin wajib diisi.',
            'jk.max' => 'Jenis Kelamin tidak boleh lebih dari 255 karakter.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'telp_ortu.required' => 'Nomor Telepon Orang Tua wajib diisi.',
            'telp_ortu.max' => 'Nomor Telepon Orang Tua tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'foto_siswa.mimes' => 'Foto harus berupa file dengan format png, jpg, atau jpeg.',
            'foto_siswa.max' => 'Ukuran Foto tidak boleh lebih dari 10MB.',
        ]);

        $siswas = Siswa::where('id', $id)->first();
        if ($request->file('foto_siswa')) {
            if ($siswas->foto_siswa) {
                Storage::delete($siswas->foto_siswa);
            }
            $validated['foto_siswa'] = $request->file('foto_siswa')->store('foto_siswa');
        } else {
            $validated['foto_siswa'] = $siswas->foto_siswa;
        }

        $siswas->update($validated);

        return redirect('/data-siswa')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $siswas = Siswa::find($id);
        if ($siswas->foto_siswa) {
            Storage::delete($siswas->foto_siswa);
        }
        $siswas->delete();
        return redirect('/data-siswa')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

    public function jquerySiswaKelas(Request $request)
    {
        $id_jurusan = $request->id_jurusan;

        $kelass = Kelas::where('jurusan_id', $id_jurusan)->get();

        foreach ($kelass as $data) {
            echo "<option value='$data->id'>$data->kelas</option>";
        }
    }
}
