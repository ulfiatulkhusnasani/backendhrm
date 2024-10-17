<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_karyawan',
        'nip',             // Ganti nik menjadi nip
        'nik',             // Menambahkan kolom NIK
        'email',
        'no_handphone',
        'alamat',
        'password',
    ];
}