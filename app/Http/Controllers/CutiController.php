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
        // Validasi input request
        $request->validate([
            'id_karyawan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'alasan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'durasi' => 'required|numeric',
            'status' => 'required|in:disetujui,ditolak',
        ]);

        // Menghitung durasi secara otomatis jika tidak diberikan
        if (!$request->has('durasi')) {
            $request->merge([
                'durasi' => (new \Carbon\Carbon($request->tgl_selesai))->diffInDays(new \Carbon\Carbon($request->tgl_mulai)) + 1
            ]);
        }

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
        // Validasi input request
        $request->validate([
            'id_karyawan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'alasan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'durasi' => 'required|numeric',
            'status' => 'required|in:disetujui,ditolak',
        ]);

        // Menghitung durasi secara otomatis jika tidak diberikan
        if (!$request->has('durasi')) {
            $request->merge([
                'durasi' => (new \Carbon\Carbon($request->tgl_selesai))->diffInDays(new \Carbon\Carbon($request->tgl_mulai)) + 1
            ]);
        }

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
