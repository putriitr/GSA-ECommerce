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

  <!-- Product List Card -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">List of Products</h5>
      <a href="{{ route('product.create') }}" class="btn btn-primary">Create New Product</a>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Product</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $index => $product)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <div class="d-flex align-items-center">
                  @if($product->images->first())
                    <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}" width="100" class="me-2">
                  @else
                    <span>No Image</span>
                  @endif
                  <span>{{ $product->name }}</span>
                </div>
              </td>
              
              <td>{{ $product->category->name }}</td>
              <td>{{ $product->stock }}</td>
              <td>
                <!-- Show button -->
                <a class="btn btn-sm btn-info" href="{{ route('product.show', $product->slug) }}">
                  <i class="bx bx-show-alt "></i> Show
                </a>

                <!-- Edit button -->
                <a class="btn btn-sm btn-primary" href="{{ route('product.edit', $product->slug) }}">
                  <i class="bx bx-edit-alt "></i> Edit
                </a>

                <!-- Delete button -->
                <form action="{{ route('product.destroy', $product->slug) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="bx bx-trash "></i> Delete
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

<!-- Styling to handle the image and name display -->
<style>
  .product-info {
    display: inline-block;
    vertical-align: middle;
    max-width: 200px;
  }

  .product-image {
    display: inline-block;
    vertical-align: middle;
    margin-right: 8px;
    border-radius: 4px;
  }

  .product-name {
    display: inline-block;
    vertical-align: middle;
    font-weight: bold;
  }
</style>

@endsection
