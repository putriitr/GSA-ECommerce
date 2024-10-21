@extends('layouts.admin.master')

@section('content')

<div class="container py-5">

  <!-- Menampilkan pesan sukses -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Menampilkan pesan error -->
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Kartu Daftar Kategori -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Kategori</h5>

      <!-- Form Pencarian -->
      <form action="{{ route('product.categories.index') }}" method="GET" class="d-flex mb-2">
        <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ms-2">Cari</button>
        @if(request('search'))
          <a href="{{ route('product.categories.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-sync-alt p-1"></i>
          </a>
        @endif
      </form>

      <!-- Tombol Tambah Kategori -->
      <a href="{{ route('product.categories.create') }}" class="btn btn-primary mb-2">Buat Kategori Baru</a>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Slug</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $index => $category)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $category->name }}</td>
              <td>{{ $category->slug }}</td>
              <td>
                <!-- Tombol Ubah -->
                <a class="btn btn-sm btn-primary" href="{{ route('product.categories.edit', $category->slug) }}">
                  <i class="bx bx-edit-alt me-1"></i> Ubah
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route('product.categories.destroy', $category->slug) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                    <i class="bx bx-trash me-1"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Tidak ada kategori yang ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>

@endsection
