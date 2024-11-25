@extends('layouts.admin.master')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Create New Category</h5> <small class="text-muted float-end">Category Information</small>
                    </div>
                    <div class="card-body">
                        <!-- Form untuk membuat kategori baru -->
                        <form action="{{ route('product.categories.store') }}" method="POST">
                            @csrf <!-- Token CSRF wajib di Laravel -->
                            
                            <!-- Input untuk Nama Kategori -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="name">Category Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Category Name" value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input untuk Slug (dihasilkan otomatis di controller) -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="slug">Slug</label>
                                <div class="col-sm-10">
                                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug (Auto-generated)" value="{{ old('slug') }}" readonly />
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Create Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
