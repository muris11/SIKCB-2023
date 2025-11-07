<?php $title='Masuk'; ?>
<style>
:root {
  --mustard: #D4AF37;
  --mustard-dark: #B8941F;
  --mustard-light: #F5E6C3;
}

.text-mustard { color: var(--mustard) !important; }
.bg-mustard { background: var(--mustard) !important; }
.bg-mustard-light { background: var(--mustard-light) !important; }
.bg-gradient-mustard { background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%); }

/* Section Styling */
.auth-sikc-section {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
}

.gradient-text {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Section Icon Enhanced */
.section-icon-wrapper {
  position: relative;
  width: fit-content;
}

.section-icon {
  width: 90px;
  height: 90px;
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border-radius: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.8rem;
  color: white;
  box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
  position: relative;
  z-index: 1;
}

.icon-glow {
  position: absolute;
  inset: -10px;
  background: linear-gradient(135deg, var(--mustard-light) 0%, transparent 100%);
  border-radius: 30px;
  opacity: 0.5;
  z-index: 0;
  animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 0.5; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.05); }
}

.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, transparent, var(--mustard), transparent);
  border-radius: 2px;
}

/* Auth Card */
.auth-card {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
}

.auth-card:hover {
  border-color: var(--mustard-light);
  box-shadow: 0 20px 50px rgba(212, 175, 55, 0.15) !important;
}

/* Form Modern */
.auth-form-modern {
  margin-top: 1rem;
}

.form-control-modern {
  border-radius: 15px;
  border: 2px solid var(--mustard-light);
  padding: 1rem 1.2rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #fafafa;
}

.form-control-modern:focus {
  border-color: var(--mustard);
  box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
  background: white;
}

.form-floating > label {
  color: var(--mustard);
  font-weight: 500;
}

.btn-mustard-modern {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border: none;
  color: white;
  border-radius: 15px;
  font-weight: 600;
  padding: 1rem 2rem;
  transition: all 0.3s ease;
  box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

.btn-mustard-modern:hover {
  background: linear-gradient(135deg, var(--mustard-dark) 0%, var(--mustard) 100%);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(212, 175, 55, 0.5);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .section-icon {
    width: 80px;
    height: 80px;
    font-size: 2.5rem;
  }
}

@media (max-width: 992px) {
  .section-icon {
    width: 70px;
    height: 70px;
    font-size: 2.2rem;
  }
}

@media (max-width: 768px) {
  .section-icon {
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
  }
  
  .auth-sikc-section {
    padding: 3rem 0;
  }
  
  .card-body {
    padding: 2rem !important;
  }
}

/* ✅ Modern Form Validation Styles */
.form-control-modern {
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
}

.form-control-modern:focus {
  border-color: var(--mustard);
  box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.1);
  background: white;
}

.form-control-modern.is-invalid {
  border-color: #dc3545;
  background: rgba(220, 53, 69, 0.05);
}

.form-control-modern.is-valid {
  border-color: #198754;
  background: rgba(25, 135, 84, 0.05);
}

.invalid-feedback {
  display: block;
  font-size: 0.875rem;
  color: #dc3545;
  margin-top: 0.5rem;
  font-weight: 500;
  padding: 0.5rem 0.75rem;
  background: rgba(220, 53, 69, 0.1);
  border-radius: 8px;
  border-left: 3px solid #dc3545;
}

.valid-feedback {
  display: block;
  font-size: 0.875rem;
  color: #198754;
  margin-top: 0.5rem;
  font-weight: 500;
  padding: 0.5rem 0.75rem;
  background: rgba(25, 135, 84, 0.1);
  border-radius: 8px;
  border-left: 3px solid #198754;
}

