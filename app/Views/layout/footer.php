</main>
<footer class="footer-modern">
  <div class="footer-main py-5">
    <div class="container">
      <div class="row g-5">
        <!-- Brand & Description -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-brand mb-4">
            <div class="brand-logo">
              <i class="bi bi-mortarboard text-mustard"></i>
              <span class="brand-text">SIKC<span class="text-mustard">B2023</span></span>
            </div>
          </div>
          <p class="footer-description mb-4">Portal kelas dengan album per semester. Platform untuk belajar, berkolaborasi, dan menyimpan kenangan indah bersama teman-teman sekelas.</p>
          
          <!-- Social Media -->
          <div class="social-links mb-4">
            <h6 class="social-title mb-3">Ikuti Kami</h6>
            <div class="social-icons">
              <!-- <a href="#" class="social-icon facebook" title="Facebook">
                <i class="bi bi-facebook"></i>
              </a> -->
              <a href="https://www.instagram.com/sikc3b_polindra/" class="social-icon instagram" title="Instagram">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="https://www.youtube.com" class="social-icon youtube" title="YouTube">
                <i class="bi bi-youtube"></i>
              </a>
              <!-- <a href="#" class="social-icon whatsapp" title="WhatsApp">
                <i class="bi bi-whatsapp"></i>
              </a> -->
            </div>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-2 col-md-6 col-6">
          <h6 class="footer-title mb-4">Menu Utama</h6>
          <ul class="footer-links">
            <li><a href="<?= url() ?>" class="footer-link">
              <i class="bi bi-collection me-2"></i>Album Semester
            </a></li>
            <li><a href="<?= url('about') ?>" class="footer-link">
              <i class="bi bi-info-circle me-2"></i>Tentang Kami
            </a></li>
            <li><a href="<?= url('contact') ?>" class="footer-link">
              <i class="bi bi-telephone me-2"></i>Kontak
            </a></li>
            <li><a href="<?= url('dashboard') ?>" class="footer-link">
              <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
          </ul>
        </div>

        <!-- Academic Links -->
        <div class="col-lg-2 col-md-6 col-6">
          <h6 class="footer-title mb-4">Akademik</h6>
          <ul class="footer-links">
            <li><a href="<?= url('semesters') ?>" class="footer-link">
              <i class="bi bi-calendar-event me-2"></i>Semua Semester
            </a></li>
            <li><a href="<?= url('gallery') ?>" class="footer-link">
              <i class="bi bi-images me-2"></i>Galeri Foto
            </a></li>
            <li><a href="<?= url('login') ?>" class="footer-link">
              <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </a></li>
          </ul>
        </div>

        <!-- Newsletter & Contact -->
        <div class="col-lg-4 col-md-6">
          <h6 class="footer-title mb-4">Tetap Terhubung</h6>
          <p class="newsletter-description mb-4">Dapatkan update terbaru tentang kegiatan kelas dan pengumuman penting.</p>
          
          <!-- Newsletter Form -->
            <div class="newsletter-form mb-4">
            <form class="d-flex" action="https://api.whatsapp.com/send" method="get" target="_blank">
              <div class="input-group newsletter-input">
              <span class="input-group-text">
                <i class="bi bi-envelope"></i>
              </span>
              <input type="email" class="form-control" name="text" placeholder="Email Anda" required>
              <input type="hidden" name="phone" value="6285773818846">
              <button class="btn btn-mustard" type="submit">
                <i class="bi bi-send"></i>
              </button>
              </div>
            </form>
            </div>

          <!-- Contact Info -->
          <div class="contact-info">
            <div class="contact-item mb-2">
              <i class="bi bi-geo-alt text-mustard me-2"></i>
              <span>Politeknik Negeri Indramayu</span>
            </div>
            <div class="contact-item mb-2">
              <i class="bi bi-telephone text-mustard me-2"></i>
              <span>+62 857 7381 8846</span>
            </div>
            <div class="contact-item">
              <i class="bi bi-envelope text-mustard me-2"></i>
              <span>memories.ofsikc23@gmail.com</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom py-3">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="copyright mb-0">
            <i class="bi bi-c-circle me-1"></i>
            © <?php echo date('Y'); ?> SIKC B 2023. All Rights Reserved.
          </p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="footer-bottom-links">
            <a href="<?= url('privacy') ?>" class="bottom-link">Privacy Policy</a>
            <a href="<?= url('terms') ?>" class="bottom-link">Terms of Service</a>
            <a href="<?= url('sitemap') ?>" class="bottom-link">Sitemap</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
