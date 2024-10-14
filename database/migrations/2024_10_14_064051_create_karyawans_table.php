<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->string('nip')->unique();   // Pastikan kolom 'nip' ada dan unique
            $table->string('nik')->unique();   // Menambahkan kolom NIK
            $table->string('email')->unique();
            $table->string('no_handphone');
            $table->string('alamat');
            $table->string('jabatan');         // Menambahkan kolom Jabatan
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
}