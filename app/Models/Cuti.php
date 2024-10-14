<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';
    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'durasi',
        'tanggal_mulai', 
        'tanggal_selesai', 
        'keterangan', 
        'status'
    ];
}