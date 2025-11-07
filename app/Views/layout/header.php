<?php
use App\Core\Auth;
use App\Core\Session;

// Load config: prefer production on non-localhost
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$isLocal = $host === 'localhost' || $host === '127.0.0.1' || preg_match('/^localhost:\\d+$/', $host);
$prod = __DIR__ . '/../../Config/config_production.php';
$dev  = __DIR__ . '/../../Config/config.php';
if (!$isLocal && is_file($prod)) { require_once $prod; }
else { require_once $dev; }

$csrf = Session::csrf();

// Ambil user berdasarkan ID dari database langsung
$currentUser = null;
$displayName = 'Pengguna';

if (Auth::check()) {
    $userId = $_SESSION['user_id'] ?? 0;
    if ($userId > 0 && isset($GLOBALS['pdo'])) {
        $stmt = $GLOBALS['pdo']->prepare('SELECT name, email, role FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($currentUser && !empty(trim($currentUser['name']))) {
            $displayName = trim($currentUser['name']);
        } elseif ($currentUser && !empty($currentUser['email'])) {
            $displayName = ucfirst(explode('@', $currentUser['email'])[0]);
        }
    }
}
?>
<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
<meta charset="utf-8"/>
  <!-- 🔒 SECURITY: Content Security Policy -->
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; connect-src 'self' https://www.google-analytics.com https://www.googletagmanager.com; frame-src 'self' https://www.google.com https://maps.google.com; child-src 'self' https://www.google.com https://maps.google.com; frame-ancestors 'none'; base-uri 'self'; form-action 'self';">
  <meta http-equiv="X-Content-Type-Options" content="nosniff">
  <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
  <meta http-equiv="X-XSS-Protection" content="1; mode=block">
  <meta name="referrer" content="strict-origin-when-cross-origin">
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <?php
  // 🚀 DYNAMIC SEO OPTIMIZATION
  $pageTitle = htmlspecialchars($title ?? APP_NAME);
  $pageDescription = $seo_description ?? 'Portal kelas SIKC B 2023 dengan album per semester. Platform untuk belajar, berkolaborasi, dan menyimpan kenangan indah bersama teman-teman sekelas.';
  $pageKeywords = $seo_keywords ?? 'SIKC B 2023, Polindra, Smart City, Portal Kelas, Album Semester, Mahasiswa, Sistem Informasi Kota Cerdas, Galeri Foto, CMS Kelas';
  $pageUrl = rtrim(url(), '/') . ($_SERVER['REQUEST_URI'] ?? '');
  $pageImage = $seo_image ?? rtrim(url(), '/') . '/assets/images/lg.png';
  ?>
  <title><?= $pageTitle ?></title>

  <!-- 🎯 ADVANCED SEO META TAGS -->
  <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>">
  <meta name="author" content="SIKC B 2023 - Politeknik Negeri Indramayu">
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta name="googlebot" content="index, follow">
  <meta name="language" content="ID">
  <meta name="geo.region" content="ID-JB">
  <meta name="geo.placename" content="Indramayu, Jawa Barat">
  <meta name="distribution" content="global">
  <meta name="rating" content="general">

  <!-- ✅ Favicon / Icons -->
  <link rel="icon" type="image/svg+xml" href="<?= url('favicon.svg') ?>?v=<?= time() ?>">
  <link rel="icon" type="image/png" href="<?= url('favicon.png') ?>?v=<?= time() ?>">
  <link rel="shortcut icon" href="<?= url('favicon.ico') ?>?v=<?= time() ?>">
  <link rel="apple-touch-icon" href="<?= url('favicon.png') ?>?v=<?= time() ?>">

  <!-- 🌐 ENHANCED OPEN GRAPH / SOCIAL SHARING -->
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:type" content="<?= $og_type ?? 'website' ?>">
  <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="SIKC B 2023 - Portal Kelas">
  <meta property="og:locale" content="id_ID">
  <meta property="article:author" content="SIKC B 2023">

  <!-- 🐦 ENHANCED TWITTER CARDS -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">
  <meta name="twitter:creator" content="@sikc_b_2023">
  <meta name="twitter:site" content="@sikc_b_2023">

  <!-- 📱 MOBILE & APP META -->
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="SIKC B 2023">
  <meta name="theme-color" content="#D4AF37">
  <meta name="msapplication-TileColor" content="#D4AF37">

  <!-- 🔍 GOOGLE SEARCH ENHANCEMENTS -->
  <meta itemprop="name" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta itemprop="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta itemprop="image" content="<?= htmlspecialchars($pageImage) ?>">

  <!-- 🎯 RICH STRUCTURED DATA (JSON-LD) for Google Rich Snippets -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "SIKC B 2023 - Portal Kelas",
    "alternateName": "Sistem Informasi Kota Cerdas B 2023",
    "url": "<?= rtrim(url(), '/') ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?= rtrim(url(), '/') ?>/assets/images/lg.png",
      "width": 400,
      "height": 400
    },
    "description": "<?= htmlspecialchars($pageDescription) ?>",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Jl. Lohbener Lama No.08",
      "addressLocality": "Indramayu",
      "addressRegion": "Jawa Barat",
      "postalCode": "45252",
      "addressCountry": "ID"
    },
    "parentOrganization": {
      "@type": "EducationalOrganization",
      "name": "Politeknik Negeri Indramayu",
      "url": "https://polindra.ac.id"
    },
    "sameAs": [
      "https://instagram.com/sikc3b_polindra/",
      "https://polindra.ac.id"
    ],
    "contactPoint": {
      "@type": "ContactPoint",
      "contactType": "Academic Support",
      "availableLanguage": "Indonesian"
    }
  }
  </script>

  <?php if (isset($og_type) && $og_type === 'article'): ?>
  <!-- 📄 ARTICLE STRUCTURED DATA -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?= htmlspecialchars($pageTitle) ?>",
    "description": "<?= htmlspecialchars($pageDescription) ?>",
    "image": "<?= htmlspecialchars($pageImage) ?>",
    "author": {
      "@type": "Organization",
      "name": "SIKC B 2023"
    },
    "publisher": {
      "@type": "Organization",
      "name": "SIKC B 2023",
      "logo": {
        "@type": "ImageObject",
        "url": "<?= rtrim(url(), '/') ?>/assets/images/lg.png"
      }
    },
    "datePublished": "<?= date('c') ?>",
    "dateModified": "<?= date('c') ?>",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "<?= htmlspecialchars($pageUrl) ?>"
    }
  }
  </script>
  <?php endif; ?>

  <!-- 🌐 WEBSITE STRUCTURED DATA -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "SIKC B 2023 - Portal Kelas",
    "url": "<?= rtrim(url(), '/') ?>",
    "description": "<?= htmlspecialchars($pageDescription) ?>",
    "potentialAction": {
      "@type": "SearchAction",
      "target": {
        "@type": "EntryPoint",
        "urlTemplate": "<?= rtrim(url(), '/') ?>/search?q={search_term_string}"
      },
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="<?= url('assets/style.css') ?>" rel="stylesheet"/>
  <!-- Performance hints for shared hosting -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
  <link rel="preconnect" href="https://unpkg.com" crossorigin>
  <link rel="dns-prefetch" href="//unpkg.com">
  <link rel="preconnect" href="https://www.google.com" crossorigin>
  <link rel="preconnect" href="https://maps.google.com" crossorigin>
  <style>
:root {
  --mustard: #D4AF37;
  --mustard-dark: #B8941F;
}

/* ✅ Universal Preloader Styles */
/* ✨ Ultra-Modern Preloader Design */
.preloader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #FFF8E7 0%, #FFFEF9 50%, #FFF5DC 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  opacity: 1;
  visibility: visible;
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  pointer-events: all;
}

