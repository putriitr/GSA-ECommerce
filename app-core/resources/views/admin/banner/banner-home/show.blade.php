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
      <h5 class="mb-0">Banner Details</h5>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Image</label>
        <br>
        <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" width="300" class="img-thumbnail">
      </div>
      <div class="mb-3">
        <label class="form-label">Title</label>
        <p>{{ $banner->title }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <p>{{ $banner->description }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Link</label>
        <p>{{ $banner->link }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Order</label>
        <p>{{ $banner->order }}</p>
      </div>
      <div class="mb-3">
        <label class="form-label">Active</label>
        <p>{{ $banner->active ? 'Yes' : 'No' }}</p>
      </div>
      <a href="{{ route('admin.banner-home.banners.index') }}" class="btn btn-secondary">Back to Banner List</a>
    </div>
  </div>
</div>

@endsection
