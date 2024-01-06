<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function dashboard()
    {
        return view('dokter.dashboard');
    }


    // JADWAL PERIKSA

    public function jadwalPeriksa()
    {
        $dokter = Auth::user();
        if ($dokter->role->nama_role == 'dokter') {
            $dokterSama = Dokter::where('nama', $dokter->nama)->first();
            $jadwal_periksa = JadwalPeriksa::where('id_dokter', $dokterSama->id)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();

            return view('dokter.jadwal-periksa', compact('jadwal_periksa'));
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
    
public function statusJadwalPeriksa($id)
{
    $jadwalPeriksa = JadwalPeriksa::find($id);

    if (!$jadwalPeriksa) {
        return redirect()->back()->with('error', 'JadwalPeriksa tidak ditemukan.');
    }

    if ($jadwalPeriksa->aktif == 'Y') {
        $jadwalPeriksa->update([
            'aktif' => 'N',
        ]);
    } else if ($jadwalPeriksa->aktif == 'N') {
        $jadwalPeriksa->update([
            'aktif' => 'Y',
        ]);
    }

    return redirect()->route('dokter-jadwal-periksa')->with('success', 'Status jadwal periksa berhasil diubah.');
}


    public function tambahJadwalPeriksa()
    {
        return view('dokter.tambah-jadwal-periksa');
    }

    public function createJadwalPeriksa(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => [
                'required',
                Rule::unique('jadwal_periksa')->where(function ($query) use ($request) {
                    return $query->where([
                        'hari' => $request->input('hari'),
                        'jam_mulai' => $request->input('jam_mulai'),
                    ]);
                }),
                function ($attribute, $value, $fail) use ($request) {
                    $jamMulai = strtotime($request->input('jam_mulai'));
                    $jamSelesai = strtotime($value);
                    
                    if ($jamSelesai <= $jamMulai) {
                        $fail('Jam mulai harus lebih dahulu dari jam selesai!');
                    }
                },
            ],
        ]);

        // Ambil nama dokter dari user yang sedang login
        $namaDokterAuth = Auth::user()->nama;
        // Cari id Dokter berdasarkan nama
        $dokter = Dokter::where('nama', $namaDokterAuth)->first();

        if ($dokter) {
            JadwalPeriksa::create([
                'id_dokter' => $dokter->id,
                'hari' => $request->input('hari'),
                'jam_mulai' => $request->input('jam_mulai'),
                'jam_selesai' => $request->input('jam_selesai'),
                'aktif' => 'Y'
            ]);

            return redirect()->route('dokter-jadwal-periksa')->with('success', 'Jadwal periksa berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Dokter tidak ditemukan!');
        }
        return redirect()->back()->with('error', 'Gagal menambahkan jadwal periksa!');
    }

    public function editJadwalPeriksa($id)
    {
        $jadwalPeriksa = JadwalPeriksa::find($id);

        if ($jadwalPeriksa) {
            $namaDokterAuth = Auth::user()->nama;

            // Cari id Dokter berdasarkan nama
            $dokter = Dokter::where('nama', $namaDokterAuth)->first();

            if ($dokter) {
                // Pastikan jadwal periksa dimiliki oleh dokter yang sedang login
                if ($jadwalPeriksa->id_dokter == $dokter->id) {
                    return view('dokter.edit-jadwal-periksa', compact('jadwalPeriksa'));
                } else {
                    return redirect()->route('dokter-jadwal-periksa')->with('error', 'Anda tidak memiliki izin untuk mengedit jadwal periksa ini!');
                }
            } else {
                return redirect()->back()->with('error', 'Dokter tidak ditemukan!');
            }
        } else {
            return redirect()->back()->with('error', 'Jadwal periksa tidak ditemukan!');
        }
    }

    public function updateJadwalPeriksa(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => [
                'required',
                Rule::unique('jadwal_periksa')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where([
                        'hari' => $request->input('hari'),
                        'jam_mulai' => $request->input('jam_mulai'),
                    ]);
                }),
                function ($attribute, $value, $fail) use ($request) {
                    $jamMulai = strtotime($request->input('jam_mulai'));
                    $jamSelesai = strtotime($value);

                    if ($jamSelesai <= $jamMulai) {
                        $fail('Jam mulai harus lebih dahulu dari jam selesai!');
                    }
                },
            ],
        ]);

        // Cari jadwal periksa berdasarkan ID
        $jadwalPeriksa = JadwalPeriksa::find($id);

        if ($jadwalPeriksa) {
            $namaDokterAuth = Auth::user()->nama;

            $dokter = Dokter::where('nama', $namaDokterAuth)->first();

            if ($dokter) {
                // Pastikan jadwal periksa dimiliki oleh dokter yang sedang login
                if ($jadwalPeriksa->id_dokter == $dokter->id) {
                    $jadwalPeriksa->update([
                        'hari' => $request->input('hari'),
                        'jam_mulai' => $request->input('jam_mulai'),
                        'jam_selesai' => $request->input('jam_selesai'),
                    ]);

                    return redirect()->route('dokter-jadwal-periksa')->with('success', 'Jadwal periksa berhasil diperbarui!');
                } else {
                    return redirect()->route('dokter-jadwal-periksa')->with('error', 'Anda tidak memiliki izin untuk mengedit jadwal periksa ini!');
                }
            } else {
                return redirect()->back()->with('error', 'Dokter tidak ditemukan!');
            }
        } else {
            return redirect()->back()->with('error', 'Jadwal periksa tidak ditemukan!');
        }
    }

    public function destroyJadwalPeriksa($id)
    {
        $jadwalPeriksa = JadwalPeriksa::find($id);

        if ($jadwalPeriksa) {
            $jadwalPeriksa->delete();
            return redirect()->route('dokter-jadwal-periksa')->with('success', 'Jadwal periksa berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Jadwal periksa tidak ditemukan!');
    }

    // DAFTAR PERIKSA

    public function daftarPeriksa()
    {
        // Ambil hanya data yang keluhannya belum 'selesai'
        $daftar_periksa = DaftarPoli::where('keluhan', '!=', 'selesai')
                                    ->orderBy('id_jadwal')
                                    ->orderBy('no_antrian')
                                    ->get();
        return view('dokter.daftar-periksa', compact('daftar_periksa'));
    }

    public function periksakanDaftarPeriksa($id)
    {
        $pasienIni = DaftarPoli::findOrFail($id);
        $daftar_obat = Obat::all();
        return view('dokter.periksakan-daftar-periksa', compact('pasienIni','daftar_obat'));
    }

    public function simpanPeriksakanDaftarPeriksa(Request $request, $id)
    {
        // Hitung total harga obat
        $totalHargaObat = array_sum($request->input('harga_obat'));
        // Hitung total biaya periksa (biaya periksa + total harga obat)
        $totalBiayaPeriksa = $request->input('biaya_periksa') + $totalHargaObat;

        // Simpan data periksa ke dalam tabel periksa
        $periksa = Periksa::create([
            'id_daftar_poli' => $id,
            'tgl_periksa' => now(),
            'catatan' => $request->input('catatan'),
            'biaya_periksa' => $totalBiayaPeriksa,
        ]);
        DaftarPoli::where('id', $id)->update(['keluhan' => 'selesai']);

        // Simpan data obat ke dalam tabel detail_periksa
        foreach ($request->input('id_obat') as $id_obat) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $id_obat,
            ]);
        }

        return redirect()->route('dokter-daftar-periksa')->with('success', 'Data periksa berhasil disimpan!');
    }


    public function riwayatPeriksa()
    {
        $periksa = Periksa::all();
        return view('dokter.riwayat-periksa', compact('periksa'));
    }

    public function detailRiwayatPeriksa($id)
    {
        $detail_periksa = DetailPeriksa::findOrFail($id);
        $id_obat = DetailPeriksa::with('obat')->where('id_periksa', $id)->get();
        return view('dokter.detail_riwayat-periksa', compact('detail_periksa','id_obat'));
    }

    public function destroyRiwayatPeriksa($id)
    {
        $riwayat_periksa = Periksa::find($id);

        if ($riwayat_periksa) {
            DetailPeriksa::where('id_periksa', $id)->delete();
            $riwayat_periksa->delete();
            return redirect()->route('dokter-riwayat-periksa')->with('success', 'Riwayat periksa berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Riwayat periksa tidak ditemukan!');
    }
}
