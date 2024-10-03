<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaPelanggaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenispelanggaran_id');
    }
}
