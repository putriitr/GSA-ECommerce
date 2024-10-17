@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>FAQ Management</h1>

    @if($faqs->count() < 1)
        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary mb-3">Add New FAQ</a>
    @else
        <div class="alert alert-info mb-3">
            <strong>Notice:</strong> Only one FAQ entry is allowed. Please edit the existing entry instead of adding a new one.
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
                <tr>
                    <td>{{ $faq->id }}</td>
                    <td>
                        <a href="{{ route('admin.faq.show', $faq->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
