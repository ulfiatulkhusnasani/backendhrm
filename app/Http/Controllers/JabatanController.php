<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    // Menampilkan semua data jabatan
    public function index()
    {
        $jabatan = Jabatan::all();
        return response()->json($jabatan);
    }

    // Menyimpan data jabatan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jabatan' => 'required|string',
            'gaji_pokok' => 'required|numeric',
        ]);

        // Simpan data jabatan ke database
        $jabatan = Jabatan::create([
            'jabatan' => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
        ]);

        // Response JSON dengan status 201 Created
        return response()->json([
            'message' => 'Jabatan berhasil ditambahkan',
            'data' => $jabatan
        ], 201);
    }

    // Menampilkan data jabatan berdasarkan ID
    public function show($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return response()->json($jabatan);
    }

    // Memperbarui data jabatan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jabatan' => 'string|max:255',
            'gaji_pokok' => 'numeric|min:0',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->only('jabatan', 'gaji_pokok'));

        return response()->json(['message' => 'Jabatan berhasil diupdate', 'data' => $jabatan]);
    }

    // Menghapus data jabatan
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json(['message' => 'Jabatan berhasil dihapus']);
    }
}
