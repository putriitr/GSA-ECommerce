@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1>FAQ Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">FAQ ID: {{ $faq->id }}</h5>
            <p class="card-text">{!! $faq->keterangan !!}</p> <!-- Display the FAQ content -->
            <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">Back to FAQ List</a>
        </div>
    </div>
</div>
@endsection
