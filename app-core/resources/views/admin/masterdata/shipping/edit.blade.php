@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>Edit Shipping Service</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('masterdata.shipping.update', $shippingService->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" name="name" class="form-control" value="{{ $shippingService->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Service</button>
    </form>
</div>
@endsection
