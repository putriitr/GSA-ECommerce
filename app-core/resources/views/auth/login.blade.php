@extends('layouts.customer.master__auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center align-items-center w-100">
        <!-- Image on the left -->
        <div class="col-md-5 text-center d-none d-md-block">
            <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Illustration" class="img-fluid mb-4">
            <h4>{{ __('messages.auth.welcome_back') }}</h4>
            <p>{{ __('messages.auth.welcome_message') }}</p>
        </div>

        <!-- Form on the right -->
        <div class="col-md-6">
            <div class="shadow-lg p-4 rounded">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">{{ __('messages.auth.login') }}</h4>
                    <p>{{ __('messages.auth.no_account') }} <a href="{{ route('register') }}">{{ __('messages.auth.register_now') }}</a></p>
                </div>

                <div class="d-grid mb-3">
                    <a href="{{ url('auth/google/redirect') }}" class="btn btn-outline-secondary btn-block">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="me-2" style="width: 20px;">
                        {{ __('messages.auth.login_with_google') }}
                    </a>
                </div>

                <div class="text-center mb-3 separator">{{ __('messages.auth.separator') }}</div>

                <form action="{{ route('login.logic') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <label for="email">{{ __('messages.auth.email_address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">{{ __('messages.auth.password') }}</label>
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
                            {{ __('messages.auth.remember_me') }}
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('messages.auth.submit_login') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
