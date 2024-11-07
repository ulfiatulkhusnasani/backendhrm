<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan semua data absensi
    public function index()
    {
        try {
            $absensis = Absensi::all()->map(function ($absensi) {
                $absensi->tanggal = Carbon::parse($absensi->tanggal)->format('d-m-Y');
                return $absensi;
            });
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
            // Validasi input
            $validated = $request->validate([
                'id_karyawan' => 'required|exists:karyawans,id',
                'tanggal' => 'required|date',
                'jam_masuk' => 'required|date_format:H:i',
                'foto_masuk' => 'required|string', // Ubah ke string jika tidak perlu URL
                'latitude_masuk' => 'required|numeric',
                'longitude_masuk' => 'required|numeric',
                'status' => 'required|string|max:255',
            ]);            

            // Format tanggal untuk disimpan ke database
            $validated['tanggal'] = Carbon::parse($validated['tanggal'])->format('Y-m-d');
            $absensi = Absensi::create($validated);

            // Ubah format tanggal sebelum dikirimkan sebagai respons
            $absensi->tanggal = Carbon::parse($absensi->tanggal)->format('d-m-Y');

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
            $absensi->tanggal = Carbon::parse($absensi->tanggal)->format('d-m-Y');
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
                'id_karyawan' => 'exists:karyawans,id',
                'tanggal' => 'date',
                'jam_masuk' => 'nullable|date_format:H:i',
                'foto_masuk' => 'nullable|string',
                'latitude_masuk' => 'nullable|numeric',
                'longitude_masuk' => 'nullable|numeric',
                'status' => 'string|in:Terlambat,Tepat waktu',
            ]);

            if (isset($validatedData['tanggal'])) {
                // Format tanggal sebelum update
                $validatedData['tanggal'] = Carbon::parse($validatedData['tanggal'])->format('Y-m-d');
            }

            $absensi->update($validatedData);

            // Format ulang tanggal untuk respons
            $absensi->tanggal = Carbon::parse($absensi->tanggal)->format('d-m-Y');

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
