<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanTable extends Migration
{
    public function up()
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id(); // Primary key, id_jabatan
            $table->string('jabatan'); // Jabatan karyawan
            $table->decimal('gaji_pokok', 10, 2); // Gaji pokok karyawan
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('jabatan');
    }
}
