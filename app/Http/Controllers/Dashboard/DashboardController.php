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
use Illuminate\Support\Facades\Storage;

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
        ]);
    }

    // Siswa
    public function editbiodatasiswa($id)
    {
        $siswas = Siswa::where('id', $id)->first();
        $jurusans = Jurusan::latest()->get();
        return view('siswa.edit-biodata', [
            'siswas' => $siswas,
            'jurusans' => $jurusans,
        ]);
    }

    public function updatesiswa(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nisn' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telp_ortu' => 'required|max:255',
            'alamat' => 'required|max:255',
            'foto_siswa' => 'nullable|mimes:png,jpg,jpeg|max:10240',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi.',
            'kelas_id.required' => 'Kelas wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.max' => 'NISN tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tmp_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Format Tanggal Lahir tidak valid.',
            'jk.required' => 'Jenis Kelamin wajib diisi.',
            'jk.max' => 'Jenis Kelamin tidak boleh lebih dari 255 karakter.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'telp_ortu.required' => 'Nomor Telepon Orang Tua wajib diisi.',
            'telp_ortu.max' => 'Nomor Telepon Orang Tua tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'foto_siswa.mimes' => 'Foto harus berupa file dengan format png, jpg, atau jpeg.',
            'foto_siswa.max' => 'Ukuran Foto tidak boleh lebih dari 10MB.',
        ]);

        $siswas = Siswa::where('id', $id)->first();
        if ($request->file('foto_siswa')) {
            if ($siswas->foto_siswa) {
                Storage::delete($siswas->foto_siswa);
            }
            $validated['foto_siswa'] = $request->file('foto_siswa')->store('foto_siswa');
        } else {
            $validated['foto_siswa'] = $siswas->foto_siswa;
        }

        $siswas->update($validated);

        return redirect('/dashboard')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
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
