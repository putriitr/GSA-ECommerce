@extends('layouts.customer.master__auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center align-items-center w-100">
        <!-- Image on the left -->
        <div class="col-md-5 text-center mb-4 mb-md-0">
            <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Illustration" class="img-fluid mb-4">
            <h4>Jual Beli Mudah Hanya di Toko Anda</h4>
            <p>Gabung dan rasakan kemudahan bertransaksi di toko Anda</p>
        </div>

        <!-- Form on the right -->
        <div class="col-md-6">
            <div class="shadow-lg p-4 rounded bg-white">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">{{ __('Daftar Sekarang') }}</h4>
                    <p>Sudah punya akun? <a href="{{ route('home') }}" class="btn-open-modal">Masuk</a></p>
                </div>

                <div class="d-grid mb-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-block">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="me-2" style="width: 20px;">
                        {{ __('Daftar dengan Google') }}
                    </a>
                </div>

                <div class="text-center mb-3 separator">atau</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group mb-3">
                        <label for="name">{{ __('Username') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group mb-3">
                        <label for="phone">{{ __('Nomor HP') }}</label>
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <label for="password-confirm">{{ __('Konfirmasi Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Daftar') }}
                        </button>
                    </div>

                </form>

                <!-- Optional Terms and Privacy -->
                <div class="text-center mt-4">
                    <small>Dengan mendaftar, saya menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
