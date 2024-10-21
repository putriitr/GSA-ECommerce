@extends('layouts.customer.master')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5 mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('customer.settings.partials.sidebar')
            </div>

            <!-- Main Content: Update Profile Info & Change Password -->
            <div class="col-md-9">

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Update Card -->
                <div class="card mb-3 shadow-sm border-0 rounded-lg mt-2">
                    <div class="card-header bg-white border-bottom-0 rounded-top-lg py-2">
                        <h6 class="fw-bold text-primary mb-0">{{ __('settings.update_account_info') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label for="full_name" class="form-label text-muted small">{{ __('settings.full_name') }}</label>
                                <input type="text" class="form-control form-control-sm rounded" name="full_name" value="{{ $user->full_name }}" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label text-muted small">{{ __('settings.email') }}</label>
                                <input type="email" class="form-control form-control-sm rounded" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-2">
                                <label for="phone" class="form-label text-muted small">{{ __('settings.phone_number') }}</label>
                                <input type="text" class="form-control form-control-sm rounded" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="mb-2">
                                <label for="profile_photo" class="form-label text-muted small">{{ __('settings.select_photo') }}</label>
                                <input type="file" class="form-control form-control-sm rounded" name="profile_photo">
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 py-1 shadow-sm">{{ __('settings.save') }}</button>
                        </form>
                    </div>
                </div>

                @if(!$user->password)
                <div class="card shadow-sm border-0 rounded-lg mt-3">
                    <div class="card-header bg-white border-bottom-0 rounded-top-lg py-2">
                        <h6 class="fw-bold text-primary mb-0">{{ __('settings.create_password') }} <span class="badge bg-info">{{ __('settings.google_login') }}</span></h6>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small">{{ __('settings.no_password_notice') }}</p>
                        <form action="{{ route('user.password.create') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for="new_password" class="form-label text-muted small">{{ __('settings.new_password') }}</label>
                                <input type="password" class="form-control form-control-sm rounded" name="new_password" required>
                            </div>
                            <div class="mb-2">
                                <label for="new_password_confirmation" class="form-label text-muted small">{{ __('settings.confirm_new_password') }}</label>
                                <input type="password" class="form-control form-control-sm rounded" name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm fw-bold rounded-pill px-3 py-1 shadow-sm">{{ __('settings.create_password') }}</button>
                        </form>
                    </div>
                </div>
                @endif
                
                
                <!-- Password Update Card -->
                <div class="card shadow-sm border-0 rounded-lg mt-3">
                    <div class="card-header bg-white border-bottom-0 rounded-top-lg py-2">
                        <h6 class="fw-bold text-primary mb-0">{{ __('settings.change_password') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for="current_password" class="form-label text-muted small">{{ __('settings.current_password') }}</label>
                                <input type="password" class="form-control form-control-sm rounded" name="current_password" required>
                            </div>
                            <div class="mb-2">
                                <label for="new_password" class="form-label text-muted small">{{ __('settings.new_password') }}</label>
                                <input type="password" class="form-control form-control-sm rounded" name="new_password" required>
                            </div>
                            <div class="mb-2">
                                <label for="new_password_confirmation" class="form-label text-muted small">{{ __('settings.confirm_new_password') }}</label>
                                <input type="password" class="form-control form-control-sm rounded" name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 py-1 shadow-sm">{{ __('settings.save') }}</button>
                        </form>
                        <p class="text-muted small mt-2">{{ __('settings.password_note') }}</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
