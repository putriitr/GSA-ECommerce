@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Success message -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Micro Banner Details</h5>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Image</label>
        <img src="{{ asset($banner->image) }}" alt="Micro Banner" class="img-fluid">
      </div>
      <div class="mb-3">
        <label class="form-label">Link</label>
        <p>{{ $banner->link }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Active</label>
        <p>{{ $banner->active ? 'Yes' : 'No' }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Page</label>
        <p>{{ ucfirst($banner->page) }}</p>
      </div>
      <a href="{{ route('admin.banner-micro.banners.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
  </div>
</div>

@endsection
