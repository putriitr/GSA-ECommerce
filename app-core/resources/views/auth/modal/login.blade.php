<link href="{{ asset('assets/member/css/login__modal.css')}}" rel="stylesheet">


<!-- Modal 1: Memasukkan Email atau Nomor HP -->
<div id="emailModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <h2 class="modal-title">Masuk</h2>
            <a href="{{ route('register')  }}" class="register-link">Daftar</a>

            <!-- Form untuk memasukkan email atau nomor HP -->
            <form id="emailForm">
                <div class="input-group">
                    <label for="emailOrPhone">Nomor HP atau Email</label>
                    <input type="text" id="emailOrPhone" name="emailOrPhone" placeholder="Masukkan Nomor HP atau Email" required>
                </div>

                <a href="#" class="help-link">Butuh bantuan?</a>

                <!-- Tombol Selanjutnya -->
                <button type="button" class="btn-submit" disabled>Selanjutnya</button>

                <div class="separator">atau masuk dengan</div>
                <button class="btn-other-methods">Metode Lain</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Memasukkan Password -->
<div id="passwordModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <h2 class="modal-title">Masukkan Password</h2>
            <button class="btn-back register-link">&larr;</button>

            
            <form id="passwordForm">
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <!-- Pesan Error -->
                <div id="error-message" class="error-message" style="display: none; color: red;">Email atau password salah!</div>

                <!-- Tombol Login -->
                <button type="submit" class="btn-submit" style="    background-color: #007bff !important; color: white !important;">Login</button>
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











<script src="{{ asset('assets/member/js/login__modal.js')}}"></script>
