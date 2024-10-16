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
      <h5 class="mb-0">Create New Micro Banner</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.banner-micro.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <div class="mb-3">
          <label for="link" class="form-label">Link</label>
          <select class="form-select" id="link" name="link">
              <option value="" selected>Select a link</option>
              <option value="{{ route('home') }}">Home</option>
              <option value="{{ route('shop') }}">Shop</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="active" class="form-label">Active</label>
          <select class="form-select" id="active" name="active">
            <option value="1" selected>Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="page" class="form-label">Page</label>
          <select class="form-select" id="page" name="page" required>
            <option value="show_product">Show Product</option>
            <option value="shop">Shop</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Micro Banner</button>
      </form>
    </div>
  </div>
</div>

@endsection
