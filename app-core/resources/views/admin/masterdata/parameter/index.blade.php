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

  <!-- Kartu Daftar Parameter -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Parameter</h5>

      <!-- Tombol Tambah Parameter hanya muncul jika belum ada data -->
      @if($parameters->count() < 1)
        <a href="{{ route('masterdata.parameters.create') }}" class="btn btn-primary mb-2">Tambah Parameter Baru</a>
      @else
        <div class="alert alert-info mb-2">
          <strong>Pemberitahuan:</strong> Hanya satu entri parameter yang diperbolehkan. Silakan ubah entri yang ada.
        </div>
      @endif
    </div>

    <!-- Jika ada data parameter, tampilkan tabel -->
    @if($parameters->count() > 0)
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Ecommerce</th>
              <th>Nomor WA</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($parameters as $parameter)
              <tr>
                <td>1</td> <!-- Hanya 1 data, jadi nomor tetap 1 -->
                <td>{{ $parameter->nama_ecommerce }}</td>
                <td>{{ $parameter->nomor_wa }}</td>
                <td>{{ $parameter->email }}</td>
                <td>
                  <!-- Tombol Ubah -->
                  <a class="btn btn-sm btn-primary" href="{{ route('masterdata.parameters.edit', $parameter->id) }}">
                    <i class="bx bx-edit-alt me-1"></i> Ubah
                  </a>

                  <!-- Tombol Hapus -->
                  <form action="{{ route('masterdata.parameters.destroy', $parameter->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus parameter ini?')">
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
