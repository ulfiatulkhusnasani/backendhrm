<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Validation\ValidationException;

class AbsensiController extends Controller
{
    // Menampilkan semua data absensi
    public function index()
    {
        try {
            $absensis = Absensi::all();
            return response()->json($absensis, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menyimpan absensi baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'time_in' => 'nullable|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i|after:time_in',
                'status' => 'required|string|in:Terlambat,Tepat waktu',
            ]);

            $absensi = Absensi::create($validatedData);

            return response()->json([
                'message' => 'Absensi berhasil disimpan',
                'data' => $absensi
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data gagal disimpan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menampilkan detail absensi berdasarkan ID
    public function show($id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
            return response()->json($absensi, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Absensi tidak ditemukan',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // Memperbarui data absensi
    public function update(Request $request, $id)
    {
        try {
            $absensi = Absensi::findOrFail($id);

            $validatedData = $request->validate([
                'nama' => 'string|max:255',
                'tanggal' => 'date',
                'time_in' => 'nullable|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i|after:time_in',
                'status' => 'string|in:Terlambat,Tepat waktu',
            ]);

            $absensi->update($validatedData);
            return response()->json([
                'message' => 'Absensi berhasil diperbarui',
                'data' => $absensi
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data gagal diperbarui',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menghapus data absensi
    public function destroy($id)
    {
        try {
            Absensi::destroy($id);
            return response()->json([
                'message' => 'Absensi berhasil dihapus',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
