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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama'); // Nama Karyawan
            $table->date('tanggal'); // Tanggal Absensi
            $table->time('time_in')->nullable(); // Waktu masuk (null jika belum absen)
            $table->time('time_out')->nullable(); // Waktu keluar (null jika belum absen keluar)
            $table->string('status'); // Status Kehadiran (Hadir, Izin, Sakit, Alpa)
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}; 
