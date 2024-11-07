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

        $dinas = DinasLuarKota::create($request->all());

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
        $dinas->update($request->all());

        return response()->json($dinas, 200);
    }

    // Menghapus data berdasarkan ID
    public function destroy($id)
    {
        DinasLuarKota::destroy($id);
        return response()->json(null, 204);
    }
}
