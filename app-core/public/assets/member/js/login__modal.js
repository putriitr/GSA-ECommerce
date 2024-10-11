// Get the modals
var emailModal = document.getElementById("emailModal");
var passwordModal = document.getElementById("passwordModal");
var otherMethodsModal = document.getElementById("otherMethodsModal"); // Modal ketiga


// Close buttons
var closeButtons = document.querySelectorAll(".custom-close");
var backButton = document.querySelector(".btn-back");

// Fungsi untuk menutup modal password dan kembali ke modal email
document.querySelector('.btn-back').onclick = function() {
  passwordModal.style.display = "none"; // Tutup modal password
  emailModal.style.display = "block";   // Buka modal email
}

// Fungsi untuk tombol back di modal Metode Lainnya (Google)
document.querySelector('#otherMethodsModal .btn-back').onclick = function() {
  otherMethodsModal.style.display = "none";  // Menutup modal Metode Lainnya (Google)
  emailModal.style.display = "block";        // Membuka modal Email/Nomor HP
}


// Fungsi membuka modal pertama
document.querySelector(".btn-open-modal").onclick = function() {
  emailModal.style.display = "block";
}

document.querySelector(".btn-open-modal2").onclick = function() {
    emailModal.style.display = "block";
  }

// Fungsi untuk membuka modal ketiga (metode lainnya)
document.querySelector('.btn-other-methods').onclick = function() {
emailModal.style.display = "none"; // Tutup modal email
otherMethodsModal.style.display = "block"; // Buka modal metode lainnya
}

// Menutup modal saat tombol 'X' diklik
closeButtons.forEach(function(btn) {
    btn.onclick = function() {
        emailModal.style.display = "none";
        passwordModal.style.display = "none";
        otherMethodsModal.style.display = "none";
    };
});

// Menutup modal ketika mengklik area di luar modal
window.onclick = function(event) {
  if (event.target == emailModal || event.target == passwordModal || event.target == otherMethodsModal) {
      emailModal.style.display = "none";
      passwordModal.style.display = "none";
      otherMethodsModal.style.display = "none";
  }
}

// Fungsi validasi format email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Format email standar
    return emailRegex.test(email);
}

// Fungsi validasi format Nomor HP
function isValidPhoneNumber(phoneNumber) {
    const phoneRegex = /^[0-9]{10,15}$/;  // Nomor telepon dengan 10-15 digit angka
    return phoneRegex.test(phoneNumber);
}

// Aktifkan tombol Selanjutnya ketika user mengisi email atau nomor HP
document.getElementById('emailOrPhone').addEventListener('input', function() {
    const input = this.value.trim();
    const submitButton = document.querySelector('#emailForm .btn-submit');

    // Cek apakah input adalah email yang valid atau nomor HP yang valid
    if (isValidEmail(input) || isValidPhoneNumber(input)) {
        submitButton.disabled = false;
        submitButton.style.backgroundColor = '#007bff';
        submitButton.style.color = '#fff';
    } else {
        submitButton.disabled = true;
        submitButton.style.backgroundColor = '#ddd';
    }
});

// Tangani aksi Enter pada input email/nomor HP
document.getElementById('emailOrPhone').addEventListener('keydown', function(event) {
  if (event.key === "Enter") {
      event.preventDefault(); // Mencegah submit form default

      const input = this.value.trim();
      const submitButton = document.querySelector('#emailForm .btn-submit');

      // Cek apakah input valid (email atau nomor HP valid)
      if (isValidEmail(input) || isValidPhoneNumber(input)) {
          // Lakukan aksi yang sama dengan tombol "Selanjutnya"
          emailModal.style.display = "none";
          passwordModal.style.display = "block";
      }
  }
});

// Pindah dari emailModal ke passwordModal
document.querySelector('#emailForm .btn-submit').onclick = function() {
    emailModal.style.display = "none";
    passwordModal.style.display = "block";
}


// Validasi login
document.getElementById('passwordForm').onsubmit = function(event) {
  event.preventDefault(); // Prevent default form submission

  // Mengambil nilai input
  var emailOrPhone = document.getElementById('emailOrPhone').value;
  var password = document.getElementById('password').value;

  // Menyiapkan data yang akan dikirim ke server
  var formData = new FormData();
  formData.append('email', emailOrPhone);
  formData.append('password', password);

  // Mengirim request menggunakan fetch
  fetch('/login', {
      method: 'POST',
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
      },
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      // Handle response
      if (data.success) {
          if (data.user_type === 'admin') {
              // Redirect ke dashboard untuk admin
              window.location.href = '/dashboard';
          } else if (data.user_type === 'customer') {
              // Redirect ke home untuk customer
              window.location.href = '/';
          } else {
              // Handle kasus role yang tidak valid
              document.getElementById('error-message').innerText = 'User role tidak valid.';
              document.getElementById('error-message').style.display = 'block';
          }
      } else {
          // Menampilkan pesan error jika login gagal
          document.getElementById('error-message').innerText = 'Email atau password salah.';
          document.getElementById('error-message').style.display = 'block';
      }
  })
  .catch(error => {
      console.error('Error:', error);
      document.getElementById('error-message').innerText = 'Terjadi kesalahan pada server.';
      document.getElementById('error-message').style.display = 'block';
  });
};



