@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <h1 class="mb-4">Detail Slider</h1>

        <div class="card mb-4">
            <img src="{{ asset('images/' . $slider->image) }}" class="card-img-top" alt="{{ $slider->title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $slider->title }}</h5>
                <p class="card-text">{{ $slider->description }}</p>
                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
