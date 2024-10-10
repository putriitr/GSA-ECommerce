@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Menampilkan pesan sukses -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Menampilkan pesan error -->
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
      <h5 class="mb-0">List of Categories</h5>
      <a href="{{ route('product.categories.create') }}" class="btn btn-primary">Create New Category</a>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($categories as $index => $category)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
              <a class="btn btn-sm btn-primary" href="{{ route('product.categories.edit', $category->slug) }}">
                <i class="bx bx-edit-alt me-1"></i> Edit
              </a>
              <form action="{{ route('product.categories.destroy', $category->slug) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="bx bx-trash me-1"></i> Delete
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
