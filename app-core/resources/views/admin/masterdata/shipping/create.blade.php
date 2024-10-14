@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Add New Shipping Service</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('masterdata.shipping.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Service</button>
    </form>
</div>
@endsection
