<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelanggaranExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Map data to include country name
        return $this->data->map(function ($item) {
            return [
                'id' => $item->id,
                'siswa_id' => $item->siswa->nama,
                'jurusan' => $item->jurusan->namajurusan,
                'kelas' => $item->kelas->kelas,
                'guru' => $item->guru->nama,
                'jenispelanggaran' => $item->jenis->jenispelanggaran,
                'namapelanggaran' => $item->nama->nama,
                'point' => $item->nama->point,
                'sanksi' => $item->nama->sanksi,
                'tanggal' => $item->tanggal,
                'keterangan' => $item->keterangan,
                'status' => $item->status,
                'bukti' => $item->bukti,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Siswa',
            'Jurusan',
            'Kelas',
            'Guru',
            'Jenis Pelanggaran',
            'Nama Pelanggaran',
            'Point',
            'Sanksi',
            'Tanggal',
            'Keterangan',
            'Status',
            'Bukti',
        ];
    }
}
