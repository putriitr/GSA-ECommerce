@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1 class="mt-4">Parameters</h1>

    <div class="mb-3">
            <a href="{{ route('parameters.create') }}" class="btn btn-primary mb-3">Add/Update Parameter</a>
    </div>


    @php
        $parameter = \App\Models\Parameter::first();
    @endphp

    @if ($parameter)
        <table class="table">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Tagline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $parameter->location }}</td>
                    <td>{{ $parameter->email }}</td>
                    <td>{{ $parameter->phone }}</td>
                    <td>{{ $parameter->tagline }}</td>
                    <td>
                        <a href="{{ route('parameters.edit', $parameter) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('parameters.destroy', $parameter) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <p>No parameters found. Please add one.</p>
    @endif
</div>
@endsection
