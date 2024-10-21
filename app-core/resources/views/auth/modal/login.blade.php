<link href="{{ asset('assets/member/css/login__modal.css')}}" rel="stylesheet">


<!-- Modal 1: Memasukkan Email atau Nomor HP -->
<div id="emailModal" class="custom-modal" style="display: none;">
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
                    <label for="emailOrPhone">Email</label>
                    <input type="text" id="emailOrPhone" name="emailOrPhone" placeholder="Masukkan Email" required>
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
<div id="passwordModal" class="custom-modal" style="display: none;">
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
<div id="otherMethodsModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <h2 class="modal-title">Pilih Akun Untuk Masuk</h2>
            <button class="btn-back register-link">&larr;</button>

            <!-- Google Login Button -->
            <button class="btn-google-login">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="google-icon">
                Google
            </button>

            <!-- Facebook Login Button -->
            <button class="btn-facebook-login mt-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="facebook-icon">
                Facebook
            </button>
        </div>
    </div>
</div>

<!-- Notification Box -->
<div id="notification" class="custom-notification-modal-login" style="display: none;">
    <p>Fitur login dengan Facebook saat ini masih dalam proses pengembangan. Silakan menggunakan Google untuk login. Terima kasih atas pengertiannya.</p>
</div>

<style>
    .custom-notification-modal-login {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #f04e4e;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }
</style>

<script>
    // JavaScript to handle redirection for Google login
    document.querySelector('.btn-google-login').addEventListener('click', function() {
        window.location.href = "{{ url('auth/google/redirect') }}";
    });

    // JavaScript to handle Facebook button click
    document.querySelector('.btn-facebook-login').addEventListener('click', function() {
        // Show notification
        var notification = document.getElementById('notification');
        notification.style.display = 'block';

        // Hide notification after 5 seconds
        setTimeout(function() {
            notification.style.display = 'none';
        }, 5000);
    });
</script>














<script src="{{ asset('assets/member/js/login__modal.js')}}"></script>
