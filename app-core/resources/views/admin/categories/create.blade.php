@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h2>Tambah Kategori</h2>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label for="icon">Ikon (class Font Awesome)</label>
            <input type="text" class="form-control" name="icon" required>
            <small class="form-text text-muted">Contoh: fas fa-car</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
