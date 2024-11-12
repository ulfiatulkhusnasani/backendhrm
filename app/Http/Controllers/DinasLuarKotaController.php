<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DinasLuarKota;

class DinasLuarKotaController extends Controller
{
    // Menampilkan semua data dinas luar kota
    public function index()
    {
        $dinasLuarKota = DinasLuarKota::all();
        return response()->json($dinasLuarKota);
    }

    // Menambahkan data baru
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|integer',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date',
            'kota_tujuan' => 'required|string|max:100',
            'keperluan' => 'required|string',
            'biaya_transport' => 'required|numeric',
            'biaya_penginapan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        $totalBiaya = $request->biaya_transport + $request->biaya_penginapan + $request->uang_harian;

        $dinas = DinasLuarKota::create([
            'id_karyawan' => $request->id_karyawan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'kota_tujuan' => $request->kota_tujuan,
            'keperluan' => $request->keperluan,
            'biaya_transport' => $request->biaya_transport,
            'biaya_penginapan' => $request->biaya_penginapan,
            'uang_harian' => $request->uang_harian,
            'total_biaya' => $totalBiaya,
        ]);

        return response()->json($dinas, 201);
    }

    // Mengambil data berdasarkan ID
    public function show($id)
    {
        $dinas = DinasLuarKota::findOrFail($id);
        return response()->json($dinas);
    }

    // Memperbarui data berdasarkan ID
    public function update(Request $request, $id)
    {
        $dinas = DinasLuarKota::findOrFail($id);

        $request->validate([
            'id_karyawan' => 'required|integer',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date',
            'kota_tujuan' => 'required|string|max:100',
            'keperluan' => 'required|string',
            'biaya_transport' => 'required|numeric',
            'biaya_penginapan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        $totalBiaya = $request->biaya_transport + $request->biaya_penginapan + $request->uang_harian;

        $dinas->update([
            'id_karyawan' => $request->id_karyawan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'kota_tujuan' => $request->kota_tujuan,
            'keperluan' => $request->keperluan,
            'biaya_transport' => $request->biaya_transport,
            'biaya_penginapan' => $request->biaya_penginapan,
            'uang_harian' => $request->uang_harian,
            'total_biaya' => $totalBiaya,
        ]);

        return response()->json($dinas, 200);
    }

    // Menghapus data berdasarkan ID
    public function destroy($id)
    {
        $dinas = DinasLuarKota::findOrFail($id);
        $dinas->delete();

        return response()->json(null, 204);
    }
}
