@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Add New Parameter</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('masterdata.parameters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama_ecommerce" class="form-label">Nama Ecommerce</label>
            <input type="text" class="form-control" name="nama_ecommerce" value="{{ old('nama_ecommerce') }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_wa" class="form-label">Nomor WA</label>
            <input type="text" class="form-control" name="nomor_wa" value="{{ old('nomor_wa') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" value="{{ old('alamat') }}" required>
        </div>

        <div class="mb-3">
            <label for="email_pengaduan_kementrian" class="form-label">Email Pengaduan Kementrian</label>
            <input type="email" class="form-control" name="email_pengaduan_kementrian" value="{{ old('email_pengaduan_kementrian') }}">
        </div>

        <div class="mb-3">
            <label for="website_kementerian" class="form-label">Website Kementerian</label>
            <input type="url" class="form-control" name="website_kementerian" value="{{ old('website_kementerian') }}">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo">
        </div>

        <div class="mb-3">
            <label for="logo_tambahan" class="form-label">Logo Tambahan</label>
            <input type="file" class="form-control" name="logo_tambahan">
        </div>

        <div class="mb-3">
            <label for="slogan_welcome" class="form-label">Slogan Welcome</label>
            <input type="text" class="form-control" name="slogan_welcome" value="{{ old('slogan_welcome') }}">
        </div>

        <!-- Add Bank Vendor Field -->
        <div class="mb-3">
            <label for="bank_vendor" class="form-label">Bank Vendor</label>
            <input type="text" class="form-control" name="bank_vendor" value="{{ old('bank_vendor') }}">
        </div>

        <!-- Add Bank Name Field -->
        <div class="mb-3">
            <label for="bank_nama" class="form-label">Nama Bank</label>
            <input type="text" class="form-control" name="bank_nama" value="{{ old('bank_nama') }}">
        </div>

        <!-- Add Bank Account Field -->
        <div class="mb-3">
            <label for="bank_rekening" class="form-label">Nomor Rekening</label>
            <input type="text" class="form-control" name="bank_rekening" value="{{ old('bank_rekening') }}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
