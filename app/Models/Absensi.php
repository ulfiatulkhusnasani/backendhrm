<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai di database
    protected $table = 'absensi';

    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'id_karyawan',
        'tanggal',
        'jam_masuk',
        'foto_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'status'
    ];

    // Accessor untuk format tanggal
    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
