<?php $title='Lupa Kata Sandi'; ?>
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

.auth-sikc-section {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
}

.gradient-text {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

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

.auth-card {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
}

.auth-card:hover {
  border-color: var(--mustard-light);
  box-shadow: 0 20px 50px rgba(212, 175, 55, 0.15) !important;
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

@media (max-width: 1200px) {
  .section-icon { width: 80px; height: 80px; font-size: 2.5rem; }
}
@media (max-width: 992px) {
  .section-icon { width: 70px; height: 70px; font-size: 2.2rem; }
}
@media (max-width: 768px) {
  .section-icon { width: 60px; height: 60px; font-size: 1.8rem; }
  .auth-sikc-section { padding: 3rem 0; }
  .card-body { padding: 2rem !important; }
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
                  <i class="bi bi-key-fill"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                <span class="gradient-text">Lupa Kata Sandi</span>
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Masukkan email untuk mendapat tautan reset password</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Forgot Password Form -->
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden auth-card">
          <div class="card-body p-lg-5 p-4">
            <form method="post" action="<?= url('password/forgot') ?>" class="auth-form-modern auth-form" novalidate data-loading-message="Mengirim email reset password...">
              <input type="hidden" name="_csrf" value="<?= $csrf ?>"/>
              
              <div class="form-floating mb-4">
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
              
              <button type="submit" class="btn btn-mustard-modern btn-lg w-100 mb-3">
                <i class="bi bi-send-fill me-2"></i>Kirim Tautan Reset
              </button>
              
              <div class="text-center">
                <p class="text-muted mb-0">Ingat password Anda? 
                  <a href="<?= url('login') ?>" class="text-mustard text-decoration-none fw-semibold">Masuk di sini</a>
                </p>
              </div>
            </form>
            
            <?php if(isset($resetLink) && $resetLink): ?>
            <div class="alert alert-success border-0 shadow-sm mt-4" style="border-radius: 15px;">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-check-circle-fill text-success me-2 fs-4"></i>
                  <h6 class="mb-0 fw-bold">Link Reset Password</h6>
                </div>
                <p class="mb-3">Karena sistem email belum dikonfigurasi, berikut link reset password untuk testing:</p>
                <div class="d-grid gap-2 mb-3">
                    <a href="<?= $resetLink ?>" class="btn btn-mustard-modern btn-lg">
                        <i class="bi bi-key-fill me-2"></i>Reset Password Sekarang
                    </a>
                </div>
                <hr style="border-color: rgba(0,0,0,0.1);">
                <small class="text-muted d-block">
                    <strong>URL:</strong> <?= htmlspecialchars($resetLink) ?>
                </small>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// ✅ Modern Form Validation with Indonesian Messages for Forgot Password
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.auth-form-modern');
    const emailInput = form.querySelector('#email');
    const submitBtn = form.querySelector('button[type="submit"]');
    
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
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
    
    // Validasi field
    function validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Jangan validasi jika user belum berinteraksi
        if (!hasInteracted && !value) {
            return true;
        }
        
        // Reset state
        field.classList.remove('is-invalid', 'is-valid');
        
        // Validasi email
        if (field.name === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!value || !emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Silakan masukkan alamat email yang valid';
            }
        }
        
        // Update tampilan hanya jika ada interaksi
        if (hasInteracted) {
            if (isValid && value) {
                field.classList.add('is-valid');
            } else if (!isValid) {
                field.classList.add('is-invalid');
                const feedback = field.nextElementSibling.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errorMessage;
                }
            }
        }
        
        return isValid;
    }
    
    // Track jika user sudah berinteraksi
    let hasInteracted = false;
    
    // Real-time validation
    emailInput.addEventListener('input', function() {
        hasInteracted = true;
        validateField(this);
    });
    
    emailInput.addEventListener('blur', function() {
        hasInteracted = true;
        validateField(this);
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        hasInteracted = true; // Paksa interaksi saat submit
        const isValid = validateField(emailInput);
        
        if (isValid) {
            // Tampilkan loading state dengan preloader
            if (window.preloader) {
                window.preloader.show('Mengirim email reset password...');
            }
            
            // Backup: loading state pada button
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...';
            submitBtn.disabled = true;
            
            // Submit form
            setTimeout(() => {
                this.submit();
            }, 100);
        } else {
            // Focus dan shake animation
            emailInput.focus();
            emailInput.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                emailInput.style.animation = '';
            }, 500);
        }
    });
    
    // Handle form reset jika ada error dari server
    const alertElement = document.querySelector('.alert-modern');
    if (alertElement && alertElement.classList.contains('alert-modern-error')) {
        // Reset button state jika ada error
        submitBtn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Kirim Tautan Reset';
        submitBtn.disabled = false;
    }
});
</script>
