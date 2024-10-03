<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;

class SiswaPelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::query();

        // Mengambil semua data pelanggaran setelah filter
        $pelanggarans = $pelanggarans->where('siswa_id', Auth::user()->siswa_id)->latest()->get();

        return view('siswa.pelanggaran.index', [
            'pelanggarans' => $pelanggarans,
        ]);
    }
}
