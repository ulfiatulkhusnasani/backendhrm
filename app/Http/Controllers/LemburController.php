<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    // Misalkan tarif lembur per jam adalah 20.000 IDR
    const TARIF_LEMBUR_PER_JAM = 20000; // Ubah dari 150000 menjadi 20000

    public function index()
    {
        $lembur = Lembur::all();
        return response()->json($lembur);
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tgl_lembur' => 'required|date',
        'jam_lembur' => 'required|date_format:H:i:s',
    ]);

    // Hitung jam lembur berdasarkan jam lembur yang diinput
    $jamLembur = $this->calculateOvertimeHours($request->jam_lembur);
    
    // Hitung total upah lembur
    $upah_lembur = $jamLembur * self::TARIF_LEMBUR_PER_JAM;

    // Simpan data lembur ke dalam database
    $lembur = Lembur::create([
        'id_karyawan' => $request->id_karyawan,
        'tgl_lembur' => $request->tgl_lembur,
        'jam_lembur' => $request->jam_lembur,
        'upah_lembur' => $upah_lembur, // Simpan upah lembur yang sudah dihitung
    ]);

    // Mengembalikan response JSON dengan status 201 Created
    return response()->json([
        'message' => 'Lembur berhasil ditambahkan',
        'data' => $lembur
    ], 201);
}

    // Fungsi untuk menghitung jam lembur
    private function calculateOvertimeHours($jamLembur)
    {
        // Konversi jam lembur yang diinput menjadi timestamp
        $lemburStart = strtotime($jamLembur);
        $lemburEnd = strtotime('20:00:00'); // Misalkan lembur dihitung setelah jam 20:00
        
        // Jika jam lembur lebih awal dari jam lembur standar, kita anggap 0 jam lembur
        if ($lemburStart < $lemburEnd) {
            return 0; // Tidak ada jam lembur
        }
        
        // Hitung durasi lembur dalam jam
        $durasiLembur = ($lemburStart - $lemburEnd) / 3600; // Menghitung dalam jam
        
        return $durasiLembur;
    }

    public function show($id)
    {
        $lembur = Lembur::findOrFail($id);
        return response()->json($lembur);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jam_lembur' => 'date_format:H:i:s',
            // Jika jam lembur diubah, hitung ulang upah lembur
        ]);

        $lembur = Lembur::findOrFail($id);
        
        if ($request->has('jam_lembur')) {
            $jamLembur = $this->calculateOvertimeHours($request->jam_lembur);
            $lembur->upah_lembur = $jamLembur * self::TARIF_LEMBUR_PER_JAM;
            $lembur->jam_lembur = $request->jam_lembur; // Update jam lembur
        }
        
        $lembur->save();

        return response()->json(['message' => 'Lembur berhasil diupdate', 'data' => $lembur]);
    }

    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->delete();

        return response()->json(['message' => 'Lembur berhasil dihapus']);
    }
}