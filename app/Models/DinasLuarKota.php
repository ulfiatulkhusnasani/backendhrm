<?php

namespace App\Http\Controllers;

use App\Models\DinasLuarKota;
use Illuminate\Http\Request;

class DinasLuarKotaController extends Controller
{
    public function index()
    {
        $dinasLuarKota = DinasLuarKota::with('karyawan')->get(); // Memuat karyawan yang terkait
        return response()->json($dinasLuarKota);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_berangkat',
            'kota_tujuan' => 'required|string',
            'keperluan' => 'required|string',
            'biaya_transport' => 'required|numeric',
            'biaya_penginapan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        // Hitung total biaya
        $totalBiaya = $request->biaya_transport + $request->biaya_penginapan + ($request->uang_harian * $this->calculateDays($request->tgl_berangkat, $request->tgl_kembali));

        // Simpan data dinas luar kota ke dalam database
        $dinasLuarKota = DinasLuarKota::create([
            'id_karyawan' => $request->id_karyawan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'kota_tujuan' => $request->kota_tujuan,
            'keperluan' => $request->keperluan,
            'biaya_transport' => $request->biaya_transport,
            'biaya_penginapan' => $request->biaya_penginapan,
            'uang_harian' => $request->uang_harian,
            'total_biaya' => $totalBiaya, // Simpan total biaya yang sudah dihitung
        ]);

        return response()->json(['message' => 'Dinas luar kota berhasil ditambahkan', 'data' => $dinasLuarKota], 201);
    }

    // Fungsi untuk menghitung jumlah hari antara dua tanggal
    private function calculateDays($startDate, $endDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        return $end->diffInDays($start);
    }

    public function show($id)
    {
        $dinasLuarKota = DinasLuarKota::findOrFail($id);
        return response()->json($dinasLuarKota);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tgl_berangkat' => 'date',
            'tgl_kembali' => 'date|after_or_equal:tgl_berangkat',
            'kota_tujuan' => 'string',
            'keperluan' => 'string',
            'biaya_transport' => 'numeric',
            'biaya_penginapan' => 'numeric',
            'uang_harian' => 'numeric',
        ]);

        $dinasLuarKota = DinasLuarKota::findOrFail($id);
        
        // Update data dinas luar kota
        if ($request->has('tgl_berangkat') || $request->has('tgl_kembali') || $request->has('biaya_transport') || $request->has('biaya_penginapan') || $request->has('uang_harian')) {
            // Hitung ulang total biaya jika ada perubahan
            $dinasLuarKota->tgl_berangkat = $request->tgl_berangkat ?? $dinasLuarKota->tgl_berangkat;
            $dinasLuarKota->tgl_kembali = $request->tgl_kembali ?? $dinasLuarKota->tgl_kembali;
            $dinasLuarKota->biaya_transport = $request->biaya_transport ?? $dinasLuarKota->biaya_transport;
            $dinasLuarKota->biaya_penginapan = $request->biaya_penginapan ?? $dinasLuarKota->biaya_penginapan;
            $dinasLuarKota->uang_harian = $request->uang_harian ?? $dinasLuarKota->uang_harian;

            // Hitung total biaya
            $totalBiaya = $dinasLuarKota->biaya_transport + $dinasLuarKota->biaya_penginapan + ($dinasLuarKota->uang_harian * $this->calculateDays($dinasLuarKota->tgl_berangkat, $dinasLuarKota->tgl_kembali));
            $dinasLuarKota->total_biaya = $totalBiaya; // Update total biaya
        }
        
        $dinasLuarKota->save();

        return response()->json(['message' => 'Dinas luar kota berhasil diupdate', 'data' => $dinasLuarKota]);
    }

    public function destroy($id)
    {
        $dinasLuarKota = DinasLuarKota::findOrFail($id);
        $dinasLuarKota->delete();

        return response()->json(['message' => 'Dinas luar kota berhasil dihapus']);
    }
}