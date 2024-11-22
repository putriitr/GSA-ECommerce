<link href="{{ asset('assets/member/css/login__modal.css')}}" rel="stylesheet">


<!-- Modal 1: Memasukkan Email atau Nomor HP -->
<div id="emailModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <h2 class="modal-title">{{ __('messages.login_modal.email_modal.title') }}</h2>
            <a href="{{ route('register') }}" class="register-link">{{ __('messages.login_modal.email_modal.register') }}</a>

            <!-- Form untuk memasukkan email atau nomor HP -->
            <form id="emailForm">
                <div class="input-group">
                    <label for="emailOrPhone">Email</label>
                    <input type="text" id="emailOrPhone" name="emailOrPhone" placeholder="{{ __('messages.login_modal.email_modal.email_placeholder') }}" required>
                </div>

                <a href="#" class="help-link" onclick="showHelpNotification(event)">{{ __('messages.login_modal.email_modal.help_link') }}</a>

                <div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; background: #007bff; color: #fff; padding: 15px 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000;">
                    <span id="notification-message"></span>
                </div>
                
                
                <!-- Tombol Selanjutnya -->
                <button type="button" class="btn-submit" disabled>{{ __('messages.login_modal.email_modal.next_button') }}</button>

                <div class="separator">{{ __('messages.login_modal.email_modal.other_methods') }}</div>
                <button class="btn-other-methods">{{ __('messages.login_modal.email_modal.other_methods_button') }}</button>
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
            <h2 class="modal-title">{{ __('messages.login_modal.password_modal.title') }}</h2>
            <button class="btn-back register-link">&larr;</button>

            
            <form id="passwordForm">
                <div class="input-group">
                    <label for="password">{{ __('messages.login_modal.password_modal.password_label') }}</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <!-- Pesan Error -->
                <div id="error-message" class="error-message" style="display: none; color: red;">{{ __('messages.login_modal.password_modal.error_message') }}</div>

                <!-- Tombol Login -->
                <button type="submit" class="btn-submit">{{ __('messages.login_modal.password_modal.login_button') }}</button>
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
            <h2 class="modal-title">{{ __('messages.login_modal.other_methods_modal.title') }}</h2>
            <button class="btn-back register-link">&larr;</button>

            <!-- Google Login Button -->
            <button class="btn-google-login">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="google-icon">
                Google
            </button>
            
{{--             <button class="btn-facebook-login mt-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="facebook-icon">
                Facebook
            </button>
 --}}
                        <!-- Facebook Login Button -->
                        <button class="btn-facebook-login mt-2" onclick="showDevelopmentMessage()">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="facebook-icon">
                            Facebook
                        </button>

            <div id="developmentMessage" style="display: none; margin-top: 20px; padding: 10px; background: #ffcccb; color: #a94442; border: 1px solid #a94442; border-radius: 5px;">
                Fitur Facebook Login masih dalam pengembangan.
            </div>
        </div>
    </div>
</div>

<!-- Notification Box -->
<div id="notification" class="custom-notification-modal-login" style="display: none;">
    <p>{{ __('messages.login_modal.notification.message') }}</p>
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
    function showDevelopmentMessage() {
        const messageElement = document.getElementById('developmentMessage');
        messageElement.style.display = 'block'; // Tampilkan pesan
        setTimeout(() => {
            messageElement.style.display = 'none'; // Sembunyikan pesan setelah 5 detik
        }, 5000); // Waktu dalam milidetik
    }
</script>


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








<script>
    function showHelpNotification(event) {
        event.preventDefault(); // Mencegah link berpindah halaman
        const adminWaNumber = "{{ $parameter->nomor_wa ?? 'nomor WhatsApp belum disediakan' }}"; // Ambil nomor WA dari backend
        const message = adminWaNumber
            ? `Silahkan hubungi admin melalui no WhatsApp: ${adminWaNumber}`
            : "Nomor WhatsApp admin belum tersedia.";

        const notification = document.getElementById('notification');
        const messageElement = document.getElementById('notification-message');
        
        // Tampilkan pesan
        messageElement.textContent = message;
        notification.style.display = 'block';

        // Sembunyikan setelah 5 detik
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);
    }
</script>


<style>
    #notification {
        animation: fadeIn 0.5s, fadeOut 0.5s 4.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
</style>







<script src="{{ asset('assets/member/js/login__modal.js')}}"></script>
