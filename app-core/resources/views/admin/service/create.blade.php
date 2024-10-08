@extends('layouts.admin.master')

@section('content')
    <h2>Tambah Service Baru</h2>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="icon">Ikon (class Font Awesome)</label>
            <input type="text" class="form-control" name="icon" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Layanan</button>
    </form>

@endsection
