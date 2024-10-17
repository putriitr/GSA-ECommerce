@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Edit Parameter</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('masterdata.parameters.update', $parameter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_ecommerce" class="form-label">Nama Ecommerce</label>
            <input type="text" class="form-control" name="nama_ecommerce" value="{{ old('nama_ecommerce', $parameter->nama_ecommerce) }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_wa" class="form-label">Nomor WA</label>
            <input type="text" class="form-control" name="nomor_wa" value="{{ old('nomor_wa', $parameter->nomor_wa) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $parameter->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" value="{{ old('alamat', $parameter->alamat) }}" required>
        </div>

        <div class="mb-3">
            <label for="email_pengaduan_kementrian" class="form-label">Email Pengaduan Kementrian</label>
            <input type="email" class="form-control" name="email_pengaduan_kementrian" value="{{ old('email_pengaduan_kementrian', $parameter->email_pengaduan_kementrian) }}">
        </div>

        <div class="mb-3">
            <label for="website_kementerian" class="form-label">Website Kementerian</label>
            <input type="url" class="form-control" name="website_kementerian" value="{{ old('website_kementerian', $parameter->website_kementerian) }}">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo">
            @if($parameter->logo)
                <img src="{{ asset($parameter->logo) }}" alt="Current Logo" class="img-fluid mt-2" style="max-height: 100px;">
            @endif
        </div>

        <div class="mb-3">
            <label for="logo_tambahan" class="form-label">Logo Tambahan</label>
            <input type="file" class="form-control" name="logo_tambahan">
            @if($parameter->logo_tambahan)
                <img src="{{ asset($parameter->logo_tambahan) }}" alt="Current Additional Logo" class="img-fluid mt-2" style="max-height: 100px;">
            @endif
        </div>

        <div class="mb-3">
            <label for="slogan_welcome" class="form-label">Slogan Welcome</label>
            <input type="text" class="form-control" name="slogan_welcome" value="{{ old('slogan_welcome', $parameter->slogan_welcome) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
