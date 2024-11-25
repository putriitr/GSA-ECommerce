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
      <h5 class="mb-0">Create New Banner</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.banner-home.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" maxlength="255">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <select class="form-select" id="link" name="link">
                <option value="" selected>Select a link</option>
                <option value="{{ route('home') }}" {{ old('link') == route('home') ? 'selected' : '' }}>Home</option>
                <option value="{{ route('shop') }}" {{ old('link') == route('shop') ? 'selected' : '' }}>Shop</option>
                <option value="custom" {{ old('link') == 'custom' ? 'selected' : '' }}>Custom Link</option>
            </select>
            <input type="url" class="form-control mt-2" name="custom_link" placeholder="Enter custom link (if applicable)" value="{{ old('custom_link') }}" style="display: none;"> <!-- Initially hidden -->
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const linkSelect = document.getElementById('link');
                const customLinkInput = document.querySelector('input[name="custom_link"]');
            
                // Function to toggle the visibility of the custom link input
                function toggleCustomLink() {
                    if (linkSelect.value === '') {
                        customLinkInput.style.display = 'none'; // Hide if 'Select a link' is selected
                    } else if (linkSelect.value === 'custom') {
                        customLinkInput.style.display = 'block'; // Show if 'Custom Link' is selected
                    } else {
                        customLinkInput.style.display = 'none'; // Hide for any other option
                    }
                }
            
                // Initial call to set the correct state based on the selected option
                toggleCustomLink();
            
                // Add event listener to handle changes in the dropdown
                linkSelect.addEventListener('change', toggleCustomLink);
            });
            </script>
                    
        
        <div class="mb-3">
          <label for="order" class="form-label">Order</label>
          <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 1) }}">
        </div>
        <div class="mb-3">
          <label for="active" class="form-label">Active</label>
          <select class="form-select" id="active" name="active">
            <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('active') === '0' ? 'selected' : '' }}>No</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Banner</button>
      </form>
    </div>
  </div>
</div>

@endsection