.form-floating > .form-control-modern:focus ~ label,
.form-floating > .form-control-modern:not(:placeholder-shown) ~ label {
  color: var(--mustard);
  transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Loading state for submit button */
.btn-loading {
  position: relative;
  color: transparent !important;
}

.btn-loading::after {
  content: '';
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  margin-left: -10px;
  margin-top: -10px;
  border: 2px solid #ffffff;
  border-radius: 50%;
  border-top-color: transparent;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<section class="auth-sikc-section py-5 bg-light">
  <div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="section-icon">
                  <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                <span class="gradient-text">Masuk</span> ke SIKC B 2023
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Silakan masuk untuk mengakses dashboard Anda</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Login Form -->
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden auth-card">
          <div class="card-body p-lg-5 p-4">
            <form method="post" action="<?= url('login') ?>" class="auth-form-modern auth-form" novalidate data-loading-message="Masuk ke akun Anda...">
              <input type="hidden" name="_csrf" value="<?= $csrf ?>"/>
              
              <div class="form-floating mb-3">
                <input type="email" 
                       class="form-control form-control-modern" 
                       id="email" 
                       name="email" 
                       placeholder="Email" 
                       required
                       data-error-message="Silakan masukkan alamat email yang valid">
                <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                <div class="invalid-feedback">Silakan masukkan alamat email yang valid</div>
              </div>
              
              <div class="form-floating mb-3">
                <input type="password" 
                       class="form-control form-control-modern" 
                       id="password" 
                       name="password" 
                       placeholder="Kata Sandi" 
                       required
                       minlength="6"
                       data-error-message="Kata sandi harus diisi minimal 6 karakter">
                <label for="password"><i class="bi bi-lock-fill me-2"></i>Kata Sandi</label>
                <div class="invalid-feedback">Kata sandi harus diisi minimal 6 karakter</div>
              </div>
              
              <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="<?= url('password/forgot') ?>" class="text-mustard text-decoration-none fw-semibold">
                  <i class="bi bi-key me-1"></i>Lupa sandi?
                </a>
              </div>
              
              <button type="submit" class="btn btn-mustard-modern btn-lg w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
              </button>
              
              <div class="text-center">
                <p class="text-muted mb-0">Belum punya akun? 
                  <a href="<?= url('register') ?>" class="text-mustard text-decoration-none fw-semibold">Daftar di sini</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// ✅ Modern Form Validation with Indonesian Messages for Login Form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.auth-form-modern');
    const inputs = form.querySelectorAll('input[required]');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Pesan error dalam bahasa Indonesia
    const errorMessages = {
        email: 'Silakan masukkan alamat email yang valid',
        password: 'Kata sandi harus diisi minimal 6 karakter'
    };
    
    // Custom validation styles
    const style = document.createElement('style');
    style.textContent = `
        .form-control-modern.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 1rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4M8.2 7.4l-1.4-1.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.25rem) center;
            background-size: calc(0.75em + 0.5rem) calc(0.75em + 0.5rem);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        
        .form-control-modern.is-valid {
            border-color: #198754;
            padding-right: calc(1.5em + 1rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73-.4-.4c-.2-.2-.2-.5 0-.7L4.07 3.5c.2-.2.5-.2.7 0l2.9 2.9c.2.2.2.5 0 .7l-.4.4c-.2.2-.5.2-.7 0L4.4 5.4 2.3 7.53c-.2.2-.5.2-.7 0z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.25rem) center;
            background-size: calc(0.75em + 0.5rem) calc(0.75em + 0.5rem);
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
        
        .invalid-feedback {
            display: none !important;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        .invalid-feedback.show-error {
            display: block !important;
        }
        
        .is-invalid ~ .invalid-feedback.show-error {
            display: block !important;
        }
    `;
    document.head.appendChild(style);
    
    // Pastikan tidak ada error yang tampil saat page load
    inputs.forEach(input => {
        const feedback = input.nextElementSibling?.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.classList.remove('show-error');
            feedback.style.display = 'none';
        }
        input.classList.remove('is-invalid', 'is-valid');
    });
    
    // Track jika user sudah berinteraksi
    const interactionFlags = {};
    
    // Validasi real-time untuk setiap input
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            interactionFlags[this.name] = true;
            validateField(this);
        });
        
        input.addEventListener('blur', function() {
            interactionFlags[this.name] = true;
            validateField(this);
        });
    });
    
    // Fungsi validasi field
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';
        
        // Jangan validasi jika user belum berinteraksi dengan field ini
        if (!interactionFlags[fieldName] && !value) {
            return true;
        }
        
        // Reset state
        field.classList.remove('is-invalid', 'is-valid');
        const feedback = field.nextElementSibling?.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.classList.remove('show-error');
        }
        
        // Validasi berdasarkan field
        switch(fieldName) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value || !emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = errorMessages.email;
                }
                break;
                
            case 'password':
                if (!value || value.length < 6) {
                    isValid = false;
                    errorMessage = errorMessages.password;
                }
                break;
        }
        
        // Update tampilan hanya jika ada interaksi
        if (interactionFlags[fieldName]) {
            if (isValid && value) {
                field.classList.add('is-valid');
            } else if (!isValid) {
                field.classList.add('is-invalid');
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errorMessage;
                    feedback.classList.add('show-error');
                }
            }
        }
        
        return isValid;
    }
    
    // Validasi form saat submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isFormValid = true;
        const validationErrors = [];
        
        // Paksa validasi semua field saat submit
        inputs.forEach(input => {
            interactionFlags[input.name] = true; // Paksa interaksi flag
            if (!validateField(input)) {
                isFormValid = false;
                validationErrors.push(input.name);
            }
        });
        
        if (isFormValid) {
            // Tampilkan loading state dengan preloader
            if (window.preloader) {
                window.preloader.show('Masuk ke akun Anda...');
            }
            
            // Backup: loading state pada button
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Masuk...';
            submitBtn.disabled = true;
            
            // Submit form - preloader akan dihentikan saat halaman redirect
            setTimeout(() => {
                this.submit();
            }, 100);
        } else {
            // Focus ke field pertama yang error
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Shake animation untuk field yang error
                firstInvalid.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    firstInvalid.style.animation = '';
                }, 500);
            }
        }
    });
    
    // Handle form reset jika ada error dari server
    const alertElement = document.querySelector('.alert-modern');
    if (alertElement && alertElement.classList.contains('alert-modern-error')) {
        // Reset button state jika ada error
        submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk';
        submitBtn.disabled = false;
    }
    
    // Shake animation CSS
    const shakeStyle = document.createElement('style');
    shakeStyle.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(shakeStyle);
});
</script>
