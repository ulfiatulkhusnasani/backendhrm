<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinasLuarKotaTable extends Migration
{
    public function up()
    {
        Schema::create('dinas_luarkota', function (Blueprint $table) {
            $table->id(); // Menggunakan kolom ID sebagai primary key auto-increment
            $table->unsignedInteger('id_karyawan'); 
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->string('kota_tujuan', 100);
            $table->text('keperluan');
            $table->decimal('biaya_transport', 15, 2);
            $table->decimal('biaya_penginapan', 15, 2);
            $table->decimal('uang_harian', 15, 2);
            $table->decimal('total_biaya', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dinas_luarkota');
    }
}
