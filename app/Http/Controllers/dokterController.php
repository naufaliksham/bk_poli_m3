<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dokterController extends Controller
{
    public function index()
    {
        // $obats = Obat::all();
        return view('periksa.index');
    }
    public function index2()
    {
        return view('riwayat_pasien.index');
    }
}
