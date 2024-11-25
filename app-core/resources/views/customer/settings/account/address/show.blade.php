@extends('layouts.customer.master')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5 mt-5">
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
                        {{ __('messages.addresses.no_address') }}
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
                                            <span class="badge bg-primary">{{ __('messages.addresses.active_address') }}</span>
                                        @endif
                                    </h5>
                                </div>
                                <div>
                                    @if(!$address->is_active)
                                        <form action="{{ route('user.address.set-active', $address->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-primary">{{ __('messages.addresses.set_active') }}</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>{{ __('messages.addresses.address_active') }}</button>
                                    @endif
                                </div>
                            </div>
                            <p>{{ $address->nomor_telepon }}</p>
                            <p>{{ $address->detail_alamat }}, {{ $address->kecamatan }}, {{ $address->kota_kabupaten }}, {{ $address->provinsi }}, {{ $address->kodepos }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">{{ __('messages.addresses.edit_address') }}</a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('user.address.delete', $address->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">{{ __('messages.addresses.delete_address') }}</button>
                                </form>
                            </div>                        
                        </div>
                    </div>


                        <!-- Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content shadow-lg border-0 rounded">
                                    <div class="modal-header bg-primary text-white rounded-top">
                                        <h5 class="modal-title" id="editAddressModalLabel">{{ __('messages.addresses.modal.edit_title') }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.address.update', $address->id) }}" method="POST" class="p-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="label_alamat" class="form-label">{{ __('messages.addresses.form.label_address') }}</label>
                                                        <select class="form-control form-control-sm rounded-pill shadow-sm" name="label_alamat" id="label_alamat" required>
                                                            <option value="Rumah" {{ $address->label_alamat == 'Rumah' ? 'selected' : '' }}>{{ __('messages.addresses.form.label_address_options.home') }}</option>
                                                            <option value="Kantor" {{ $address->label_alamat == 'Kantor' ? 'selected' : '' }}>{{ __('messages.addresses.form.label_address_options.office') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nama_penerima" class="form-label">{{ __('messages.addresses.form.recipient_name') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nama_penerima" value="{{ $address->nama_penerima }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nomor_telepon" class="form-label">{{ __('messages.addresses.form.phone_number') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nomor_telepon" value="{{ $address->nomor_telepon }}" required minlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <div class="invalid-feedback"> 
                                                            {{ __('messages.addresses.form.invalid_phone') }}                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="provinsi" class="form-label">{{ __('messages.addresses.form.province') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="provinsi" value="{{ $address->provinsi }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kota_kabupaten" class="form-label">{{ __('messages.addresses.form.city') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kota_kabupaten" value="{{ $address->kota_kabupaten }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kecamatan" class="form-label">{{ __('messages.addresses.form.district') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kecamatan" value="{{ $address->kecamatan }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kodepos" class="form-label">{{ __('messages.addresses.form.postal_code') }}</label>
                                                        <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kodepos" value="{{ $address->kodepos }}" maxlength="5" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <div class="invalid-feedback">
                                                            {{ __('messages.addresses.form.invalid_postal_code') }}
                                                        </div>
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
                                                <button type="button" class="btn btn-secondary rounded-pill px-4 me-2" data-bs-dismiss="modal">{{ __('messages.addresses.modal.cancel') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">{{ __('messages.addresses.modal.save_changes') }}</button>
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




<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded">
            <div class="modal-header bg-primary text-white rounded-top">
                <h5 class="modal-title" id="addAddressModalLabel">{{ __('messages.address_add.modal.title') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('messages.address_add.modal.close') }}"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.address.store') }}" method="POST" class="p-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="label_alamat" class="form-label">{{ __('messages.address_add.form.label_address') }}</label>
                                <select class="form-control form-control-sm rounded-pill shadow-sm" name="label_alamat" id="label_alamat" required>
                                    <option value="" disabled selected>{{ __('messages.address_add.form.label_address_placeholder') }}</option>
                                    <option value="Rumah">{{ __('messages.address_add.form.label_address_options.home') }}</option>
                                    <option value="Kantor">{{ __('messages.address_add.form.label_address_options.office') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_penerima" class="form-label">{{ __('messages.address_add.form.recipient_name') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nama_penerima" id="nama_penerima" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">{{ __('messages.address_add.form.phone_number') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="nomor_telepon" id="nomor_telepon" required minlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="{{ __('messages.address_add.form.phone_placeholder') }}">
                                <div class="invalid-feedback">
                                    {{ __('messages.address_add.form.invalid_phone') }}
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">{{ __('messages.address_add.form.province') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="provinsi" id="provinsi" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kota_kabupaten" class="form-label">{{ __('messages.address_add.form.city') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kota_kabupaten" id="kota_kabupaten" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">{{ __('messages.address_add.form.district') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kecamatan" id="kecamatan" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kodepos" class="form-label">{{ __('messages.address_add.form.postal_code') }}</label>
                                <input type="text" class="form-control form-control-sm rounded-pill shadow-sm" name="kodepos" id="kodepos" maxlength="5" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="{{ __('messages.address_add.form.postal_placeholder') }}">
                                <div class="invalid-feedback">
                                    {{ __('messages.address_add.form.invalid_postal') }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="detail_alamat" class="form-label">{{ __('messages.address_add.form.address_details') }}</label>
                                <textarea class="form-control form-control-sm rounded shadow-sm" name="detail_alamat" id="detail_alamat" rows="2" required placeholder="{{ __('messages.address_add.form.address_details_placeholder') }}"></textarea>
                            </div>
                        </div>                        
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 me-2" data-bs-dismiss="modal">{{ __('messages.address_add.modal.cancel') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">{{ __('messages.address_add.modal.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
