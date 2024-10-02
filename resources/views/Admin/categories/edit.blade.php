@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h2>Edit Kategori</h2>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
        </div>
        <div class="form-group">
            <label for="icon">Ikon (class Font Awesome)</label>
            <input type="text" class="form-control" name="icon" required>
            <small class="form-text text-muted">Contoh: fas fa-car</small>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
