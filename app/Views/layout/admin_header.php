<?php
// Load config: prefer production on non-localhost
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$isLocal = $host === 'localhost' || $host === '127.0.0.1' || preg_match('/^localhost:\\d+$/', $host);
$prod = __DIR__ . '/../../Config/config_production.php';
$dev  = __DIR__ . '/../../Config/config.php';
if (!$isLocal && is_file($prod)) { require_once $prod; }
else { require_once $dev; }
use App\Core\Auth;
use App\Core\Session;

// Start output buffering to prevent headers already sent error
ob_start();

$csrf = Session::csrf();

// Ambil user admin berdasarkan ID dari database langsung
$currentUser = null;
$displayName = 'Admin';
if (Auth::check()) {
    $userId = $_SESSION['user_id'] ?? 0;
    if ($userId > 0 && isset($GLOBALS['pdo'])) {
        try {
            $stmt = $GLOBALS['pdo']->prepare('SELECT name, email, role FROM users WHERE id = ? AND role = "admin"');
            $stmt->execute([$userId]);
            $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($currentUser && !empty(trim($currentUser['name']))) {
                $displayName = trim($currentUser['name']);
            } elseif ($currentUser && !empty($currentUser['email'])) {
                $displayName = ucfirst(explode('@', $currentUser['email'])[0]);
            }
        } catch (Exception $e) {
            // Suppress any database errors that might cause output
            error_log('Admin header database error: ' . $e->getMessage());
        }
    }
}
?><!doctype html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= htmlspecialchars($title ?? 'Admin Panel') ?></title>
  <link rel="icon" type="image/svg+xml" href="<?= url('favicon.svg') ?>?v=<?= time() ?>">
  <link rel="icon" type="image/png" href="<?= url('favicon.png') ?>?v=<?= time() ?>">
  <link rel="shortcut icon" href="<?= url('favicon.ico') ?>?v=<?= time() ?>">
  <link rel="apple-touch-icon" href="<?= url('favicon.png') ?>?v=<?= time() ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="<?= url('assets/style.css') ?>" rel="stylesheet"/>
  <style>
/* ✅ Modern Alert Styles for Admin Panel */
.alert-container-admin {
  margin: 0;
  padding: 0;
}

.alert-modern {
  background: white;
  border: none;
  border-radius: 12px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06);
  margin-bottom: 12px;
  padding: 0;
  overflow: hidden;
  animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border-left: 4px solid;
  transform: translateY(0);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.alert-modern:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12), 0 3px 10px rgba(0, 0, 0, 0.08);
}

.alert-modern-content {
  display: flex;
  align-items: flex-start;
  padding: 16px 18px;
  gap: 12px;
}

.alert-modern-icon {
  flex-shrink: 0;
  width: 22px;
  height: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 13px;
  margin-top: 1px;
}

.alert-modern-message {
  flex: 1;
  font-size: 14px;
  line-height: 1.5;
  font-weight: 500;
  color: #374151;
}

.btn-close-modern {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  color: #6b7280;
  cursor: pointer;
  font-size: 11px;
}

.btn-close-modern:hover {
  background: rgba(0, 0, 0, 0.05);
  color: #374151;
  transform: scale(1.1);
}

/* Success Alert */
.alert-modern-success {
  border-left-color: #10b981;
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-success .alert-modern-icon {
  background: rgba(16, 185, 129, 0.12);
  color: #10b981;
}

/* Error/Danger Alert */
.alert-modern-error,
.alert-modern-danger {
  border-left-color: #ef4444;
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-error .alert-modern-icon,
.alert-modern-danger .alert-modern-icon {
  background: rgba(239, 68, 68, 0.12);
  color: #ef4444;
}

/* Warning Alert */
.alert-modern-warning {
  border-left-color: #f59e0b;
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-warning .alert-modern-icon {
  background: rgba(245, 158, 11, 0.12);
  color: #f59e0b;
}

/* Info Alert */
.alert-modern-info {
  border-left-color: #3b82f6;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-info .alert-modern-icon {
  background: rgba(59, 130, 246, 0.12);
  color: #3b82f6;
}

/* Alert Animations */
@keyframes slideInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideOutUp {
  from {
    opacity: 1;
    transform: translateY(0);
  }
  to {
    opacity: 0;
    transform: translateY(-20px);
  }
}

.alert-modern.fade:not(.show) {
  animation: slideOutUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Responsive Admin Alerts */
@media (max-width: 768px) {
  .alert-modern-content {
    padding: 14px 16px;
  }
  
  .alert-modern-message {
    font-size: 13px;
  }
}
  </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<!-- Admin Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= url('admin') ?>">
      <i class="fas fa-cogs me-2 text-warning"></i>Admin Panel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= url('admin') ?>"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= url('admin/users') ?>"><i class="fas fa-users me-1"></i>Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= url('admin/semesters') ?>"><i class="fas fa-calendar me-1"></i>Semester</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= url('admin/classes') ?>"><i class="fas fa-chalkboard-teacher me-1"></i>Mata Kuliah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= url('admin/gallery') ?>"><i class="fas fa-images me-1"></i>Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'mini_library' ? 'active' : '' ?>" href="<?= url('admin/mini_library') ?>">
            <i class="bi bi-collection"></i> Mini Library
          </a>
        </li>
      </ul>
      
      <ul class="navbar-nav pe-lg-4">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user me-1"></i><?= htmlspecialchars($displayName) ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= url('dashboard') ?>"><i class="fas fa-user-circle me-2"></i>Dashboard Admin</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container-fluid py-0 flex-grow-1">
  <?php 
  $flashes = Session::flashes();
  if (!empty($flashes)): ?>
    <div class="alert-container-admin">
      <?php foreach ($flashes as $f): ?>
        <div class="alert-modern alert-modern-<?= htmlspecialchars($f['t'] ?? 'info') ?> alert-dismissible fade show mt-3" role="alert">
          <div class="alert-modern-content">
            <div class="alert-modern-icon">
              <?php 
              $alertType = $f['t'] ?? 'info';
              $icons = [
                'success' => 'bi-check-circle-fill',
                'error' => 'bi-exclamation-triangle-fill',
                'danger' => 'bi-exclamation-triangle-fill',
                'warning' => 'bi-exclamation-circle-fill',
                'info' => 'bi-info-circle-fill'
              ];
              echo '<i class="bi ' . ($icons[$alertType] ?? 'bi-info-circle-fill') . '"></i>';
              ?>
            </div>
            <div class="alert-modern-message">
              <?= $f['m'] ?? '' ?>
            </div>
          </div>
          <button type="button" class="btn-close-modern" data-bs-dismiss="alert" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