.preloader-overlay.hide {
  opacity: 0;
  visibility: hidden;
  transform: scale(1.1);
  pointer-events: none;
}

.preloader-overlay.show {
  opacity: 1;
  visibility: visible;
  transform: scale(1);
}

/* 🎨 Preloader Content Container */
.preloader-content {
  text-align: center;
  position: relative;
  padding: 2rem;
}

/* 🎓 Animated Graduation Cap Logo */
.preloader-logo {
  width: 100px;
  height: 100px;
  margin: 0 auto 2rem;
  position: relative;
  animation: float 3s ease-in-out infinite;
}

.preloader-logo::before {
  content: '🎓';
  font-size: 4rem;
  display: block;
  animation: rotate3d 4s ease-in-out infinite;
  filter: drop-shadow(0 10px 20px rgba(212, 175, 55, 0.3));
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(5deg);
  }
}

@keyframes rotate3d {
  0%, 100% {
    transform: rotateY(0deg) rotateX(0deg);
  }
  25% {
    transform: rotateY(180deg) rotateX(10deg);
  }
  50% {
    transform: rotateY(360deg) rotateX(0deg);
  }
  75% {
    transform: rotateY(180deg) rotateX(-10deg);
  }
}

/* 🌀 Unique Orbital Spinner */
.preloader-spinner {
  width: 120px;
  height: 120px;
  margin: 0 auto 1.5rem;
  position: relative;
}

