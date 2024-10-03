<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id');
            $table->foreignId('jurusan_id');
            $table->foreignId('kelas_id');
            $table->foreignId('guru_id');
            $table->foreignId('jenispelanggaran_id');
            $table->foreignId('namapelanggaran_id');
            $table->date('tanggal');
            $table->longText('keterangan');
            $table->string('status');
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
