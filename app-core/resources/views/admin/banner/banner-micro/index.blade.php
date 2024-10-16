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
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">List of Micro Banners</h5>
      <a href="{{ route('admin.banner-micro.banners.create') }}" class="btn btn-primary">Create New Micro Banner</a>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Image</th>
            <th>Link</th>
            <th>Active</th>
            <th>Page</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($banners as $index => $banner)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <img src="{{ asset($banner->image) }}" alt="Micro Banner" width="100" class="me-2">
              </td>
              <td>{{ $banner->link }}</td>
              <td>{{ $banner->active ? 'Yes' : 'No' }}</td>
              <td>{{ ucfirst($banner->page) }}</td>
              <td>
                <!-- Show button -->
                <a class="btn btn-sm btn-info me-2" href="{{ route('admin.banner-micro.banners.show', $banner->id) }}">
                  <i class="bx bx-eye-alt"></i> Show
                </a>

                <!-- Edit button -->
                <a class="btn btn-sm btn-primary me-2" href="{{ route('admin.banner-micro.banners.edit', $banner->id) }}">
                  <i class="bx bx-edit-alt"></i> Edit
                </a>

                <!-- Delete button -->
                <form action="{{ route('admin.banner-micro.banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?')">
                    <i class="bx bx-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
