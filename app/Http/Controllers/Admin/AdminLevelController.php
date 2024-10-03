<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class AdminLevelController extends Controller
{
    public function index(Request $request)
    {
        $levels = Level::latest()->get();
        return view('admin.level.index', [
            'levels' => $levels,
        ]);
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namalevel' => 'required',
        ], [
            'namalevel.required' => 'Status Autentikas wajib diisi',
        ]);

        $levels = Level::count();
        $totLevel = $levels + 1;

        Level::create([
            'namalevel' => $request->namalevel,
            'idlevel' => $totLevel,
        ]);

        return redirect('/data-level')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $levels = Level::find($id);
        return view('admin.level.edit', [
            'levels' => $levels,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namalevel' => 'required',
        ], [
            'namalevel.required' => 'Status Autentikas wajib diisi',
        ]);

        Level::where('id', $id)->update([
            'namalevel' => $request->namalevel,
        ]);

        return redirect('/data-level')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $levels = Level::find($id);
        $levels->delete();
        return redirect('/data-level')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
