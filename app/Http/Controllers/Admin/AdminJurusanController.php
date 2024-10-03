<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminJurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.jurusan.index', [
            'jurusans' => $jurusans,
        ]);
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodejurusan' => 'required|unique:jurusans,kodejurusan',
            'namajurusan' => 'required',
        ], [
            'kodejurusan.required' => 'Kode Jurusan wajib diisi',
            'namajurusan.required' => 'Nama Jurusan wajib diisi',
            'kodejurusan.unique' => 'Kode Jurusan sudah tersedia',
        ]);

        Jurusan::create($validated);

        return redirect('data-jurusan')->with('success', 'Selamat! Anda berhasil menambahkan Data');
    }

    public function edit($id)
    {
        $jurusans = Jurusan::find($id);
        return view('admin.jurusan.edit', [
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kodejurusan' => 'required|unique:jurusans,kodejurusan',
            'namajurusan' => 'required',
        ], [
            'kodejurusan.required' => 'Kode Jurusan wajib diisi',
            'namajurusan.required' => 'Nama Jurusan wajib diisi',
            'kodejurusan.unique' => 'Kode Jurusan sudah tersedia',
        ]);

        Jurusan::where('id', $id)->update($validated);

        return redirect('data-jurusan')->with('success', 'Selamat! Anda berhasil memperbaharui Data');
    }

    public function destroy($id)
    {
        $jurusans = Jurusan::find($id);
        $jurusans->delete();
        return redirect('data-jurusan')->with('success', 'Selamat! Anda berhasil menghapus Data');
    }

}
