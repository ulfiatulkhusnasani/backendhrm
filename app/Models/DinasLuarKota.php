<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasLuarKota extends Model
{
    protected $table = 'dinas_luarkota';

    protected $fillable = [
        'id_karyawan',
        'tgl_berangkat',
        'tgl_kembali',
        'kota_tujuan',
        'keperluan',
        'biaya_transport',
        'biaya_penginapan',
        'uang_harian',
        'total_biaya',
    ];

    public $timestamps = true;

    // Accessor untuk memformat biaya transport
    public function getBiayaTransportAttribute($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }

    // Accessor untuk memformat biaya penginapan
    public function getBiayaPenginapanAttribute($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }

    // Accessor untuk memformat uang harian
    public function getUangHarianAttribute($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }

    // Accessor untuk memformat total biaya
    public function getTotalBiayaAttribute($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }
}