.orbit {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: var(--mustard);
  animation: orbit-rotate 2s linear infinite;
}

.orbit:nth-child(2) {
  width: 80%;
  height: 80%;
  top: 10%;
  left: 10%;
  border-top-color: var(--mustard-dark);
  animation-duration: 1.5s;
  animation-direction: reverse;
}

.orbit:nth-child(3) {
  width: 60%;
  height: 60%;
  top: 20%;
  left: 20%;
  border-top-color: var(--mustard-light);
  animation-duration: 1s;
}

.orbit::after {
  content: '';
  position: absolute;
  width: 12px;
  height: 12px;
  background: var(--mustard);
  border-radius: 50%;
  top: -6px;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 0 0 15px var(--mustard);
  animation: pulse-dot 1s ease-in-out infinite;
}

@keyframes orbit-rotate {
  to {
    transform: rotate(360deg);
  }
}

@keyframes pulse-dot {
  0%, 100% {
    transform: translateX(-50%) scale(1);
    opacity: 1;
  }
  50% {
    transform: translateX(-50%) scale(1.5);
    opacity: 0.5;
  }
}

/* 📝 Loading Text with Typewriter Effect */
.preloader-text {
  color: var(--mustard-dark);
  font-size: 1.1rem;
  font-weight: 600;
  margin-top: 0.5rem;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  position: relative;
  display: inline-block;
}

.preloader-text::after {
  content: '';
  display: inline-block;
  width: 3px;
  height: 1.2em;
  background: var(--mustard);
  margin-left: 4px;
  animation: blink 0.8s step-end infinite;
  vertical-align: middle;
}

@keyframes blink {
  0%, 50% { opacity: 1; }
  51%, 100% { opacity: 0; }
}

/* 💫 Particle Background Effect */
.preloader-particles {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  overflow: hidden;
  pointer-events: none;
}

.particle {
  position: absolute;
  width: 4px;
  height: 4px;
  background: var(--mustard);
  border-radius: 50%;
  opacity: 0;
  animation: particle-float 4s ease-in-out infinite;
  box-shadow: 0 0 8px var(--mustard-light);
}

.particle:nth-child(1) { left: 10%; animation-delay: 0s; }
.particle:nth-child(2) { left: 20%; animation-delay: 0.5s; }
.particle:nth-child(3) { left: 30%; animation-delay: 1s; }
.particle:nth-child(4) { left: 40%; animation-delay: 1.5s; }
.particle:nth-child(5) { left: 50%; animation-delay: 2s; }
.particle:nth-child(6) { left: 60%; animation-delay: 2.5s; }
.particle:nth-child(7) { left: 70%; animation-delay: 3s; }
.particle:nth-child(8) { left: 80%; animation-delay: 3.5s; }
.particle:nth-child(9) { left: 90%; animation-delay: 4s; }

@keyframes particle-float {
  0% {
    transform: translateY(100vh) scale(0);
    opacity: 0;
  }
  50% {
    opacity: 0.5;
  }
  100% {
    transform: translateY(-100px) scale(1);
    opacity: 0;
  }
}

/* 🎪 Top Page Loading Bar */
.page-loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: transparent;
  z-index: 9999;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.page-loading.show {
  opacity: 1;
}

.page-loading-bar {
  height: 100%;
  background: linear-gradient(90deg, 
    transparent,
    var(--mustard) 25%,
    var(--mustard-dark) 50%,
    var(--mustard) 75%,
    transparent
  );
  background-size: 200% 100%;
  width: 0%;
  transition: width 0.3s ease;
  animation: shimmer 1.5s ease-in-out infinite;
  box-shadow: 0 0 10px var(--mustard);
}

@keyframes shimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}

/* 📱 Responsive Design */
@media (max-width: 768px) {
  .preloader-logo {
    width: 80px;
    height: 80px;
  }
  
  .preloader-logo::before {
    font-size: 3rem;
  }
  
  .preloader-spinner {
    width: 100px;
    height: 100px;
  }
  
  .preloader-text {
    font-size: 0.95rem;
  }
}

