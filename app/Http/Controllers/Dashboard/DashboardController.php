<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JenisPelanggaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Level;
use App\Models\NamaPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $dataPelanggaran = Pelanggaran::select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(tanggal) as month"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("MONTH(tanggal)"))
            ->pluck('count', 'month');

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = isset($dataPelanggaran[$i]) ? $dataPelanggaran[$i] : 0;
        }

        // Data lainnya
        $levelAdmins = Level::count();
        $usersAdmins = User::count();
        $jurusanAdmins = Jurusan::count();
        $kelasAdmins = Kelas::count();
        $guruAdmins = Guru::count();
        $siswaAdmins = Siswa::count();
        $jenisAdmins = JenisPelanggaran::count();
        $namaAdmins = NamaPelanggaran::count();
        $pelanggaranAdmins = Pelanggaran::count();

        // Guru
        $namaGurus = NamaPelanggaran::latest()->get();

        return view('admin.dashboard.index', [
            'data' => $data,
            'bulan' => $bulan,
            'levelAdmins' => $levelAdmins,
            'usersAdmins' => $usersAdmins,
            'jurusanAdmins' => $jurusanAdmins,
            'kelasAdmins' => $kelasAdmins,
            'guruAdmins' => $guruAdmins,
            'siswaAdmins' => $siswaAdmins,
            'jenisAdmins' => $jenisAdmins,
            'namaAdmins' => $namaAdmins,
            'pelanggaranAdmins' => $pelanggaranAdmins,

            'namaGurus' => $namaGurus,
        ]);
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
