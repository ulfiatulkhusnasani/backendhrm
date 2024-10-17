<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::all();
        return response()->json($cuti, 200); // Mengembalikan semua data cuti sebagai JSON
    }

    public function store(Request $request)
{
    $request->validate([
        'id_karyawan' => 'required',
        'nama_karyawan' => 'required',
        'durasi' => 'required',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
        'keterangan' => 'required',
        'status' => 'required',
    ]);

    $cuti = Cuti::create($request->all());

    return response()->json([
        'message' => 'Cuti berhasil ditambahkan.',
        'data' => $cuti
    ], 201);
}

    public function show($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti) {
            return response()->json($cuti, 200); // Mengembalikan detail cuti
        } else {
            return response()->json(['message' => 'Cuti tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required',
            'nama_karyawan' => 'required',
            'durasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'keterangan' => 'required',
            'status' => 'required',
        ]);

        $cuti = Cuti::find($id);
        if ($cuti) {
            $cuti->update($request->all());
            return response()->json([
                'message' => 'Cuti berhasil diupdate.',
                'data' => $cuti
            ], 200);
        } else {
            return response()->json(['message' => 'Cuti tidak ditemukan.'], 404);
        }
    }

    public function destroy($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti) {
            $cuti->delete();
            return response()->json(['message' => 'Cuti berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Cuti tidak ditemukan.'], 404);
        }
    }
}