/* ♿ Accessibility - Reduced Motion */
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
/* Modern Navbar Styling */
.navbar-modern {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-modern.shadow-lg {
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
}

/* Brand Modern */
.navbar-brand-modern {
  font-size: 1.5rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  transition: all 0.3s ease;
}

.navbar-brand-modern:hover {
  transform: scale(1.05);
}

.brand-icon-wrapper {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.brand-icon {
  font-size: 1.8rem;
  color: var(--mustard) !important;
  transition: all 0.3s ease;
}

.navbar-brand-modern:hover .brand-icon {
  transform: rotate(10deg) scale(1.1);
}

/* Nav Links Modern */
.nav-link-modern {
  font-weight: 500;
  padding: 0.75rem 1.25rem !important;
  border-radius: 12px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  display: flex;
  align-items: center;
  margin: 0 0.25rem;
}

.nav-link-modern:hover {
  background: rgba(212, 175, 55, 0.1);
  color: var(--mustard) !important;
  transform: translateY(-2px);
}

.nav-link-modern i {
  font-size: 1rem;
  transition: all 0.3s ease;
  color: var(--mustard) !important;
}

.nav-link-modern:hover i {
  transform: scale(1.2);
}

/* Buttons Modern */
.btn-modern {
  padding: 0.6rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.9rem;
  border-width: 2px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-modern:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
}

.btn-outline-primary.btn-modern,
.btn-primary.btn-modern {
  border-color: var(--mustard);
  color: var(--mustard);
  background: transparent;
}

.btn-outline-primary.btn-modern:hover,
.btn-primary.btn-modern:hover {
  background: var(--mustard);
  color: #fff;
  box-shadow: 0 8px 25px rgba(212, 175, 55, 0.25);
}

.btn-outline-danger.btn-modern:hover {
  box-shadow: 0 8px 25px rgba(220, 53, 69, 0.25);
}

/* User Info Modern */
.user-info-modern {
  background: rgba(212, 175, 55, 0.08);
  padding: 0.6rem 1.25rem;
  border-radius: 12px;
  font-size: 0.9rem;
  color: var(--mustard);
  font-weight: 500;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
}

.user-info-modern:hover {
  background: rgba(212, 175, 55, 0.12);
  transform: scale(1.02);
}

.user-info-modern i {
  font-size: 1.2rem;
  opacity: 0.8;
  color: var(--mustard) !important;
}

/* Navbar Toggler Modern */
.navbar-toggler-modern {
  border: 2px solid rgba(212, 175, 55, 0.2);
  border-radius: 10px;
  padding: 0.5rem;
  transition: all 0.3s ease;
}

.navbar-toggler-modern:hover {
  border-color: var(--mustard);
  background: rgba(212, 175, 55, 0.05);
}

.navbar-toggler-modern:focus {
  box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
}

/* Responsive Design */
@media (max-width: 992px) {
  .navbar-modern {
    background: rgba(255, 255, 255, 0.98);
  }
  
  .nav-link-modern {
    margin: 0.25rem 0;
  }
  
  .user-info-modern {
    margin: 0.5rem 0;
  }
  
  .btn-modern {
    width: 100%;
    justify-content: center;
    margin: 0.25rem 0;
  }
}

@media (max-width: 576px) {
  .navbar-brand-modern {
    font-size: 1.3rem;
  }
  
  .brand-icon {
    font-size: 1.5rem;
  }
  
  .nav-link-modern {
    padding: 0.6rem 1rem !important;
  }
}

/* Animation for page load */
@keyframes slideDown {
  from {
    transform: translateY(-100%);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.navbar-modern {
  animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Smooth scrolling enhancement */
html {
  scroll-behavior: smooth;
}

/* Focus states for accessibility */
.nav-link-modern:focus,
.btn-modern:focus {
  outline: 2px solid var(--mustard);
  outline-offset: 2px;
}

/* ✅ Modern Alert Styles */
.alert-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1050;
  max-width: 420px;
  width: 100%;
}

.alert-modern {
  background: white;
  border: none;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 4px 16px rgba(0, 0, 0, 0.08);
  margin-bottom: 12px;
  padding: 0;
  overflow: hidden;
  animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-left: 4px solid;
  transform: translateX(0);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.alert-modern:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 6px 20px rgba(0, 0, 0, 0.1);
}

.alert-modern-content {
  display: flex;
  align-items: flex-start;
  padding: 18px 20px;
  gap: 12px;
}

.alert-modern-icon {
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 14px;
  margin-top: 2px;
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
  top: 12px;
  right: 12px;
  background: none;
  border: none;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  color: #6b7280;
  cursor: pointer;
}

.btn-close-modern:hover {
  background: rgba(0, 0, 0, 0.05);
  color: #374151;
  transform: scale(1.1);
}

/* Success Alert */
.alert-modern-success {
  border-left-color: #10b981;
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-success .alert-modern-icon {
  background: rgba(16, 185, 129, 0.1);
  color: #10b981;
}

/* Error/Danger Alert */
.alert-modern-error,
.alert-modern-danger {
  border-left-color: #ef4444;
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-error .alert-modern-icon,
.alert-modern-danger .alert-modern-icon {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
}

/* Warning Alert */
.alert-modern-warning {
  border-left-color: #f59e0b;
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-warning .alert-modern-icon {
  background: rgba(245, 158, 11, 0.1);
  color: #f59e0b;
}

/* Info Alert */
.alert-modern-info {
  border-left-color: #3b82f6;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
}

.alert-modern-info .alert-modern-icon {
  background: rgba(59, 130, 246, 0.1);
  color: #3b82f6;
}

/* Alert Animations */
@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(100%);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideOutRight {
  from {
    opacity: 1;
    transform: translateX(0);
  }
  to {
    opacity: 0;
    transform: translateX(100%);
  }
}

.alert-modern.fade:not(.show) {
  animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Responsive Alert Design */
@media (max-width: 768px) {
  .alert-container {
    left: 15px;
    right: 15px;
    top: 15px;
    max-width: none;
  }
  
  .alert-modern-content {
    padding: 16px 18px;
  }
  
  .alert-modern-message {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .alert-container {
    left: 10px;
    right: 10px;
    top: 10px;
  }
  
  .alert-modern-content {
    padding: 14px 16px;
    gap: 10px;
  }
  
  .alert-modern-icon {
    width: 20px;
    height: 20px;
    font-size: 12px;
  }
}

/* Auto-dismiss animation */
.alert-modern[data-auto-dismiss] {
  position: relative;
}

.alert-modern[data-auto-dismiss]:before {
  content: '??';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 2px;
  background: currentColor;
  opacity: 0.3;
  animation: progressBar 5s linear;
}

@keyframes progressBar {
  from { width: 100%; }
  to { width: 0%; }
}
</style>
</head>
<body>

<!-- 🌟 Ultra-Modern Preloader -->
<div id="universal-preloader" class="preloader-overlay">
  <!-- Particle Background -->
  <div class="preloader-particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>
  
  <div class="preloader-content">
    <!-- Animated Logo -->
    <div class="preloader-logo"></div>
    
    <!-- Orbital Spinner (Main Loading) -->
    <div class="preloader-spinner">
      <div class="orbit"></div>
      <div class="orbit"></div>
      <div class="orbit"></div>
    </div>
    
    <!-- Loading Text -->
    <div class="preloader-text">Memuat halaman</div>
  </div>
</div>

<!-- Page Loading Bar -->
<div id="page-loading-bar" class="page-loading">
  <div class="page-loading-bar"></div>
</div>

<nav class="navbar navbar-expand-lg navbar-modern sticky-top shadow-lg">
  <div class="container">
    <a class="navbar-brand navbar-brand-modern fw-bold" href="<?= url() ?>">
      <div class="brand-icon-wrapper">
        <i class="bi bi-mortarboard brand-icon text-mustard"></i>
      </div>
      SIKC B<span class="text-mustard">2023</span>
    </a>
    <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-link-modern" href="<?= url() ?>">
            <i class="bi bi-collection me-1"></i>Album Semester
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-modern" href="<?= url('about') ?>">
            <i class="bi bi-info-circle me-1"></i>About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-modern" href="<?= url('contact') ?>">
            <i class="bi bi-telephone me-1"></i>Contact
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-modern" href="<?= url('dashboard') ?>">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
          </a>
        </li>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if (!Auth::check()): ?>
          <a class="btn btn-outline-primary btn-modern" href="<?= url('login') ?>">
            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
          </a>
          <a class="btn btn-primary btn-modern" href="<?= url('register') ?>">
            <i class="bi bi-person-plus me-1"></i>Daftar
          </a>
        <?php else: ?>
          <div class="user-info-modern">
            <i class="bi bi-person-circle me-2"></i>
            <span>Halo, <strong><?= htmlspecialchars($displayName) ?></strong></span>
          </div>
          <a class="btn btn-outline-danger btn-modern" href="<?= url('logout') ?>">
            <i class="bi bi-box-arrow-right me-1"></i>Keluar
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
  <?php if (!empty($flashes)): ?>
    <div class="alert-container">
      <?php foreach ($flashes as $f): ?>
        <div class="alert-modern alert-modern-<?= htmlspecialchars($f['t'] ?? 'info') ?> alert-dismissible fade show" role="alert">
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





