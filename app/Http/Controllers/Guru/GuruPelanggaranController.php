<?php

namespace App\Http\Controllers\Guru;

use App\Exports\PelanggaranExport;
use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\NamaPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GuruPelanggaranController extends Controller
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

        return view('guru.pelanggaran.index', [
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

    public function create()
    {
        $siswas = Siswa::latest()->get();
        $jenis = JenisPelanggaran::latest()->get();
        return view('guru.pelanggaran.create', [
            'jenis' => $jenis,
            'siswas' => $siswas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'jenispelanggaran_id' => 'required',
            'namapelanggaran_id' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'bukti' => 'nullable|mimes:png,jpeg,jpg|max:10240',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'namapelanggaran_id.required' => 'Nama Pelanggaran wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
            'tanggal.required' => 'Tanggal Pelanggaran wajib diisi',
            'bukti.mimes' => 'Bukti harus berformat PNG, JPEG, atau JPG',
            'bukti.max' => 'Bukti harus maksimal 10 MB',
        ]);

        if ($request->file('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti');
        } else {
            $validated['bukti'] = null;
        }

        $siswas = Siswa::where('id', $request->siswa_id)->first();
        $validated['jurusan_id'] = $siswas->jurusan_id;
        $validated['kelas_id'] = $siswas->kelas_id;
        $validated['guru_id'] = Auth::user()->guru_id;
        $validated['status'] = 'Proses';

        Pelanggaran::create($validated);

        return redirect('/guru-pelanggaran')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $siswas = Siswa::latest()->get();
        $jenis = JenisPelanggaran::latest()->get();
        $pelanggarans = Pelanggaran::where('id', $id)->first();
        return view('guru.pelanggaran.edit', [
            'pelanggarans' => $pelanggarans,
            'jenis' => $jenis,
            'siswas' => $siswas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'jenispelanggaran_id' => 'required',
            'namapelanggaran_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|mimes:png,jpeg,jpg|max:10240',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'jenispelanggaran_id.required' => 'Jenis Pelanggaran wajib diisi',
            'namapelanggaran_id.required' => 'Nama Pelanggaran wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
            'bukti.mimes' => 'Bukti harus berformat PNG, JPEG, atau JPG',
            'bukti.max' => 'Bukti harus maksimal 10 MB',
        ]);

        $siswas = Siswa::where('id', $request->siswa_id)->first();
        $validated['jurusan_id'] = $siswas->jurusan_id;
        $validated['kelas_id'] = $siswas->kelas_id;

        $pelanggarans = Pelanggaran::where('id', $id)->first();
        if ($request->file('bukti')) {
            if ($pelanggarans->bukti) {
                Storage::delete($pelanggarans->bukti);
            }
            $validated['bukti'] = $request->file('bukti')->store('bukti');
        } else {
            $validated['bukti'] = $pelanggarans->bukti;
        }

        $pelanggarans->update($validated);

        return redirect('/guru-pelanggaran')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $pelanggarans = Pelanggaran::where('id', $id)->first();
        if ($pelanggarans->bukti) {
            Storage::delete($pelanggarans->bukti);
        }
        $pelanggarans->delete();
        return redirect('/guru-pelanggaran')->with('success', 'Selamat ! Anda berhasil menghapus data');
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
