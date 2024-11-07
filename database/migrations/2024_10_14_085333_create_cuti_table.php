<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('alasan'); // Kolom alasan untuk menyimpan alasan cuti
            $table->string('keterangan'); // Kolom keterangan
            $table->integer('durasi'); // Durasi dalam hitungan hari
            $table->enum('status', ['disetujui', 'ditolak'])->default('disetujui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
