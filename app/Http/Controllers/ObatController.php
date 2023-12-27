<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('obat2.index', compact('obats'));
    }

    public function index2()
    {
        $obats = Obat::all();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        return view('obat2.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'kemasan' => 'required',
            'harga' => 'required|numeric',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    public function show(Obat $obat)
    {
        return view('obat2.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        return view('obat2.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required',
            'kemasan' => 'required',
            'harga' => 'required|numeric',
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil diperbarui!');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus!');
    }
}
