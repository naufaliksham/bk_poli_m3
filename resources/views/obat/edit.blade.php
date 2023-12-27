<!-- resources/views/obats/edit.blade.php -->
@extends('layout.app')

@section('content')
    <h1>Edit Obat</h1>

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_obat">Nama Obat:</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
        </div>
        <div class="form-group">
            <label for="kemasan">Kemasan:</label>
            <input type="text" name="kemasan" class="form-control" value="{{ $obat->kemasan }}" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection
