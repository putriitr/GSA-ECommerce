@extends('layouts.admin.master')

@section('content')
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ $product->category }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
@endsection
