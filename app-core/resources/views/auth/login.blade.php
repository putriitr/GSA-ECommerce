


@extends('layouts.customer.master__auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center align-items-center w-100">
        <!-- Image on the left -->
        <div class="col-md-5 text-center d-none d-md-block">
            <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Illustration" class="img-fluid mb-4">
            <h4>Selamat Datang Kembali!</h4>
            <p>Masuk dan nikmati pengalaman berbelanja di toko Anda</p>
        </div>

        <!-- Form on the right -->
        <div class="col-md-6">
            <div class="shadow-lg p-4 rounded">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">{{ __('Masuk') }}</h4>
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                </div>

                <div class="d-grid mb-3">
                    <a href="{{-- {{ route('login.google') }} --}}" class="btn btn-outline-secondary btn-block">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="me-2" style="width: 20px;">
                        {{ __('Masuk dengan Google') }}
                    </a>
                </div>

                <div class="text-center mb-3 separator">atau</div>

                <form action="{{ route('login.logic') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                        <!-- Password -->

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Masuk') }}
                        </button>
                    </div>

                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}">{{ __('Lupa Password?') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
