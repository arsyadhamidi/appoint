<?php

namespace App\Http\Controllers\Waka;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class WakaJenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenis = JenisPelanggaran::latest()->get();
        return view('waka.jenis-pelanggaran.index', [
            'jenis' => $jenis,
        ]);
    }

    public function create()
    {
        return view('waka.jenis-pelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenispelanggaran' => 'required',
        ], [
            'jenispelanggaran.required' => 'Jenis Pelanggaran wajib diisi',
        ]);

        JenisPelanggaran::create($validated);

        return redirect('/waka-jenispelanggaran')->with('success', 'Selamat | Anda berhasil menambahkan data jenis pelanggaran');
    }

    public function edit($id)
    {
        $jenis = JenisPelanggaran::find($id);
        return view('waka.jenis-pelanggaran.edit', [
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

        return redirect('/waka-jenispelanggaran')->with('success', 'Selamat | Anda berhasil memperbaharui data jenis pelanggaran');
    }

    public function destroy($id)
    {
        JenisPelanggaran::where('id', $id)->delete();

        return redirect('/waka-jenispelanggaran')->with('success', 'Selamat | Anda berhasil menghapus data jenis pelanggaran');
    }
}
