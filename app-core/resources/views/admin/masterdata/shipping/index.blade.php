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

  <!-- Kartu Daftar Layanan Pengiriman -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Layanan Pengiriman</h5>

      <!-- Tombol Tambah Layanan -->
      <a href="{{ route('masterdata.shipping.create') }}" class="btn btn-primary mb-2">Tambah Layanan Baru</a>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($shippingServices as $index => $service)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $service->name }}</td>
              <td>
                <!-- Tombol Ubah -->
                <a class="btn btn-sm btn-primary" href="{{ route('masterdata.shipping.edit', $service->id) }}">
                  <i class="bx bx-edit-alt me-1"></i> Ubah
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route('masterdata.shipping.destroy', $service->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus layanan pengiriman ini?')">
                    <i class="bx bx-trash me-1"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center">Tidak ada layanan pengiriman yang ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
