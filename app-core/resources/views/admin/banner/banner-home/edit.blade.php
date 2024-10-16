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
      <h5 class="mb-0">Edit Banner</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.banner-home.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name="image">
          <small>Current Image: <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" width="100" class="me-2"></small>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $banner->title) }}" maxlength="255">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <select class="form-select" id="link" name="link" onchange="toggleCustomLink()">
                <option value="" selected>Select a link</option>
                <option value="{{ route('home') }}" {{ old('link', $banner->link) == route('home') ? 'selected' : '' }}>Home</option>
                <option value="{{ route('shop') }}" {{ old('link', $banner->link) == route('shop') ? 'selected' : '' }}>Shop</option>
                <option value="custom" {{ old('link', $banner->link) == 'custom' ? 'selected' : '' }}>Custom Link</option>
            </select>
            <input type="url" class="form-control mt-2" name="custom_link" placeholder="Enter custom link (if applicable)" value="{{ old('custom_link') }}">
        </div>
        
        <script>
        function toggleCustomLink() {
            const selectElement = document.getElementById('link');
            const customLinkInput = document.querySelector('input[name="custom_link"]');
        
            // Show the custom link input if "Custom Link" is selected
            if (selectElement.value === 'custom') {
                customLinkInput.style.display = 'block';
                customLinkInput.value = ''; // Clear the input if switching to custom
            } else {
                customLinkInput.style.display = 'none'; // Hide it otherwise
                customLinkInput.value = ''; // Clear input if another option is selected
            }
        }
        
        // Call toggleCustomLink on page load to set the correct state
        document.addEventListener('DOMContentLoaded', toggleCustomLink);
        </script>
        
        <div class="mb-3">
          <label for="order" class="form-label">Order</label>
          <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $banner->order) }}">
        </div>
        <div class="mb-3">
          <label for="active" class="form-label">Active</label>
          <select class="form-select" id="active" name="active">
            <option value="1" {{ old('active', $banner->active) ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('active', !$banner->active) ? 'selected' : '' }}>No</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Banner</button>
      </form>
    </div>
  </div>
</div>

@endsection
