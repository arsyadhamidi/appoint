<?php

namespace App\Http\Controllers\Waka;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\NamaPelanggaran;
use Illuminate\Http\Request;

class WakaNamaPelanggaranController extends Controller
{
    public function index()
    {
        $nama = NamaPelanggaran::latest()->get();
        return view('waka.nama-pelanggaran.index', [
            'nama' => $nama,
        ]);
    }

    public function create()
    {
        $jenis = JenisPelanggaran::all();
        return view('waka.nama-pelanggaran.create', [
            'jenis' => $jenis,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenispelanggaran_id' => 'required',
            'nama' => 'required',
            'point' => 'required',
            'sanksi' => 'required',
        ], [
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'nama.required' => 'Nama Pelanggaran wajib diisi',
            'point.required' => 'Point wajib diisi',
            'sanksi' => 'Sanksi wajib diisi',
        ]);

        NamaPelanggaran::create($validated);

        return redirect('waka-namapelanggaran')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $nama = NamaPelanggaran::where('id', $id)->first();
        return view('waka.nama-pelanggaran.edit', [
            'nama' => $nama,
            'jenis' => JenisPelanggaran::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenispelanggaran_id' => 'required',
            'nama' => 'required',
            'point' => 'required',
            'sanksi' => 'required',
        ], [
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'nama.required' => 'Nama Pelanggaran wajib diisi',
            'point.required' => 'Point wajib diisi',
            'sanksi' => 'Sanksi wajib diisi',
        ]);

        NamaPelanggaran::where('id', $id)->update($validated);

        return redirect('waka-namapelanggaran')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        NamaPelanggaran::where('id', $id)->delete();

        return redirect('waka-namapelanggaran')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
