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

  <!-- Error messages -->
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

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit Micro Banner</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.banner-micro.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name="image">
          <small>Current Image: <img src="{{ asset($banner->image) }}" alt="Current Banner" width="100" class="me-2"></small>
        </div>
        <div class="mb-3">
          <label for="link" class="form-label">Link</label>
          <select class="form-select" id="link" name="link">
              <option value="" selected>Select a link</option>
              <option value="{{ route('home') }}" {{ $banner->link == route('home') ? 'selected' : '' }}>Home</option>
              <option value="{{ route('shop') }}" {{ $banner->link == route('shop') ? 'selected' : '' }}>Shop</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="active" class="form-label">Active</label>
          <select class="form-select" id="active" name="active">
            <option value="1" {{ $banner->active ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$banner->active ? 'selected' : '' }}>No</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="page" class="form-label">Page</label>
          <select class="form-select" id="page" name="page" required>
            <option value="show_product" {{ $banner->page == 'show_product' ? 'selected' : '' }}>Show Product</option>
            <option value="shop" {{ $banner->page == 'shop' ? 'selected' : '' }}>Shop</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Micro Banner</button>
      </form>
    </div>
  </div>
</div>

@endsection
