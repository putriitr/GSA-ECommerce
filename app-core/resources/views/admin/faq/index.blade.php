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

  <!-- Kartu Daftar FAQ -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar FAQ</h5>
      
      <!-- Tombol Tambah FAQ hanya muncul jika belum ada data -->
      @if($faqs->count() < 1)
        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary mb-2">Tambah FAQ Baru</a>
      @else
        <div class="alert alert-info mb-2">
          <strong>Pemberitahuan:</strong> Hanya satu entri FAQ yang diperbolehkan. Silakan ubah entri yang ada.
        </div>
      @endif
    </div>

    <!-- Jika ada data FAQ, tampilkan tabel -->
    @if($faqs->count() > 0)
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($faqs as $index => $faq)
              <tr>
                <td>{{ $loop->iteration }}</td> <!-- Hanya 1 data, jadi nomor tetap 1 -->
                <td>{{ $faq->id }}</td>
                <td>
                  <!-- Tombol Lihat -->
                  <a class="btn btn-sm btn-info" href="{{ route('admin.faq.show', $faq->id) }}">
                    <i class="bx bx-show-alt me-1"></i> Lihat
                  </a>

                  <!-- Tombol Ubah -->
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.faq.edit', $faq->id) }}">
                    <i class="bx bx-edit-alt me-1"></i> Ubah
                  </a>

                  <!-- Tombol Hapus -->
                  <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                      <i class="bx bx-trash me-1"></i> Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>

@endsection
