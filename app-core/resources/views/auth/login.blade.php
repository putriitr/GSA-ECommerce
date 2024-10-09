@extends('layouts.customer.master__auth')

@section('content')

<!-- Halaman Masuk (Gabungan Modal 1 dan Modal 2) -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Masuk</h2>
            <div class="text-center mb-4">
                <a href="{{ route('register') }}" class="register-link">Daftar</a>
            </div>

            <!-- Form untuk memasukkan email/nomor HP dan password -->
            <form id="loginForm">
                <!-- Input untuk Email atau Nomor HP -->
                <div class="form-group mb-3">
                    <label for="emailOrPhone">Nomor HP atau Email</label>
                    <input type="text" id="emailOrPhone" name="emailOrPhone" class="form-control" placeholder="Masukkan Nomor HP atau Email" required>
                </div>

                <!-- Input untuk Password -->
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <!-- Pesan Error -->
                <div id="error-message" class="error-message" style="display: none; color: red;">Email atau password salah!</div>

                <!-- Tombol Login -->
                <button type="submit" class="btn btn-primary btn-block">Login</button>

                <div class="text-center mt-4 mb-3">
                    <span class="separator">atau masuk dengan</span>
                </div>

                <!-- Tombol metode lain -->
                <button type="button" class="btn btn-secondary btn-block" id="otherMethodsButton">Metode Lain</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Memilih Metode Lainnya (Google, dll.) -->
<div id="otherMethodsModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <h2 class="modal-title">Pilih Akun Untuk Masuk</h2>
            <button class="btn-back register-link">&larr;</button>
            <button class="btn-google-login">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="google-icon">
                Google
            </button>
        </div>
    </div>
</div>


<script>
    
</script>
@endsection


