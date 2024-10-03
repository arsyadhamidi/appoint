<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class AdminJenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenis = JenisPelanggaran::latest()->get();
        return view('admin.jenis-pelanggaran.index', [
            'jenis' => $jenis,
        ]);
    }

    public function create()
    {
        return view('admin.jenis-pelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenispelanggaran' => 'required',
        ], [
            'jenispelanggaran.required' => 'Jenis Pelanggaran wajib diisi',
        ]);

        JenisPelanggaran::create($validated);

        return redirect('/data-jenispelanggaran')->with('success', 'Selamat | Anda berhasil menambahkan data jenis pelanggaran');
    }

    public function edit($id)
    {
        $jenis = JenisPelanggaran::find($id);
        return view('admin.jenis-pelanggaran.edit', [
            'jenis' => $jenis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenispelanggaran' => 'required',
        ], [
            'jenispelanggaran.required' => 'Jenis Pelanggaran wajib diisi',
        ]);

        JenisPelanggaran::where('id', $id)->update($validated);

        return redirect('/data-jenispelanggaran')->with('success', 'Selamat | Anda berhasil memperbaharui data jenis pelanggaran');
    }

    public function destroy($id)
    {
        JenisPelanggaran::where('id', $id)->delete();

        return redirect('/data-jenispelanggaran')->with('success', 'Selamat | Anda berhasil menghapus data jenis pelanggaran');
    }
}
