// Get the modals
var emailModal = document.getElementById("emailModal");
var passwordModal = document.getElementById("passwordModal");
var otherMethodsModal = document.getElementById("otherMethodsModal");

// Ensure modals exist before using them
if (emailModal && passwordModal && otherMethodsModal) {

    // Close buttons
    var closeButtons = document.querySelectorAll(".custom-close");
    closeButtons.forEach(function(btn) {
        btn.onclick = function() {
            emailModal.style.display = "none";
            passwordModal.style.display = "none";
            otherMethodsModal.style.display = "none";
        };
    });

    // Function for back button in password modal to go back to email modal
    var backButtonPassword = document.querySelector('#passwordModal .btn-back');
    if (backButtonPassword) {
        backButtonPassword.onclick = function() {
            passwordModal.style.display = "none";
            emailModal.style.display = "block";
        };
    }

    // Function for back button in other methods modal to go back to email modal
    var backButtonOtherMethods = document.querySelector('#otherMethodsModal .btn-back');
    if (backButtonOtherMethods) {
        backButtonOtherMethods.onclick = function() {
            otherMethodsModal.style.display = "none";
            emailModal.style.display = "block";
        };
    }

    // Function to open the email modal
    var openModalButtons = document.querySelectorAll(".btn-open-modal, .btn-open-modal2");
    openModalButtons.forEach(function(button) {
        button.onclick = function() {
            emailModal.style.display = "block";
        };
    });

    // Function to open the other methods modal
    var otherMethodsButton = document.querySelector('.btn-other-methods');
    if (otherMethodsButton) {
        otherMethodsButton.onclick = function() {
            emailModal.style.display = "none";
            otherMethodsModal.style.display = "block";
        };
    }

    // Close the modals when clicking outside of it
    window.onclick = function(event) {
        if (event.target == emailModal) {
            emailModal.style.display = "none";
        } else if (event.target == passwordModal) {
            passwordModal.style.display = "none";
        } else if (event.target == otherMethodsModal) {
            otherMethodsModal.style.display = "none";
        }
    };

    // Email or phone validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhoneNumber(phoneNumber) {
        const phoneRegex = /^[0-9]{10,15}$/;
        return phoneRegex.test(phoneNumber);
    }

    // Enable "Next" button when email or phone is valid
    var emailOrPhoneInput = document.getElementById('emailOrPhone');
    if (emailOrPhoneInput) {
        emailOrPhoneInput.addEventListener('input', function() {
            const input = this.value.trim();
            const submitButton = document.querySelector('#emailForm .btn-submit');
            if (submitButton) {
                if (isValidEmail(input) || isValidPhoneNumber(input)) {
                    submitButton.disabled = false;
                    submitButton.style.backgroundColor = '#007bff';
                    submitButton.style.color = '#fff';
                } else {
                    submitButton.disabled = true;
                    submitButton.style.backgroundColor = '#ddd';
                }
            }
        });

        // Handle Enter key in email or phone input
        emailOrPhoneInput.addEventListener('keydown', function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent default form submission

                const input = this.value.trim();
                if (isValidEmail(input) || isValidPhoneNumber(input)) {
                    emailModal.style.display = "none";
                    passwordModal.style.display = "block";
                }
            }
        });
    }

    // Move from email modal to password modal
    var submitButton = document.querySelector('#emailForm .btn-submit');
    if (submitButton) {
        submitButton.onclick = function() {
            emailModal.style.display = "none";
            passwordModal.style.display = "block";
        };
    }

    // Login validation
    var passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.onsubmit = function(event) {
            event.preventDefault(); // Prevent default form submission

            var emailOrPhone = document.getElementById('emailOrPhone').value;
            var password = document.getElementById('password').value;

            // Prepare data for server
            var formData = new FormData();
            formData.append('email', emailOrPhone);
            formData.append('password', password);

            // Fetch login request
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
                        window.location.href = '/dashboard';
                    } else if (data.user_type === 'customer') {
                        window.location.href = '/';
                    } else {
                        showError('User role tidak valid.');
                    }
                } else {
                    showError('Email atau password salah.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Terjadi kesalahan pada server.');
            });
        };
    }

    // Show error message
    function showError(message) {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.innerText = message;
            errorMessage.style.display = 'block';
        }
    }

} else {
    console.error('Modals not found. Please ensure modal IDs are correct.');
}
