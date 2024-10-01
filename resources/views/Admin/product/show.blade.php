@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $product->name }}</h1>
    <div class="row">
        <div class="col-lg-6">
            <div class="border border-primary rounded">
                <img src="{{ asset('storage/img/product/' . $product->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                    {{ $product->category }}
                </div>
                <div class="p-4">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h4>Details</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Category:</strong> {{ $product->category }}</li>
                <li class="list-group-item"><strong>Description:</strong> {{ $product->description }}</li>
                <li class="list-group-item"><strong>Stock:</strong> {{ $product->stock }} kg</li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-2">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</div>
@endsection
