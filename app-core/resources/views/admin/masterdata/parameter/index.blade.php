@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Parameter Management</h1>
    <a href="{{ route('masterdata.parameters.create') }}" class="btn btn-primary mb-3">Add New Parameter</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Ecommerce</th>
                <th>Nomor WA</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parameters as $parameter)
                <tr>
                    <td>{{ $parameter->id }}</td>
                    <td>{{ $parameter->nama_ecommerce }}</td>
                    <td>{{ $parameter->nomor_wa }}</td>
                    <td>{{ $parameter->email }}</td>
                    <td>
                        <a href="{{ route('masterdata.parameters.edit', $parameter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('masterdata.parameters.destroy', $parameter->id) }}" method="POST" style="display:inline-block;">
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
