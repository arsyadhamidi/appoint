<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JenisPelanggaran;
use App\Models\Jurusan;
use App\Models\NamaPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data jurusan dan jenis pelanggaran untuk dropdown
        $jurusans = Jurusan::latest()->get();
        $jenis = JenisPelanggaran::latest()->get();

        // Query dasar untuk mengambil data pelanggaran
        $pelanggarans = Pelanggaran::query();

        // Filter berdasarkan jurusan jika ada
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $pelanggarans->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan kelas jika ada
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $pelanggarans->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan jenis pelanggaran jika ada
        if ($request->has('jenispelanggaran_id') && $request->jenispelanggaran_id != '') {
            $pelanggarans->where('jenispelanggaran_id', $request->jenispelanggaran_id);
        }

        // Filter berdasarkan nama pelanggaran jika ada
        if ($request->has('namapelanggaran_id') && $request->namapelanggaran_id != '') {
            $pelanggarans->where('namapelanggaran_id', $request->namapelanggaran_id);
        }

        // Mengambil semua data pelanggaran setelah filter
        $pelanggarans = $pelanggarans->latest()->get();

        return view('admin.pelanggaran.index', [
            'pelanggarans' => $pelanggarans,
            'jurusans' => $jurusans,
            'jenis' => $jenis,
        ]);
    }

    public function create()
    {
        $gurus = Guru::latest()->get();
        $siswas = Siswa::latest()->get();
        $jenis = JenisPelanggaran::latest()->get();
        return view('admin.pelanggaran.create', [
            'jenis' => $jenis,
            'siswas' => $siswas,
            'gurus' => $gurus,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'guru_id' => 'required',
            'jenispelanggaran_id' => 'required',
            'namapelanggaran_id' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'status' => 'required',
            'bukti' => 'required|mimes:png,jpeg,jpg|max:10240',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'guru_id.required' => 'Guru wajib diisi',
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'namapelanggaran_id.required' => 'Nama Pelanggaran wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
            'tanggal.required' => 'Tanggal Pelanggaran wajib diisi',
            'status.required' => 'Status wajib diisi',
            'bukti.required' => 'Bukti wajib diisi',
            'bukti.mimes' => 'Bukti harus berformat PNG, JPEG, atau JPG',
            'bukti.max' => 'Bukti harus maksimal 10 MB',
        ]);

        if ($request->file('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti');
        } else {
            $validated['bukti'] = null;
        }

        $siswas = Siswa::where('id', $request->siswa_id)->first();
        $validated['jurusan_id'] = $siswas->jurusan_id;
        $validated['kelas_id'] = $siswas->kelas_id;

        Pelanggaran::create($validated);

        return redirect('/data-pelanggaran')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $gurus = Guru::latest()->get();
        $siswas = Siswa::latest()->get();
        $jenis = JenisPelanggaran::latest()->get();
        $pelanggarans = Pelanggaran::where('id', $id)->first();
        return view('admin.pelanggaran.edit', [
            'pelanggarans' => $pelanggarans,
            'jenis' => $jenis,
            'siswas' => $siswas,
            'gurus' => $gurus,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'guru_id' => 'required',
            'jenispelanggaran_id' => 'required',
            'namapelanggaran_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'bukti' => 'nullable|mimes:png,jpeg,jpg|max:10240',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'guru_id.required' => 'Guru wajib diisi',
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'namapelanggaran_id.required' => 'Nama Pelanggaran wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
            'status.required' => 'Status wajib diisi',
            'bukti.mimes' => 'Bukti harus berformat PNG, JPEG, atau JPG',
            'bukti.max' => 'Bukti harus maksimal 10 MB',
        ]);

        $siswas = Siswa::where('id', $request->siswa_id)->first();
        $validated['jurusan_id'] = $siswas->jurusan_id;
        $validated['kelas_id'] = $siswas->kelas_id;

        $pelanggarans = Pelanggaran::where('id', $id)->first();
        if ($request->file('bukti')) {
            if ($pelanggarans->bukti) {
                Storage::delete($pelanggarans->bukti);
            }
            $validated['bukti'] = $request->file('bukti')->store('bukti');
        } else {
            $validated['bukti'] = $pelanggarans->bukti;
        }

        $pelanggarans->update($validated);

        return redirect('/data-pelanggaran')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $pelanggarans = Pelanggaran::where('id', $id)->first();
        if ($pelanggarans->bukti) {
            Storage::delete($pelanggarans->bukti);
        }
        $pelanggarans->delete();
        return redirect('/data-pelanggaran')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

    public function jqueryNamaPelanggaran(Request $request)
    {
        $id_jenis = $request->id_jenis;

        $namas = NamaPelanggaran::where('jenispelanggaran_id', $id_jenis)->get();

        foreach ($namas as $data) {
            echo "<option value='$data->id'>$data->nama</option>";
        }
    }
}
