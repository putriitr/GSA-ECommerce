@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">{{ $product->name }} Details</h4>
        <div>
            <a href="{{ route('product.index') }}" class="btn btn-secondary me-2">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
            <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-primary me-2">
                <i class="bx bx-edit-alt"></i> Edit Product
            </a>
            <form action="{{ route('product.destroy', $product->slug) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="bx bx-trash"></i> Delete Product
                </button>
            </form>
        </div>
    </div>
    
    <!-- Product Information -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Product Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Category:</strong> {{ $product->category->name }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            @if($product->is_discount && $product->discount_price)
                <p><strong>Discount Price:</strong> ${{ number_format($product->discount_price, 2) }}</p>
            @endif
            <p><strong>Pre-order:</strong> {{ $product->is_pre_order ? 'Yes' : 'No' }}</p>
            <p><strong>Negotiable:</strong> {{ $product->is_negotiable ? 'Yes' : 'No' }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
        </div>
    </div>

    <!-- Product Images -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Product Images</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($product->images as $image)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    </div>
                @empty
                    <p class="text-center">No images available for this product.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Product Videos -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Product Videos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($product->videos as $video)
                    <div class="col-md-6 mb-3">
                        <video width="100%" height="240" controls>
                            <source src="{{ asset($video->video) }}" type="video/mp4">
                        </video>
                    </div>
                @empty
                    <p class="text-center">No videos available for this product.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
