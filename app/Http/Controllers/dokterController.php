<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function dashboard()
    {
        return view('dokter.dashboard');
    }

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
}
