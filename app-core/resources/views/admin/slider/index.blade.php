@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1>Sliders</h1>
    <div class="mb-3">
        <a href="{{ route('sliders.create') }}" class="btn btn-primary mb-3">Add New Slider</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
            <tr>
                <td><img src="{{ asset( $slider->image) }}" alt="{{ $slider->title }}" style="max-width: 100px;"></td>
                <td>{{ $slider->title }}</td>
                <td>{{ $slider->description }}</td>
                <td>
                    <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
