<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel absensi di database
    protected $table = 'absensi';
    
    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'nama',      // Nama yang melakukan absensi
        'tanggal',   // Tanggal absensi
        'time_in',   // Waktu masuk
        'time_out',  // Waktu keluar
        'status'     // Status absensi (Terlambat, Tepat waktu)
    ];
}
