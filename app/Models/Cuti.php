<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cuti';
    protected $fillable = [
        'id_karyawan',
        'tgl_mulai',
        'tgl_selesai',
        'alasan',
        'keterangan',
        'durasi',
        'status'
    ];
}