:root {
  --mustard: #D4AF37;
  --mustard-dark: #B8941F;
  --mustard-light: #F5E6C3;
}

/* Modern Footer Styling */
.footer-modern {
  background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
  color: #ecf0f1;
  position: relative;
  margin-top: 5rem;
}

.footer-modern::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--mustard), var(--mustard-dark), var(--mustard));
}

/* Footer Main Section */
.footer-main {
  position: relative;
}

/* Brand Section */
.brand-logo {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  margin-bottom: 1rem;
}

.brand-logo i {
  font-size: 2.5rem;
  color: var(--mustard);
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.brand-text {
  font-size: 1.8rem;
  font-weight: 700;
  color: #ecf0f1;
}

.footer-description {
  color: #bdc3c7;
  line-height: 1.6;
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
}

/* Social Media */
.social-title {
  color: #ecf0f1;
  font-weight: 600;
  font-size: 1rem;
}

.social-icons {
  display: flex;
  gap: 0.8rem;
}

.social-icon {
  width: 45px;
  height: 45px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.2rem;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.social-icon::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
  transform: translateX(-100%);
  transition: transform 0.6s;
}

.social-icon:hover::before {
  transform: translateX(100%);
}

.social-icon.facebook {
  background: linear-gradient(135deg, #3b5998, #8b9dc3);
}

.social-icon.instagram {
  background: linear-gradient(135deg, #e4405f, #833ab4, #fccc63);
}

.social-icon.youtube {
  background: linear-gradient(135deg, #ff0000, #cc0000);
}

.social-icon.whatsapp {
  background: linear-gradient(135deg, #25d366, #128c7e);
}

.social-icon:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

/* Footer Titles */
.footer-title {
  color: var(--mustard);
  font-weight: 600;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
  position: relative;
  padding-bottom: 0.5rem;
}

.footer-title::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 30px;
  height: 2px;
  background: var(--mustard);
  border-radius: 1px;
}

/* Footer Links */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 0.8rem;
}

.footer-link {
  color: #bdc3c7;
  text-decoration: none;
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  padding: 0.3rem 0;
}

.footer-link:hover {
  color: var(--mustard);
  text-decoration: none;
  transform: translateX(8px);
}

.footer-link i {
  color: var(--mustard);
  font-size: 0.8rem;
}

/* Newsletter Section */
.newsletter-description {
  color: #bdc3c7;
  font-size: 0.9rem;
  line-height: 1.5;
}

.newsletter-input .form-control {
  border: 2px solid rgba(255,255,255,0.1);
  background: rgba(255,255,255,0.05);
  color: #ecf0f1;
  border-radius: 8px 0 0 8px;
}

.newsletter-input .form-control:focus {
  border-color: var(--mustard);
  background: rgba(255,255,255,0.1);
  color: #ecf0f1;
  box-shadow: none;
}

.newsletter-input .form-control::placeholder {
  color: rgba(236, 240, 241, 0.6);
}

.newsletter-input .input-group-text {
  background: rgba(255,255,255,0.1);
  border: 2px solid rgba(255,255,255,0.1);
  color: var(--mustard);
  border-radius: 8px 0 0 8px;
}

.btn-mustard {
  background: linear-gradient(135deg, var(--mustard), var(--mustard-dark));
  border: none;
  color: white;
  border-radius: 0 8px 8px 0;
  padding: 0.6rem 1rem;
  transition: all 0.3s ease;
}

.btn-mustard:hover {
  background: linear-gradient(135deg, var(--mustard-dark), var(--mustard));
  transform: scale(1.05);
  color: white;
}

/* Contact Info */
.contact-item {
  display: flex;
  align-items: center;
  color: #bdc3c7;
  font-size: 0.9rem;
}

.contact-item i {
  color: var(--mustard);
  font-size: 1rem;
}

/* Footer Bottom */
.footer-bottom {
  background: rgba(0,0,0,0.2);
  border-top: 1px solid rgba(255,255,255,0.1);
}

.copyright {
  color: #95a5a6;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
}

.copyright i {
  color: var(--mustard);
}

.footer-bottom-links {
  display: flex;
  gap: 1.5rem;
}

.bottom-link {
  color: #95a5a6;
  text-decoration: none;
  font-size: 0.85rem;
  transition: color 0.3s ease;
}

.bottom-link:hover {
  color: var(--mustard);
  text-decoration: none;
}

/* Responsive Design */
@media (max-width: 992px) {
  .brand-logo {
    justify-content: center;
    text-align: center;
  }
  
  .footer-description {
    text-align: center;
  }
  
  .social-icons {
    justify-content: center;
  }
}

@media (max-width: 768px) {
  .footer-bottom-links {
    justify-content: center;
    margin-top: 1rem;
  }
  
  .copyright {
    justify-content: center;
    margin-bottom: 1rem;
  }
  
  .footer-title::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .footer-links {
    text-align: center;
  }
}

@media (max-width: 576px) {
  .social-icons {
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  
  .footer-bottom-links {
    flex-direction: column;
    gap: 0.8rem;
    text-align: center;
  }
  
  .brand-logo i {
    font-size: 2rem;
  }
  
  .brand-text {
    font-size: 1.5rem;
  }
}
</style>

<script>
function handleNewsletter(event) {
  event.preventDefault();
  const email = event.target.querySelector('input[type="email"]').value;
  
  // Show success message
  const button = event.target.querySelector('button');
  const originalText = button.innerHTML;
  
  button.innerHTML = '<i class="bi bi-check-circle"></i>';
  button.disabled = true;
  
  setTimeout(() => {
    alert('Terima kasih! Email Anda telah terdaftar untuk newsletter.');
    event.target.reset();
    button.innerHTML = originalText;
    button.disabled = false;
  }, 1000);
}

// ✅ Universal Preloader System
class UniversalPreloader {
  constructor() {
    this.preloader = document.getElementById('universal-preloader');
    this.pageLoadingBar = document.getElementById('page-loading-bar');
    this.loadingBarProgress = this.pageLoadingBar?.querySelector('.page-loading-bar');
    this.autoProgressTimer = null;
    this.autoProgressValue = 10;
    this.init();
  }

  init() {
    // Preloader sudah visible by default, update text
    const textElement = this.preloader?.querySelector('.preloader-text');
    if (textElement) textElement.textContent = 'Memuat halaman...';
    
    // Show page loading bar
    this.showPageLoader(10);
    this.startAutoProgress();
    
    // Hide preloader when page is fully loaded
    window.addEventListener('load', () => {
      this.updateProgress(100);
      setTimeout(() => {
        this.hidePageLoader();
        this.hide(); // Hide main preloader too
        this.stopAutoProgress();
      }, 400);
    });

    // Hide preloader when DOM is ready (fallback)
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        this.updateProgress(70);
        // Auto-hide after DOM is ready as backup
        setTimeout(() => {
          this.hide();
          this.hidePageLoader();
          this.stopAutoProgress();
        }, 1000);
      });
    } else {
      // Page already loaded
      this.updateProgress(90);
      setTimeout(() => {
        this.hide();
        this.hidePageLoader();
        this.stopAutoProgress();
      }, 200);
    }

    // Handle navigation loading
    this.setupNavigationLoading();
    
    // Handle form submissions
    this.setupFormLoading();
    
    // Handle refresh and back/forward navigation
    this.setupPageTransitions();
  }

  // Show main preloader
  show(message = 'Memuat...') {
    if (!this.preloader) return;
    
    const textElement = this.preloader.querySelector('.preloader-text');
    if (textElement) textElement.textContent = message;
    
    this.preloader.classList.add('show');
    document.body.style.overflow = 'hidden';
    this.startAutoProgress();
  }

  // Hide main preloader
  hide() {
    if (!this.preloader) return;
    
    this.preloader.classList.remove('show');
    this.preloader.classList.add('hide');
    document.body.style.overflow = '';
    
    // Completely hide after animation
    setTimeout(() => {
      this.preloader.classList.add('hide');
      this.stopAutoProgress();
    }, 400);
  }

  // Show page loading bar
  showPageLoader(progress = 0) {
    if (!this.pageLoadingBar) return;
    
    this.pageLoadingBar.classList.add('show');
    if (this.loadingBarProgress) {
      this.loadingBarProgress.style.width = progress + '%';
    }
  }

  // Update page loading progress
  updateProgress(progress) {
    if (this.loadingBarProgress) {
      this.loadingBarProgress.style.width = Math.min(100, Math.max(0, progress)) + '%';
    }
  }

  // Auto progress for better perceived performance
  startAutoProgress() {
    if (this.autoProgressTimer) return;
    this.autoProgressValue = Math.max(10, this.autoProgressValue || 10);
    this.autoProgressTimer = setInterval(() => {
      // Ease towards 85%
      if (this.autoProgressValue < 85) {
        this.autoProgressValue += Math.max(0.2, (90 - this.autoProgressValue) * 0.03);
        this.updateProgress(this.autoProgressValue);
      } else {
        this.stopAutoProgress();
      }
    }, 120);
  }

  stopAutoProgress() {
    if (this.autoProgressTimer) {
      clearInterval(this.autoProgressTimer);
      this.autoProgressTimer = null;
    }
  }

  // Hide page loading bar
  hidePageLoader() {
    if (!this.pageLoadingBar) return;
    
    this.updateProgress(100);
    setTimeout(() => {
      this.pageLoadingBar.classList.remove('show');
      this.updateProgress(0);
    }, 200);
  }

  // Setup navigation loading
  setupNavigationLoading() {
    // Intercept link clicks
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a[href]');
      if (!link) return;
      
      const href = link.getAttribute('href');
      
      // Skip external links, anchors, and javascript links
      if (!href || 
          href.startsWith('#') || 
          href.startsWith('javascript:') || 
          href.startsWith('mailto:') || 
          href.startsWith('tel:') ||
          link.target === '_blank' ||
          href.includes('://') && !href.includes(window.location.origin)) {
        return;
      }

      // Show loading for internal navigation
      e.preventDefault(); // Prevent immediate navigation
      const linkText = link.textContent.trim();
      
      // Show preloader with custom message based on link
      let loadingMessage = 'Memuat halaman...';
      if (linkText.includes('About') || linkText.includes('Tentang')) {
        loadingMessage = 'Memuat halaman tentang...';
      } else if (linkText.includes('Contact') || linkText.includes('Kontak')) {
        loadingMessage = 'Memuat halaman kontak...';
      } else if (linkText.includes('Dashboard')) {
        loadingMessage = 'Memuat dashboard...';
      } else if (linkText.includes('Album') || linkText.includes('Semester')) {
        loadingMessage = 'Memuat album semester...';
      } else if (linkText.includes('Login') || linkText.includes('Masuk')) {
        loadingMessage = 'Memuat halaman login...';
      } else if (linkText.includes('Register') || linkText.includes('Daftar')) {
        loadingMessage = 'Memuat halaman registrasi...';
      }
      
      this.show(loadingMessage);
      this.showPageLoader(20);
      
      // Start navigation immediately, preloader will hide when page fully loads
      window.location.href = href;
    });
  }

  // Setup form loading
  setupFormLoading() {
    document.addEventListener('submit', (e) => {
      const form = e.target;
      if (!form.tagName || form.tagName !== 'FORM') return;
      
      // Skip if form has data-no-loader attribute
      if (form.hasAttribute('data-no-loader')) return;
      
      // For authentication forms, only show preloader if form is valid
      if (form.classList.contains('auth-form')) {
        // Check if form is valid before showing preloader
        const requiredFields = form.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
          }
          // Email validation
          if (field.type === 'email' && field.value && !this.isValidEmail(field.value)) {
            isValid = false;
          }
          // Password confirmation check
          if (field.name === 'confirm_password') {
            const passwordField = form.querySelector('input[name="password"]');
            if (passwordField && field.value !== passwordField.value) {
              isValid = false;
            }
          }
        });
        
        // Only show preloader if form is valid
        if (!isValid) {
          return; // Don't show preloader for invalid forms
        }
      }
      
      // Get custom loading message
      const loadingMessage = form.getAttribute('data-loading-message') || 'Memproses...';
      
      // Show preloader after a short delay to avoid flicker
      setTimeout(() => {
        this.show(loadingMessage);
        this.startAutoProgress();
      }, 50);
    });
  }
  
  // Email validation helper
  isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // Setup page transitions
  setupPageTransitions() {
    // Handle page refresh
    window.addEventListener('beforeunload', () => {
      this.show('Memuat ulang halaman...');
    });

    // Handle browser back/forward
    window.addEventListener('pageshow', (e) => {
      if (e.persisted) {
        // Page restored from cache
        this.hide();
        this.hidePageLoader();
      }
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', () => {
      this.show('Memuat halaman...');
      this.showPageLoader(10);
      
      // Auto-hide after navigation
      setTimeout(() => {
        this.hide();
        this.hidePageLoader();
      }, 800);
    });

    // Ensure preloader hides when document is interactive
    if (document.readyState === 'interactive' || document.readyState === 'complete') {
      setTimeout(() => {
        this.hide();
        this.hidePageLoader();
      }, 100);
    }

    // Auto-hide preloader if it's still showing after 4 seconds (failsafe)
    setTimeout(() => {
      this.hide();
      this.hidePageLoader();
    }, 4000);
  }

  // Method to manually trigger loading for AJAX requests
  showForPromise(promise, message = 'Memuat...') {
    this.show(message);
    
    return promise.finally(() => {
      this.hide();
    });
  }
}

