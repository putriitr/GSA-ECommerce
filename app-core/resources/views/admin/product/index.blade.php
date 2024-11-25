@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Pesan sukses -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  <!-- Pesan error -->
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  <!-- Kartu Daftar Produk -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-2">Daftar Produk</h5>
      <form action="{{ route('product.index') }}" method="GET" class="d-flex mb-2">
        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ms-2">Cari</button>
        @if(request('search'))
          <a href="{{ route('product.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-sync-alt p-1"></i>
          </a>
        @endif
      </form>
      <a href="{{ route('product.create') }}" class="btn btn-primary mb-2">Tambah Produk Baru</a>
    </div>
    

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $index => $product)
            <tr>
              <td>{{ $products->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center">
                  @if($product->images->first())
                    <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}" width="100" class="me-2">
                  @else
                    <span>Tidak Ada Gambar</span>
                  @endif
                  <span class="product-name">{{ $product->name }}</span>
                  <span class="{{ $product->status_published == 'Published' ? 'text-success' : 'text-danger' }}">
                    {{ $product->status_published }}
                </span>
                
                </div>
              </td>
              
              <td>{{ $product->category->name }}</td>
              <td>{{ $product->stock }}</td>
              <td>
                <!-- Tombol Lihat -->
                <a class="btn btn-sm btn-info" href="{{ route('product.show', $product->slug) }}">
                  <i class="bx bx-show-alt "></i> Lihat
                </a>

                <!-- Tombol Ubah -->
                <a class="btn btn-sm btn-primary" href="{{ route('product.edit', $product->slug) }}">
                  <i class="bx bx-edit-alt "></i> Ubah
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route('product.destroy', $product->slug) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                    <i class="bx bx-trash "></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-center mt-5 mb-2">
      {{ $products->links('pagination::bootstrap-5') }}
  </div>
  </div>
</div>

<!-- Gaya untuk menangani tampilan gambar dan nama produk -->
<style>
  .product-info {
    display: inline-block;
    vertical-align: middle;
    max-width: 200px;
  }

  .product-image {
    display: inline-block;
    vertical-align: middle;
    margin-right: 8px;
    border-radius: 4px;
  }

  .product-name {
    display: inline-block;
    vertical-align: middle;
    font-weight: bold;
  }

  .product-name {
    display: block;
    white-space: normal; /* Mengizinkan teks untuk melakukan break */
    word-wrap: break-word; /* Memastikan kata-kata yang panjang bisa di-break */
    max-width: 200px; /* Sesuaikan sesuai kebutuhan */
    overflow: hidden; /* Jika terlalu panjang, akan dipotong */
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Batasi teks ke 3 baris */
    -webkit-box-orient: vertical;
}

</style>

@endsection
