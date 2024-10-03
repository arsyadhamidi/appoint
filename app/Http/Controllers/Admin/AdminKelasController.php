<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua jurusan untuk ditampilkan di dropdown
        $jurusans = Jurusan::latest()->get();

        // Ambil nilai jurusan_id dari request
        $jurusan_id = $request->input('jurusan_id');

        // Filter kelas berdasarkan jurusan_id jika ada
        $kelas = Kelas::with('jurusan')
            ->when($jurusan_id, function ($query, $jurusan_id) {
                return $query->where('jurusan_id', $jurusan_id);
            })
            ->latest()
            ->get();

        return view('admin.kelas.index', [
            'kelas' => $kelas,
            'jurusans' => $jurusans,
        ]);
    }

    public function create()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.kelas.create', [
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required',
            'kelas' => 'required',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',
            'kelas.required' => 'Kelas wajib diisi',
        ]);

        Kelas::create([
            'jurusan_id' => $request->jurusan_id ?? '-',
            'kelas' => $request->kelas ?? '-',
        ]);

        return redirect('data-kelas')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $jurusans = Jurusan::latest()->get();
        $kelas = Kelas::find($id);
        return view('admin.kelas.edit', [
            'jurusans' => $jurusans,
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jurusan_id' => 'required',
            'kelas' => 'required',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',
            'kelas.required' => 'Kelas wajib diisi',
        ]);

        Kelas::where('id', $id)->update([
            'jurusan_id' => $request->jurusan_id ?? '-',
            'kelas' => $request->kelas ?? '-',
        ]);

        return redirect('data-kelas')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        Kelas::where('id', $id)->delete();

        return redirect('data-kelas')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