// Initialize preloader
const preloader = new UniversalPreloader();

// Make preloader globally available
window.preloader = preloader;

// ✅ Modern Alert System JavaScript
document.addEventListener('DOMContentLoaded', function() {
  // Auto-dismiss alerts after 7 seconds
  const alerts = document.querySelectorAll('.alert-modern');
  alerts.forEach((alert, index) => {
    // Stagger the animation delay
    alert.style.animationDelay = `${index * 0.1}s`;
    
    // Auto dismiss after 7 seconds
    setTimeout(() => {
      if (alert && alert.parentNode) {
        dismissAlert(alert);
      }
    }, 7000 + (index * 200)); // Stagger dismissal too
  });
  
  // Enhanced close button functionality
  document.querySelectorAll('.btn-close-modern').forEach(btn => {
    btn.addEventListener('click', function() {
      const alert = this.closest('.alert-modern');
      dismissAlert(alert);
    });
  });
  
  // Swipe to dismiss on mobile
  let startX = 0;
  let currentX = 0;
  let isDragging = false;
  
  alerts.forEach(alert => {
    alert.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
      alert.style.transition = 'none';
    });
    
    alert.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      currentX = e.touches[0].clientX;
      const deltaX = currentX - startX;
      
      if (deltaX > 0) { // Only allow swipe right
        alert.style.transform = `translateX(${deltaX}px)`;
        alert.style.opacity = Math.max(0.3, 1 - (deltaX / 200));
      }
    });
    
    alert.addEventListener('touchend', () => {
      if (!isDragging) return;
      isDragging = false;
      
      const deltaX = currentX - startX;
      alert.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
      
      if (deltaX > 100) { // Dismiss if swiped far enough
        dismissAlert(alert);
      } else { // Snap back
        alert.style.transform = 'translateX(0)';
        alert.style.opacity = '1';
      }
    });
  });
});

