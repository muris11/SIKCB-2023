</main>

<footer class="bg-dark text-light py-3 mt-auto">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h6 class="mb-1 text-mustard"><i class="fas fa-shield-alt me-2"></i>SIKC B 2023 Admin Panel</h6>
        <p class="mb-0 small opacity-75">Sistem manajemen konten untuk mengelola semester, kelas, users, dan gallery.</p>
      </div>
      <div class="col-md-6 text-md-end">
        <div class="mb-1">
          <a href="<?= url('admin') ?>" class="text-light text-decoration-none me-3">
            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
          </a>
          <a href="<?= url('admin/users') ?>" class="text-light text-decoration-none me-3">
            <i class="fas fa-users me-1"></i>Users
          </a>
          <a href="<?= url('admin/semesters') ?>" class="text-light text-decoration-none me-3">
            <i class="fas fa-calendar me-1"></i>Semester
          </a>
          <a href="<?= url('admin/classes') ?>" class="text-light text-decoration-none">
            <i class="fas fa-chalkboard-teacher me-1"></i>Kelas
          </a>
        </div>
        <p class="mb-0 small text-muted opacity-75">
          &copy; <?= date('Y') ?> SIKC B 2023 Admin • Version 1.0
        </p>
      </div>
    </div>
  </div>
</footer>

<style>
.text-mustard {
    color: #D4AF37 !important;
}

footer {
    background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%) !important;
    border-top: 3px solid #D4AF37;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
}

footer a {
    transition: all 0.3s ease;
}

footer a:hover {
    color: #D4AF37 !important;
    transform: translateY(-1px);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

<script>
// ✅ Modern Alert System JavaScript for Admin Panel
document.addEventListener('DOMContentLoaded', function() {
  // Auto-dismiss alerts after 6 seconds
  const alerts = document.querySelectorAll('.alert-modern');
  alerts.forEach((alert, index) => {
    // Stagger the animation delay
    alert.style.animationDelay = `${index * 0.1}s`;
    
    // Auto dismiss after 6 seconds
    setTimeout(() => {
      if (alert && alert.parentNode) {
        dismissAlert(alert);
      }
    }, 6000 + (index * 200)); // Stagger dismissal too
  });
  
  // Enhanced close button functionality
  document.querySelectorAll('.btn-close-modern').forEach(btn => {
    btn.addEventListener('click', function() {
      const alert = this.closest('.alert-modern');
      dismissAlert(alert);
    });
  });
});

function dismissAlert(alert) {
  alert.style.animation = 'slideOutUp 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
  setTimeout(() => {
    if (alert && alert.parentNode) {
      alert.remove();
    }
  }, 300);
}

// Function to show dynamic alerts for admin actions
function showAdminAlert(message, type = 'info', duration = 6000) {
  const alertContainer = document.querySelector('.alert-container-admin') || createAdminAlertContainer();
  
  const icons = {
    'success': 'bi-check-circle-fill',
    'error': 'bi-exclamation-triangle-fill',
    'danger': 'bi-exclamation-triangle-fill', 
    'warning': 'bi-exclamation-circle-fill',
    'info': 'bi-info-circle-fill'
  };
  
  const alertHTML = `
    <div class="alert-modern alert-modern-${type} alert-dismissible fade show mt-3" role="alert">
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

function createAdminAlertContainer() {
  const container = document.createElement('div');
  container.className = 'alert-container-admin';
  const main = document.querySelector('main.container-fluid');
  if (main) {
    main.insertBefore(container, main.firstChild);
  }
  return container;
}

// Confirm delete actions
document.addEventListener('click', function(e) {
  if (e.target.closest('.btn-danger[onclick*="delete"], .btn-outline-danger[onclick*="delete"]')) {
    const actionText = e.target.textContent.trim().toLowerCase();
    const confirmMessage = `Apakah Anda yakin ingin ${actionText}? Tindakan ini tidak dapat dibatalkan.`;
    
    if (!confirm(confirmMessage)) {
      e.preventDefault();
      e.stopPropagation();
      return false;
    }
  }
});
</script>
</body>
</html>
<?php
// Flush output buffer to prevent headers already sent error
if (ob_get_level()) {
    ob_end_flush();
}
?>
