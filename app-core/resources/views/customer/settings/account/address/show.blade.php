@extends('layouts.customer.master')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('customer.settings.partials.sidebar')            
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <!-- Notifications -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Add new address button -->
                <a href="#" data-bs-toggle="modal" data-bs-target="#addAddressModal" class="text-decoration-none"
                style="text-decoration: none; color: inherit;">
                    <div class="card mt-4 border-0 shadow-sm mb-4" id="addAddressCard"
                        style="cursor: pointer; transition: background-color 0.3s, box-shadow 0.3s;">
                        <div class="card-body text-center">
                            <span class="text-muted">+ tambah alamat baru</span>
                        </div>
                    </div>
                </a>
             
                <script>
                    // Adding hover effect using JavaScript
                    document.getElementById('addAddressCard').addEventListener('mouseover', function() {
                        this.style.backgroundColor = '#f1f1f1';
                        this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                    });
                    
                    document.getElementById('addAddressCard').addEventListener('mouseout', function() {
                        this.style.backgroundColor = '';
                        this.style.boxShadow = '';
                    });
                </script>

                <!-- List of addresses -->
                @if($addresses->isEmpty())
                    <!-- Show message if no addresses -->
                    <div class="alert alert-info">
                        Belum ada alamat. Tambahkan alamat baru untuk pengiriman.
                    </div>
                @else
                    @foreach($addresses as $address)
                    <div class="card border-0 shadow-sm mb-3 {{ $address->is_active ? 'border border-primary' : 'border border-light' }}">
                        <div class="card-body {{ $address->is_active ? 'bg-light' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold">
                                        {{ $address->nama_penerima }} 
                                        <span class="text-muted">({{ $address->label_alamat }})</span>
                                        @if($address->is_active)
                                            <span class="badge bg-primary">Aktif</span>
                                        @endif
                                    </h5>
                                </div>
                                <div>
                                    @if(!$address->is_active)
                                        <form action="{{ route('user.address.set-active', $address->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Jadikan Aktif</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Alamat Aktif</button>
                                    @endif
                                </div>
                            </div>
                            <p>{{ $address->nomor_telepon }}</p>
                            <p>{{ $address->detail_alamat }}, {{ $address->kecamatan }}, {{ $address->kota_kabupaten }}, {{ $address->provinsi }}, {{ $address->kodepos }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Ubah alamat</a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('user.address.delete', $address->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">Hapus</button>
                                </form>
                            </div>                        
                        </div>
                    </div>


                        <!-- Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content shadow-lg border-0 rounded">
                                    <div class="modal-header bg-primary text-white rounded-top">
                                        <h5 class="modal-title" id="editAddressModalLabel">Ubah Alamat</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.address.update', $address->id) }}" method="POST" class="p-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="label_alamat" class="form-label">Label Alamat (Rumah/Kantor)</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="label_alamat" value="{{ $address->label_alamat }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nama_penerima" value="{{ $address->nama_penerima }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nomor_telepon" value="{{ $address->nomor_telepon }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="provinsi" class="form-label">Provinsi</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="provinsi" value="{{ $address->provinsi }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kota_kabupaten" class="form-label">Kota/Kabupaten</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kota_kabupaten" value="{{ $address->kota_kabupaten }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kecamatan" value="{{ $address->kecamatan }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kodepos" class="form-label">Kodepos</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kodepos" value="{{ $address->kodepos }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="detail_alamat" class="form-label">Detail Alamat</label>
                                                        <textarea class="form-control form-control-sm rounded shadow-sm" name="detail_alamat" rows="2" required>{{ $address->detail_alamat }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4 me-2" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Edit Modal -->
                        
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>





<!-- Modal for adding new address -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded">
            <div class="modal-header bg-primary text-white rounded-top">
                <h5 class="modal-title" id="addAddressModalLabel">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.address.store') }}" method="POST" class="p-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="label_alamat" class="form-label">Label Alamat (Rumah/Kantor)</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="label_alamat" id="label_alamat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nama_penerima" id="nama_penerima" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nomor_telepon" id="nomor_telepon" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="provinsi" id="provinsi" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kota_kabupaten" class="form-label">Kota/Kabupaten</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kota_kabupaten" id="kota_kabupaten" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kecamatan" id="kecamatan" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kodepos" class="form-label">Kodepos</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kodepos" id="kodepos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="detail_alamat" class="form-label">Detail Alamat</label>
                                <textarea class="form-control form-control-sm rounded shadow-sm" name="detail_alamat" id="detail_alamat" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
