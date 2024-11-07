<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDinasLuarKotaTable extends Migration
{
    public function up()
    {
        Schema::create('dinas_luarkota', function (Blueprint $table) {
            $table->unsignedInteger('id_karyawan')->primary(); // Primary key sesuai SQL
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->string('kota_tujuan', 100); // Sesuaikan dengan varchar(100)
            $table->text('keperluan'); // Menggunakan text sesuai dengan SQL
            $table->decimal('biaya_transport', 15, 2);
            $table->decimal('biaya_penginapan', 15, 2);
            $table->decimal('uang_harian', 15, 2);
            $table->timestamps(0); // Untuk created_at dan updated_at tanpa zona waktu
        });

        // Menambahkan kolom 'total_biaya' sebagai Generated Column
        DB::statement('ALTER TABLE dinas_luarkota ADD total_biaya DECIMAL(15,2) GENERATED ALWAYS AS (((biaya_transport + biaya_penginapan) + uang_harian)) STORED');
    }

    public function down()
    {
        Schema::dropIfExists('dinas_luarkota');
    }
}