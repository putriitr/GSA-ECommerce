@extends('layouts.admin.master')

@section('content')
    <h2>Detail Service</h2>

    <div class="card">
        <div class="card-header">
            <h3>{{ $service->title }}</h3>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="{{ $service->icon }} fa-3x"></i>
            </div>
            <p><strong>Deskripsi:</strong> {{ $service->description }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
@endsection
