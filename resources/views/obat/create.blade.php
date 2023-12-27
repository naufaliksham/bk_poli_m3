<!-- resources/views/obats/create.blade.php -->
@extends('layout.app')

@section('content')
    <h1>Tambah Obat Baru</h1>

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_obat">Nama Obat:</label>
            <input type="text" name="nama_obat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="kemasan">Kemasan:</label>
            <input type="text" name="kemasan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
