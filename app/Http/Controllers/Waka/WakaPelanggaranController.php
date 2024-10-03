<?php

namespace App\Http\Controllers\Waka;

use App\Exports\PelanggaranExport;
use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\NamaPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class WakaPelanggaranController extends Controller
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
        $pelanggarans = $pelanggarans->where('guru_id', Auth::user()->guru_id)->latest()->get();

        return view('waka.pelanggaran.index', [
            'pelanggarans' => $pelanggarans,
            'jurusans' => $jurusans,
            'jenis' => $jenis,
        ]);
    }

    public function generateexcel()
    {
        $data = Pelanggaran::where('guru_id', Auth()->user()->guru_id)->orderBy('id', 'desc')->get();

        return Excel::download(new PelanggaranExport($data), 'data-pelanggaran.xlsx');
    }

    public function jqueryNamaPelanggaran(Request $request)
    {
        $id_jenis = $request->id_jenis;

        $namas = NamaPelanggaran::where('jenispelanggaran_id', $id_jenis)->get();

        foreach ($namas as $data) {
            echo "<option value='$data->id'>$data->nama</option>";
        }
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