function dismissAlert(alert) {
  alert.style.animation = 'slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
  setTimeout(() => {
    if (alert && alert.parentNode) {
      alert.remove();
    }
  }, 300);
}

// Function to show dynamic alerts (for future use)
function showAlert(message, type = 'info', duration = 7000) {
  const alertContainer = document.querySelector('.alert-container') || createAlertContainer();
  
  const icons = {
    'success': 'bi-check-circle-fill',
    'error': 'bi-exclamation-triangle-fill',
    'danger': 'bi-exclamation-triangle-fill',
    'warning': 'bi-exclamation-circle-fill',
    'info': 'bi-info-circle-fill'
  };
  
  const alertHTML = `
    <div class="alert-modern alert-modern-${type} alert-dismissible fade show" role="alert">
      <div class="alert-modern-content">
        <div class="alert-modern-icon">
          <i class="bi ${icons[type] || icons.info}"></i>
        </div>
        <div class="alert-modern-message">
          ${message}
        </div>
      </div>
      <button type="button" class="btn-close-modern" onclick="dismissAlert(this.closest('.alert-modern'))">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
  `;
  
  alertContainer.insertAdjacentHTML('afterbegin', alertHTML);
  
  const newAlert = alertContainer.firstElementChild;
  
  // Auto dismiss
  if (duration > 0) {
    setTimeout(() => {
      if (newAlert && newAlert.parentNode) {
        dismissAlert(newAlert);
      }
    }, duration);
  }
  
  return newAlert;
}

function createAlertContainer() {
  const container = document.createElement('div');
  container.className = 'alert-container';
  document.body.appendChild(container);
  return container;
}

// Toast-style notifications
function showToast(message, type = 'success') {
  return showAlert(message, type, 4000);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

<?php
// Analytics only in production
if (defined('DEVELOPMENT_MODE') && !DEVELOPMENT_MODE && file_exists(__DIR__ . '/../../../analytics_tracking.php')) {
    include __DIR__ . '/../../../analytics_tracking.php';
}
?>
</body>
</html>
