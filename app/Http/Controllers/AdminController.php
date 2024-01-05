<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // ~~ DOKTER ~~

    public function dokter()
    {
        $dokters = Dokter::all();
        return view('admin.dokter', compact('dokters'));
    }

    public function createDokter()
    {
        $polis = Poli::all();
        return view('admin.dokter-create', compact('polis'));
    }

    public function storeDokter(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
            'id_poli' => 'required|numeric',
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin-dokter')
            ->with('success', 'Dokter berhasil ditambahkan!');
    }

    public function editDokter(Dokter $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter-edit', compact('dokter', 'polis'));
    }

    public function updateDokter(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
            'id_poli' => 'required|numeric',
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin-dokter')
            ->with('success', 'Dokter berhasil diperbarui!');
    }

    public function destroyDokter(Dokter $dokter)
    {
        if ($dokter == null) {
            return redirect()->route('admin-dokter')
            ->with('success', 'Dokter '.$dokter->nama.' sudah dihapus sebelumnya!');
        }
        $hasRelatedJadwalPeriksa = JadwalPeriksa::where('id_dokter', $dokter->id)->exists();
        if ($hasRelatedJadwalPeriksa) {
            return redirect()->route('admin-dokter')->with('error', 'Tidak dapat menghapus dokter karena ada jadwal periksa terkait.');
        }
        $dokter->delete();

        return redirect()->route('admin-dokter')
            ->with('success', 'Dokter '.$dokter->nama.' berhasil dihapus!');
    }

    // ~~ PASIEN ~~

    public function pasien()
    {
        $pasiens = Pasien::orderBy(DB::raw('SUBSTRING_INDEX(no_rm, "-", -1)'), 'ASC')
                        ->orderBy('no_rm', 'ASC')
                        ->get();
        
        return view('admin.pasien', compact('pasiens'));
    }

    public function createPasien()
    {
        return view('admin.pasien-create');
    }

    public function storePasien(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
        ]);

        // Cek apakah admin sedang membuat pasien atau bukan
        $isAdminCreatingPasien = $request->user()->idRole == 1; // Sesuaikan dengan logika role admin pada aplikasi Anda

        // Jika admin sedang membuat pasien, unset no_rm agar tidak diisi
        if ($isAdminCreatingPasien) {
            unset($request['no_rm']);
        }

        Pasien::create($request->all());

        return redirect()->route('admin-pasien')
            ->with('success', 'Pasien berhasil ditambahkan!');
    }

    public function editpasien(Pasien $pasien)
    {
        return view('admin.pasien-edit', compact('pasien'));
    }

    public function updatePasien(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_ktp' => 'required|numeric',
            'no_hp' => 'required|numeric',
        ]);

        $pasien->update($request->all());

        return redirect()->route('admin-pasien')
            ->with('success', ' berhasil diperbarui!');
    }

    public function destroyPasien(Pasien $pasien)
    {
        if ($pasien == null) {
            return redirect()->route('admin-pasien')
            ->with('success', 'Pasien '.$pasien->nama.' sudah dihapus sebelumnya!');
        }
        $hasRelatedPasien = DaftarPoli::where('id_pasien', $pasien->id)->exists();
        if ($hasRelatedPasien) {
            return redirect()->route('admin-pasien')->with('error', 'Tidak dapat menghapus pasien karena ada daftar poli terkait.');
        }
        $pasien->delete();

        return redirect()->route('admin-pasien')
            ->with('success', 'Pasien '.$pasien->nama.' berhasil dihapus!');
    }

    // ~~ POLIKLINIK ~~

    public function poli()
    {
        $polis = Poli::all();
        return view('admin.poli', compact('polis'));
    }

    public function createPoli()
    {
        return view('admin.poli-create');
    }

    public function storePoli(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'required',
        ]);

        Poli::create($request->all());

        return redirect()->route('admin-poli')
            ->with('success', 'Poli berhasil ditambahkan!');
    }

    public function editPoli(Poli $poli)
    {
        return view('admin.poli-edit', compact('poli'));
    }

    public function updatePoli(Request $request, Poli $poli)
    {
        $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'required',
        ]);

        $poli->update($request->all());

        return redirect()->route('admin-poli')
            ->with('success', 'Poli berhasil diperbarui!');
    }

    public function destroyPoli(Poli $poli)
    {
        if ($poli == null) {
            return redirect()->route('admin-poli')
            ->with('success', 'Poli sudah dihapus sebelumnya!');
        }

        $hasRelatedDokter = Dokter::where('id_poli', $poli->id)->exists();
        if ($hasRelatedDokter) {
            return redirect()->route('admin-poli')->with('error', 'Tidak dapat menghapus Poli karena ada Dokter terkait.');
        }

        $poli->delete();

        return redirect()->route('admin-poli')
            ->with('success', 'Poli berhasil dihapus!');
    }

    // ~~ OBAT ~~

    public function obat()
    {
        $obats = Obat::all();
        return view('admin.obat', compact('obats'));
    }

    public function createObat()
    {
        return view('admin.obat-create');
    }

    public function storeObat(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'kemasan' => 'required',
            'harga' => 'required|numeric',
        ]);

        Obat::create($request->all());

        return redirect()->route('admin-obat')
            ->with('success', 'Obat berhasil ditambahkan!');
    }
    
    public function editObat(Obat $obat)
    {
        return view('admin.obat-edit', compact('obat'));
    }

    public function updateObat(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required',
            'kemasan' => 'required',
            'harga' => 'required|numeric',
        ]);

        $obat->update($request->all());

        return redirect()->route('admin-obat')
            ->with('success', 'Obat berhasil diperbarui!');
    }

    public function destroyObat(Obat $obat)
    {
        if ($obat == null) {
            return redirect()->route('admin-obat')
            ->with('success', 'Obat sudah dihapus sebelumnya!');
        }
        $hasRelatedObat = DetailPeriksa::where('id_obat', $obat->id)->exists();
        if ($hasRelatedObat) {
            return redirect()->route('admin-obat')->with('error', 'Tidak dapat menghapus Obat karena ada detail periksa terkait.');
        }
        $obat->delete();

        return redirect()->route('admin-obat')
            ->with('success', 'Obat berhasil dihapus!');
    }
}
