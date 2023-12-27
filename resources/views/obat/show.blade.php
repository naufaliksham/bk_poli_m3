<!-- resources/views/obats/show.blade.php -->
@extends('layout.app')

@section('content')
    <h1>Detail Obat</h1>

    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $obat->id }}</td>
        </tr>
        <tr>
            <th>Nama Obat</th>
            <td>{{ $obat->nama_obat }}</td>
        </tr>
        <tr>
            <th>Kemasan</th>
            <td>{{ $obat->kemasan }}</td>
        </tr>
        <tr>
            <th>Harga</th>
            <td>{{ $obat->harga }}</td>
        </tr>
    </table>

    <a href="{{ route('obat.index') }}" class="btn btn-primary">Kembali ke Daftar Obat</a>
@endsection


