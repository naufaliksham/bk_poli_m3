<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\Poli;
use App\Models\JadwalPeriksa;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function dashboard()
    {
        return view('pasien.dashboard');
    }

    public function poliklinik()
{
    // Ambil semua jadwal periksa
    $jadwalPeriksas = JadwalPeriksa::all();

    // Inisialisasi array untuk menyimpan nomor urut
    $urutanPerId = [];

    // Iterasi setiap jadwal periksa
    foreach ($jadwalPeriksas as $jadwalPeriksa) {
        // Ambil ID JadwalPeriksa
        $idJadwalPeriksa = $jadwalPeriksa->id;

        // Jika ID belum ada dalam array, tambahkan dan set urutan ke 1
        if (!isset($urutanPerId[$idJadwalPeriksa])) {
            $urutanPerId[$idJadwalPeriksa] = 1;
        } else {
            // Jika ID sudah ada dalam array, tambahkan urutan
            $urutanPerId[$idJadwalPeriksa]++;
        }

        // Set nomor urut ke model JadwalPeriksa
        $jadwalPeriksa->nomor_urut = $urutanPerId[$idJadwalPeriksa];
    }
    $jadwalPeriksas = $jadwalPeriksas->sortByDesc('hari');

    $namaPasien = Auth::user()->nama;
    $pasien = Pasien::where('nama', $namaPasien)->first();

    if ($pasien) {
        // Ambil data DaftarPoli berdasarkan id_pasien
        $daftarPolis = DaftarPoli::where('id_pasien', $pasien->id)->orderBy('no_antrian', 'desc')->first();
        // dd($daftarPolis);
        // Kirim data ke view
        return view('pasien.poliklinik', compact('jadwalPeriksas', 'daftarPolis'));
    } else {
        // Handle jika pasien tidak ditemukan
        return redirect()->back()->with('error', 'Antrian tidak ditemukan.');
    }
}


    public function addDaftarPoli(Request $request)
    {
        // Validasi permintaan
        $validatedData = $request->validate([
            'jadwal_periksa' => 'required',
            'keluhan' => 'required',
        ]);
    
        // Ambil jumlah entri DaftarPoli dengan ID jadwal yang sama
        $countEntries = DaftarPoli::where('id_jadwal', $validatedData['jadwal_periksa'])->count();
    
        // Cari pasien berdasarkan nama
        $namaPasien = Auth::user()->nama;
        $pasien = Pasien::where('nama', $namaPasien)->first();
    
        if ($pasien) {
            $id_pasien = $pasien->id;
    
            // Masukkan data ke database menggunakan model DaftarPoli
            DaftarPoli::create([
                'id_pasien' => $id_pasien,
                'id_jadwal' => $validatedData['jadwal_periksa'],
                'keluhan' => $validatedData['keluhan'],
                'no_antrian' => $countEntries + 1,
            ]);
    
            // Redirect atau lakukan apa pun yang Anda inginkan setelah membuat catatan
            return redirect()->route('pasien-poliklinik')->with('success', 'Berhasil mendaftar antrean!');
        } else {
            // Handle jika pasien tidak ditemukan
            return redirect()->back()->with('error', 'Pasien tidak ditemukan.');
        }
    }
    
    public function pilihpoli()
    {
        // Ambil semua jadwal periksa
        $jadwalPeriksas = JadwalPeriksa::all();
    
        // Inisialisasi array untuk menyimpan nama_poli unik
        $uniquePoliNames = [];
    
        // Iterasi setiap jadwal periksa
        foreach ($jadwalPeriksas as $jadwalPeriksa) {
            // Ambil nama_poli dari relasi dokter
            $namaPoli = $jadwalPeriksa->dokter;
    
            // Jika nama_poli belum ada dalam array, tambahkan dan tampilkan
            if (!in_array($namaPoli, $uniquePoliNames)) {
                $uniquePoliNames[] = $namaPoli;
            }
        }
        // dd($uniquePoliNames);
        // Kirim data ke view
        return view('pasien.pilihpoli', compact('uniquePoliNames'));
    }

    public function politerpilih(Request $request)
    {
        $request->validate([
            'poliName' => 'required',
        ]);
    
        // Ambil semua jadwal periksa
        $jadwalPeriksas = JadwalPeriksa::all();
    
        // Array untuk menyimpan jadwal yang sesuai dengan kriteria
        $jadwal = [];
    
        // Looping setiap jadwal periksa
        foreach ($jadwalPeriksas as $jp) {
            // Ubah objek JSON menjadi array
            $poliNameArray = json_decode($request->poliName, true);
    
            // Cek apakah id_dokter dan id_poli sesuai dengan request
            if ($poliNameArray['id'] == $jp->id_dokter && $poliNameArray['id_poli'] == $jp->dokter->id_poli) {
                // Tambahkan parameter id_poli ke dalam array $jp
                $jp->id_poli = $poliNameArray['id_poli'];
    
                // Masukkan $jp ke dalam array $jadwal
                $jadwal[] = $jp;
            }
        }
    
        // dd($jadwal);
        // Kirim data ke view
        return view('pasien.pilihjadwal', compact('jadwal'));
    }
    
    
    
    
    

    public function submitDaftarPoli(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required',
            'keluhan' => 'required',
            'id_pasien' => 'required',
        ]);

        // dd($request->all());
        // Ambil nomor urut berdasarkan poliklinik dan jadwal yang dipilih
        DaftarPoli::create($request->all());

        return redirect('pasien-dashboard')->with('success', 'Berhasil mendaftar antrean!');
    }

    
    
}
