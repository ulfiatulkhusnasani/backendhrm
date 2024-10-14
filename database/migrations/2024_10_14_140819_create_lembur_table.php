<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburTable extends Migration
{
    public function up()
    {
        Schema::create('lembur', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('id_karyawan') // Foreign key ke tabel karyawan
                ->constrained('karyawans')
                ->onDelete('cascade');
            $table->date('tgl_lembur'); // Tanggal lembur
            $table->time('jam_lembur'); // Waktu lembur
            $table->decimal('upah_lembur', 10, 2); // Upah lembur
            $table->timestamps(); // Created at dan updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}