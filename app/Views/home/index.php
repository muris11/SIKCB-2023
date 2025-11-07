<?php 
$title='Beranda - SIKC B 2023 Portal Kelas'; 
$seo_description = 'Portal kelas SIKC B 2023 Polindra dengan album semester, galeri foto, dan sistem manajemen kelas. Platform belajar dan berkolaborasi mahasiswa Sistem Informasi Kota Cerdas.';
$seo_keywords = 'SIKC B 2023, Polindra, Portal Kelas, Album Semester, Galeri Foto, Mahasiswa, Sistem Informasi Kota Cerdas, Politeknik Negeri Indramayu, CMS Pendidikan';
$og_type = 'website';

// Load config with fallback (prioritize local development)
$configCandidates = [
    __DIR__ . '/../../Config/config.php',
    __DIR__ . '/../../Config/config_production.php'
];
foreach ($configCandidates as $cfg) {
    if (is_file($cfg)) { require_once $cfg; break; }
}
if (!isset($totalUsers) || !is_numeric($totalUsers)) {
  $totalUsers = 0;
}
// VIDEO SYSTEM REMOVED - User requested removal due to persistent errors
?>

<!-- Hero Section -->
<section id="home" class="hero-enhanced py-5">
  <div class="hero-background-pattern"></div>
  <div class="container py-4 position-relative">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-fade="right">
        <div class="hero-badge mb-3">
          <span class="badge bg-mustard text-white px-4 py-2 shadow-lg">
            <i class="bi bi-house-heart-fill me-2"></i>Portal SIKC3B2023
          </span>
        </div>
        <h1 class="display-4 fw-bold hero-title mb-4">
          Selamat Datang di <br>
          <span class="gradient-text">SIKC3B2023</span>
        </h1>
        <p class="lead text-secondary mb-4 hero-description">
          Temukan pengalaman belajar yang lebih modern dan interaktif di portal <strong class="text-mustard">SIKC3B2023</strong>. 
          Di sini, setiap semester menjadi album digital yang menyimpan berbagai kenangan, dokumentasi kegiatan, serta materi pembelajaran yang dapat diakses kapan saja. 
          Kelola progres belajar, eksplorasi komunitas, dan nikmati fitur-fitur terbaru untuk mendukung perjalanan akademik Anda secara efisien dan menyenangkan.
        </p>
        <div class="d-flex flex-wrap gap-3 mt-4 mb-4">
            <a href="#album" class="btn btn-mustard btn-lg px-4 shadow-lg btn-animated d-flex align-items-center" style="border-radius: 15px;">
            <span class="fw-semibold" style="font-size:1.15em;"><i class="bi bi-collection me-2"></i>Album Semester</span>
            </a>
          <a href="<?= url('login') ?>" class="btn btn-outline-mustard btn-lg px-4 btn-animated">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
          </a>
          <a href="<?= url('about') ?>" class="btn btn-outline-mustard btn-lg px-4 btn-animated">
            <i class="bi bi-info-circle me-2"></i>About
          </a>
          <a href="<?= url('contact') ?>" class="btn btn-outline-mustard btn-lg px-4 btn-animated">
            <i class="bi bi-envelope me-2"></i>Contact
          </a>
        </div>
        <div class="user-stats-card">
          <div class="d-flex align-items-center gap-3">
            <div class="user-avatars">
              <span class="avatar-item bg-mustard">
                <i class="bi bi-person-fill text-white"></i>
              </span>
              <span class="avatar-item bg-mustard-dark">
                <i class="bi bi-person-fill text-white"></i>
              </span>
              <span class="avatar-item bg-mustard-light">
                <i class="bi bi-person-fill text-mustard"></i>
              </span>
            </div>
            <div>
              <div class="fw-bold text-dark fs-5"><?= number_format($totalUsers) ?>+</div>
              <small class="text-secondary">Mahasiswa Aktif Terdaftar</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6" data-fade="left">
        <div class="hero-card-wrapper">
          <div class="card border-0 shadow-xl rounded-5 overflow-hidden card-hover-enhanced">
            <div class="card-body p-0">
              <!-- Slider Gallery -->
              <div id="highlightCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                  <?php if (!empty($recentGallery)): ?>
                    <?php foreach (array_slice($recentGallery, 0, 5) as $index => $g): ?>
                      <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($g['image_url']) ?>" 
                             class="d-block w-100 highlight-image" loading="lazy" decoding="async"
                             alt="<?= htmlspecialchars($g['semester_name'] ?? 'Gallery') ?>">
                        <div class="carousel-caption-modern">
                          <span class="badge bg-mustard px-3 py-2 shadow">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?= htmlspecialchars($g['semester_name'] ?? 'Semester') ?>
                          </span>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="carousel-item active">
                      <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1200&auto=format&fit=crop" 
                           class="d-block w-100 highlight-image" 
                           alt="highlight">
                    </div>
                  <?php endif; ?>
                </div>
                <?php if (!empty($recentGallery) && count($recentGallery) > 1): ?>
                  <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                <?php endif; ?>
              </div>
              <div class="p-4 bg-white border-top">
                <h5 class="mb-2 text-mustard fw-bold d-flex align-items-center">
                  <span class="icon-badge me-2">
                    <i class="bi bi-stars"></i>
                  </span>
                  Highlight Semester
                </h5>
              </div>
            </div>
          </div>
          <div class="floating-element element-1">
            <i class="bi bi-mortarboard-fill"></i>
          </div>
          <div class="floating-element element-2">
            <i class="bi bi-trophy-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Album Semester Section -->
<section id="album" class="py-5 bg-white">
  <div class="container">
    <!-- Header Album Semester -->
    <div class="text-center mb-5" data-fade="up">
      <div class="section-badge mx-auto mb-3">
        <i class="bi bi-collection-fill"></i>
      </div>
      <h2 class="section-title-enhanced fw-bold mb-3">
        Album <span class="gradient-text">Semester</span>
      </h2>
      <div class="section-divider mx-auto mb-3"></div>
      <p class="text-secondary lead">Jelajahi daftar semester dan kelas di dalamnya</p>
    </div>

    <div class="row g-4">
      <?php if (empty($semesters)): ?>
        <div class="col-12">
          <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body text-center py-5">
              <div class="empty-state-icon mb-3">
                <i class="bi bi-calendar-x"></i>
              </div>
              <h4 class="text-secondary mb-2">Belum Ada Semester</h4>
              <p class="text-muted mb-4">
                Sistem sedang dalam tahap persiapan. Semester akan segera tersedia.
              </p>
              <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                <a href="<?= url('admin/semesters') ?>" class="btn btn-mustard btn-lg shadow">
                  <i class="bi bi-plus-circle me-2"></i>Kelola Semester
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($semesters as $index => $s): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-fade="up" data-delay="<?= $index * 100 ?>">
          <div class="card semester-card-enhanced border-0 shadow-lg h-100">
            <?php 
              $coverUrl = !empty($s['cover_image']) ? url('image/semester/' . $s['id']) : asset('img/placeholder.png');
            ?>
            <div class="semester-image-wrapper">
              <img src="<?= htmlspecialchars($coverUrl) ?>" class="semester-image" alt="<?= htmlspecialchars($s['name']) ?>" loading="lazy" decoding="async">
              <div class="semester-overlay-enhanced">
                <div class="overlay-icon">
                  <i class="bi bi-eye-fill"></i>
                </div>
                <span class="overlay-text">Lihat Detail</span>
              </div>
            </div>
            <div class="card-body p-3">
              <div class="mb-2">
                <span class="badge badge-semester px-3 py-2">
                  <i class="bi bi-calendar-event me-1"></i>
                  <?= htmlspecialchars($s['term_label']) ?>
                </span>
              </div>
              <h6 class="card-title fw-bold mb-2">
                <?= htmlspecialchars($s['name']) ?>
              </h6>
              <p class="card-text text-secondary small mb-0">
                <?= htmlspecialchars($s['description']) ?>
              </p>
              <a href="<?= url('semester/' . (int)$s['id']) ?>" class="stretched-link"></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <?php if (!empty($semesters)): ?>
    <div class="text-center mt-5">
      <a href="<?= url('semesters') ?>" class="btn btn-outline-mustard btn-lg px-5 shadow-sm btn-animated">
        <i class="bi bi-collection me-2"></i>Lihat Semua Semester
      </a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="py-5 bg-white" style="padding-top:2.5rem !important;">
  <div class="container" style="padding-top:0.5rem !important;">
    <!-- Header Gallery -->
    <div class="text-center mb-5" data-fade="up">
      <div class="section-badge mx-auto mb-3">
        <i class="bi bi-images"></i>
      </div>
      <h2 class="section-title-enhanced fw-bold mb-3">
        Galeri <span class="gradient-text">Foto</span>
      </h2>
      <div class="section-divider mx-auto mb-3"></div>
      <p class="text-secondary lead">Dokumentasi kegiatan dan kenangan semester</p>
    </div>

    <?php if (!empty($recentGallery)): ?>
      <!-- Modern Gallery Slider -->
      <div class="gallery-slider-container mb-5" data-fade="up" style="margin-top:-1.5rem;">
        <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-indicators carousel-indicators-custom">
            <?php foreach (array_slice($recentGallery, 0, 6) as $index => $g): ?>
              <button type="button" 
                      data-bs-target="#galleryCarousel" 
                      data-bs-slide-to="<?= $index ?>" 
                      <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                      aria-label="Slide <?= $index + 1 ?>">
              </button>
            <?php endforeach; ?>
          </div>
          
          <div class="carousel-inner rounded-5 shadow-xl overflow-hidden">
            <?php foreach (array_slice($recentGallery, 0, 6) as $index => $g): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> position-relative">
                <img src="<?= htmlspecialchars($g['image_url']) ?>"
                     class="d-block w-100 gallery-slider-image" loading="lazy" decoding="async"
                     alt="<?= htmlspecialchars($g['semester_name'] ?? 'Gallery') ?>"
                     style="cursor:pointer;object-fit:cover;width:100%;height:100%;max-height:100vh;">
                <span class="badge semester-badge-slider d-none d-md-block"
                  style="position:absolute;left:50%;transform:translateX(-50%);bottom:28px;z-index:20;opacity:0.85;background:rgba(212,175,55,0.85);color:#fff;padding:10px 24px;font-size:1.1rem;box-shadow:0 4px 12px rgba(212,175,55,0.15);border-radius:16px;">
                  <i class="bi bi-calendar3 me-2"></i>
                  <?= htmlspecialchars($g['semester_name'] ?? 'Semester') ?>
                </span>
                <div class="carousel-caption-enhanced">
                  <div class="caption-content-enhanced">
                    <?php if (!empty($g['caption'])): ?>
                      <p class="mb-0 fw-semibold fs-5" style="background:rgba(255,255,255,0.7);border-radius:12px;display:inline-block;padding:4px 12px;">
                        <?= htmlspecialchars($g['caption']) ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          
          <!-- Improved Carousel Controls -->
          <button class="carousel-control-prev carousel-control-prev-custom btn btn-mustard shadow-lg" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev" style="top: 50%; left: 10px; transform: translateY(-50%); z-index: 10; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding:0;">
            <span class="control-icon-custom" style="width:32px;height:32px;font-size:1.2rem;">
              <i class="bi bi-chevron-left"></i>
            </span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next carousel-control-next-custom btn btn-mustard shadow-lg" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next" style="top: 50%; right: 10px; transform: translateY(-50%); z-index: 10; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding:0;">
            <span class="control-icon-custom" style="width:32px;height:32px;font-size:1.2rem;">
              <i class="bi bi-chevron-right"></i>
            </span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <div class="text-center mt-5">
        <a href="<?= url('gallery') ?>" class="btn btn-outline-mustard btn-lg px-5 shadow-sm btn-animated">
          <i class="bi bi-images me-2"></i>Lihat Semua Gallery (<?= count($recentGallery) ?> Foto)
        </a>
      </div>
    <?php else: ?>
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body text-center py-5">
          <div class="empty-state-icon mb-3">
            <i class="bi bi-images"></i>
          </div>
          <h5 class="text-secondary mb-2">Belum Ada Foto Terbaru</h5>
          <p class="text-muted mb-4">Galeri akan tampil otomatis saat admin menambahkan foto.</p>
          <a href="<?= url('semesters') ?>" class="btn btn-outline-mustard shadow-sm">
            <i class="bi bi-collection me-2"></i>Lihat Semua Semester
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Modal Preview -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0 shadow-xl rounded-5">
      <div class="modal-header border-0 bg-gradient-mustard">
        <h5 class="modal-title text-mustard fw-bold">
          <i class="bi bi-image-fill me-2"></i>Preview Foto
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-4">
        <img id="modalGalleryImg" loading="lazy" decoding="async" src="" class="img-fluid w-100 rounded-4 mb-3 shadow" alt="Preview">
        <div class="text-center">
          <span id="modalGallerySemester" class="badge bg-mustard px-4 py-2 mb-2"></span>
          <p id="modalGalleryCaption" class="text-secondary lead mb-0"></p>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Mini Library Section -->

<section id="mini-library" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5" data-fade="up">
      <div class="section-badge mx-auto mb-3">
        <i class="bi bi-book-half"></i>
      </div>
      <h2 class="section-title-enhanced fw-bold mb-3">
        Mini <span class="gradient-text">Library</span>
      </h2>
      <div class="section-divider mx-auto mb-3"></div>
      <p class="text-secondary lead">Proyek Mata Kuliah Bahasa Inggris - Digital Library Kelompok</p>
    </div>

    <?php
    // Mini Library Groups - Now from database
    if (empty($miniLibraryGroups)) {
        $miniLibraryGroups = [];
    }
    ?>

    <div class="row g-4">
      <?php foreach ($miniLibraryGroups as $index => $group): ?>
        <div class="col-12 col-md-6 col-lg-4" data-fade="up" data-delay="<?= $index * 100 ?>">
          <div class="card library-card-enhanced border-0 shadow-lg h-100">
            <div class="library-image-wrapper">
              <img src="<?= htmlspecialchars($group['image']) ?>" 
                   class="library-image" 
                   alt="<?= htmlspecialchars($group['group_name']) ?>">
              <div class="library-overlay-enhanced">
                <div class="overlay-icon">
                  <i class="bi bi-box-arrow-up-right"></i>
                </div>
                <span class="overlay-text">Kunjungi Library</span>
              </div>
              <div class="library-category-badge">
                <span class="badge bg-mustard px-3 py-2">
                  <i class="bi bi-tag-fill me-1"></i>
                  <?= htmlspecialchars($group['category']) ?>
                </span>
              </div>
            </div>
            <div class="card-body p-4">
              <h5 class="card-title fw-bold text-dark mb-3">
                <?= htmlspecialchars($group['group_name']) ?>
              </h5>
              <p class="card-text text-secondary mb-3">
                <?= htmlspecialchars($group['description']) ?>
              </p>
              
              <!-- Members -->
              <div class="library-members mb-3">
                <h6 class="fw-semibold text-mustard mb-2">
                  <i class="bi bi-people-fill me-1"></i>Anggota Kelompok:
                </h6>
                <div class="members-list">
                  <?php 
                  $membersList = $group['members'] ?? [];
                  // Handle both database array format (array of objects with 'name' key) and hardcoded format (array of strings)
                  foreach ($membersList as $member): 
                    $memberName = is_array($member) ? ($member['name'] ?? '') : $member;
                    if (!empty($memberName)):
                  ?>
                    <span class="badge bg-light text-dark border me-1 mb-1">
                      <i class="bi bi-person-fill me-1"></i><?= htmlspecialchars($memberName) ?>
                    </span>
                  <?php endif; endforeach; ?>
                </div>
              </div>
              
              <!-- Link Button -->
              <div class="d-grid">
                <?php
                $link = $group['link'] ?? '';
                $link = trim($link);
                if (!empty($link) && !preg_match('/^https?:\/\//i', $link)) {
                    $link = 'https://' . $link;
                }
                ?>
                <?php if (!empty($link) && filter_var($link, FILTER_VALIDATE_URL)): ?>
                  <a href="<?= htmlspecialchars($link, ENT_QUOTES, 'UTF-8') ?>" 
                     target="_blank" 
                     class="btn btn-mustard btn-animated"
                     style="position:relative;z-index:10;">
                    <i class="bi bi-box-arrow-up-right me-2"></i>Kunjungi Library
                  </a>
                <?php else: ?>
                  <span class="btn btn-mustard"><i class="bi bi-box-arrow-up-right me-2"></i>Kunjungi Library</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

</section>

<style>
:root {
  --mustard: #D4AF37;
  --mustard-dark: #B8941F;
  --mustard-light: #F5E6C3;
}

.text-mustard { color: var(--mustard) !important; }
.bg-mustard { background: var(--mustard) !important; }
.bg-mustard-light { background: var(--mustard-light) !important; }
.bg-mustard-dark { background: var(--mustard-dark) !important; }
.bg-gradient-mustard { background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%); }

/* Hero Section Enhanced */
.hero-enhanced {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
  position: relative;
  overflow: hidden;
  min-height: 90vh;
  display: flex;
  align-items: center;
}

.hero-background-pattern {
  position: absolute;
  inset: 0;
  background: 
    radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.08) 0%, transparent 50%),
    radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.08) 0%, transparent 50%);
  pointer-events: none;
  will-change: transform, opacity;
}

.hero-badge .badge {
  font-size: 1rem;
  font-weight: 600;
  border-radius: 30px;
  letter-spacing: 0.5px;
  animation: fadeInDown 0.8s ease;
}

.gradient-text {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-title {
  line-height: 1.2;
  animation: fadeInUp 0.8s ease;
}

.hero-description {
  animation: fadeInUp 1s ease;
  line-height: 1.8;
}

/* User Stats Card */
.user-stats-card {
  background: white;
  padding: 1.5rem;
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  border: 2px solid var(--mustard-light);
  animation: fadeInUp 1.2s ease;
}

.user-avatars {
  display: flex;
}

.avatar-item {
  width: 50px;
  height: 50px;
  border: 3px solid white;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  margin-left: -15px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 1.2rem;
}

.avatar-item:first-child {
  margin-left: 0;
}

.avatar-item:hover {
  transform: translateY(-5px) scale(1.1);
  z-index: 2;
}

/* Hero Card Wrapper */
.hero-card-wrapper {
  position: relative;
  animation: fadeInLeft 0.8s ease;
}

.card-hover-enhanced {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-hover-enhanced:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 30px 60px rgba(212, 175, 55, 0.3) !important;
}

.floating-element {
  position: absolute;
  width: 70px;
  height: 70px;
  background: white;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  z-index: 2;
  font-size: 1.8rem;
  color: var(--mustard);
}

.element-1 {
  top: 10%;
  left: -30px;
  animation: float 4s ease-in-out infinite;
}

.element-2 {
  bottom: 15%;
  right: -30px;
  animation: float 4s ease-in-out infinite 2s;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

/* Highlight Carousel */
.highlight-image {
  height: 400px;
  object-fit: cover;
}

.carousel-caption-modern {
  position: absolute;
  top: 25px;
  left: 25px;
  z-index: 10;
}

.icon-badge {
  width: 35px;
  height: 35px;
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: white;
}

/* Section Badge */
.section-badge {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border-radius: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: white;
  box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
}

.section-title-enhanced {
  font-size: 2.8rem;
}

.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, transparent, var(--mustard), transparent);
  border-radius: 2px;
}

/* Semester Card Enhanced */
.semester-card-enhanced {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  overflow: hidden;
  border-radius: 20px;
}

.semester-card-enhanced:hover {
  transform: translateY(-12px) rotate(-1deg);
  box-shadow: 0 25px 50px rgba(212, 175, 55, 0.3) !important;
}

.semester-image-wrapper {
  position: relative;
  overflow: hidden;
  aspect-ratio: 4/3;
}

.semester-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.semester-card-enhanced:hover .semester-image {
  transform: scale(1.15) rotate(2deg);
}

.semester-overlay-enhanced {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(184, 148, 31, 0.95) 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  opacity: 0;
  transition: opacity 0.4s ease;
  z-index: 1;
}

.semester-card-enhanced:hover .semester-overlay-enhanced {
  opacity: 1;
}

.overlay-icon {
  font-size: 3rem;
  color: white;
  animation: bounceIn 0.6s ease;
}

.overlay-text {
  color: white;
  font-weight: 600;
  font-size: 1.1rem;
  letter-spacing: 1px;
}

@keyframes bounceIn {
  0% { transform: scale(0); }
  50% { transform: scale(1.2); }
  100% { transform: scale(1); }
}

.badge-semester {
  background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);
  color: var(--mustard);
  font-weight: 600;
  border-radius: 20px;
  border: 2px solid var(--mustard-light);
}

/* Gallery Slider Enhanced */
.gallery-slider-container {
  max-width: 1200px;
  margin: 0 auto;
}

.gallery-slider-image {
  height: 800px;
  object-fit: cover;
  width: 100%;
  max-height: 100vh;
}

@media (max-width: 1200px) {
  .gallery-slider-image {
    height: 600px;
    object-fit: cover;
    width: 100%;
    max-height: 100vh;
  }
}
@media (max-width: 992px) {
  .gallery-slider-image {
    height: 480px;
    object-fit: cover;
    width: 100%;
    max-height: 100vh;
  }
}
@media (max-width: 768px) {
  .carousel-caption-enhanced .badge {
    display: none !important;
  }
  .semester-badge-slider {
    display: inline-block !important;
    left: 50% !important;
    right: auto !important;
    top: auto !important;
    bottom: 28px !important;
    transform: translateX(-50%) !important;
    opacity: 0.85 !important;
    background: rgba(212,175,55,0.85) !important;
    color: #fff !important;
    font-size: 1.1rem !important;
    padding: 10px 24px !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 12px rgba(212,175,55,0.15) !important;
  }
}
@media (max-width: 576px) {
  .gallery-slider-image {
    height: 220px;
    object-fit: cover;
    width: 100%;
    max-height: 100vh;
  }
  .semester-badge-slider {
    font-size: 0.95rem !important;
    padding: 8px 16px !important;
    bottom: 16px !important;
  }
}

/* Button Animated */
.btn-animated {
  position: relative;
  overflow: hidden;
  transition: all 0.4s ease;
}

.btn-animated::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn-animated:hover::before {
  width: 300px;
  height: 300px;
}

.btn-mustard {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border: none;
  color: white;
  border-radius: 15px;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.btn-mustard:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 40px rgba(212, 175, 55, 0.5) !important;
  color: white;
}

.btn-outline-mustard {
  color: var(--mustard);
  border: 2px solid var(--mustard);
  border-radius: 15px;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.btn-outline-mustard:hover {
  background: var(--mustard);
  border-color: var(--mustard);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
}

/* Empty State */
.empty-state-icon {
  font-size: 5rem;
  color: #e5e7eb;
}

.empty-state-icon i {
  display: block;
}

/* Modal Enhanced */
.modal-content {
  border-radius: 25px;
}

.modal-body img {
  max-height: 75vh;
  object-fit: contain;
}

/* Fade Animation */
[data-fade] {
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
  will-change: transform, opacity;
}

[data-fade].fade-in {
  opacity: 1;
}

[data-fade="up"] {
  transform: translateY(20px);
}

[data-fade="up"].fade-in {
  transform: translateY(0);
}

[data-fade="right"] {
  transform: translateX(30px);
}

[data-fade="right"].fade-in {
  transform: translateX(0);
}

[data-fade="left"] {
  transform: translateX(-30px);
}

[data-fade="left"].fade-in {
  transform: translateX(0);
}

/* Keyframe Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInLeft {
  from {
    opacity: 0;
    transform: translateX(30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Shadow Utilities */
.shadow-xl {
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
}

/* Responsive Design */
@media (max-width: 1200px) {
  .gallery-slider-image {
    height: 600px;
    object-fit: cover;
  }
}

@media (max-width: 992px) {
  .hero-enhanced {
    min-height: auto;
    padding: 3rem 0;
  }

  .hero-title {
    font-size: 2.5rem;
  }

  .section-title-enhanced {
    font-size: 2.2rem;
  }

  .highlight-image {
    height: 320px;
  }
  
  .gallery-slider-image {
    height: 600px;
    object-fit: cover;
  }

  .floating-element {
    display: none;
  }

  .section-badge {
    width: 65px;
    height: 65px;
    font-size: 2rem;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }

  .hero-description {
    font-size: 1rem;
  }

  .section-title-enhanced {
    font-size: 1.8rem;
  }

  .highlight-image {
    height: 280px;
  }
  
  .gallery-slider-image {
    height: 340px;
    object-fit: cover;
  }
  
  .avatar-item {
    width: 45px;
    height: 45px;
    margin-left: -12px;
    font-size: 1rem;
  }
  
  .carousel-caption-enhanced {
    padding: 2.5rem 1.5rem 1.5rem;
    text-align: left;
  }
  .carousel-caption-enhanced .badge {
    position: absolute;
    top: 18px;
    right: 18px;
    left: auto;
    z-index: 20;
    margin-bottom: 0;
    font-size: 0.95rem;
    box-shadow: 0 4px 12px rgba(212,175,55,0.15);
  }

  .caption-content-enhanced .fs-5 {
    font-size: 1rem !important;
  }

  .control-icon-custom {
    width: 45px;
    height: 45px;
    font-size: 1.4rem;
  }

  .overlay-icon {
    font-size: 2.5rem;
  }

  .overlay-text {
    font-size: 1rem;
  }

  .section-badge {
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
  }

  .user-stats-card {
    padding: 1rem;
  }
}

@media (max-width: 576px) {
  .hero-title {
    font-size: 1.75rem;
  }

  .section-title-enhanced {
    font-size: 1.6rem;
  }
  
  .highlight-image {
    height: 220px;
  }
  
  .gallery-slider-image {
    height: 220px;
    object-fit: cover;
  }
  
  .control-icon-custom {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
  }

  .avatar-item {
    width: 40px;
    height: 40px;
    margin-left: -10px;
  }

  .carousel-caption-enhanced {
    padding: 2rem 1rem 1rem;
  }

  .section-badge {
    width: 55px;
    height: 55px;
    font-size: 1.5rem;
  }

  .btn-lg {
    font-size: 0.95rem;
    padding: 0.6rem 1.5rem;
  }

  .semester-card-enhanced:hover {
    transform: translateY(-8px) rotate(0deg);
  }
}

/* Mini Library Cards */
.library-card-enhanced {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  overflow: hidden;
  border-radius: 20px;
  position: relative;
}

.library-card-enhanced:hover {
  transform: translateY(-10px);
  box-shadow: 0 25px 50px rgba(212, 175, 55, 0.25) !important;
}

.library-image-wrapper {
  position: relative;
  overflow: hidden;
  height: 200px;
}

.library-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.library-card-enhanced:hover .library-image {
  transform: scale(1.1);
}

.library-overlay-enhanced {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(212, 175, 55, 0.9) 0%, rgba(184, 148, 31, 0.9) 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  opacity: 0;
  transition: opacity 0.4s ease;
  z-index: 2;
}

.library-card-enhanced:hover .library-overlay-enhanced {
  opacity: 1;
}

.library-category-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  z-index: 3;
}

.library-members {
  background: rgba(212, 175, 55, 0.1);
  border-radius: 15px;
  padding: 1rem;
  border-left: 4px solid var(--mustard);
}

.members-list .badge {
  font-size: 0.8rem;
  font-weight: 500;
  border-radius: 20px;
  padding: 0.4rem 0.8rem;
}

/* CTA Card */
.cta-card {
  background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(255, 255, 255, 0.5) 100%);
  border: 2px solid rgba(212, 175, 55, 0.2);
  border-radius: 25px;
  padding: 2rem;
  backdrop-filter: blur(10px);
}

/* Additional Utilities */
.rounded-5 {
  border-radius: 25px !important;
}

.bg-light {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%) !important;
}
</style>

<script>
// Fade-in animation on scroll
function animateOnScroll() {
  const elements = document.querySelectorAll('[data-fade]');
  
  elements.forEach(element => {
    const elementTop = element.getBoundingClientRect().top;
    const elementBottom = element.getBoundingClientRect().bottom;
    
    if (elementTop < window.innerHeight - 100 && elementBottom > 0) {
      element.classList.add('fade-in');
    }
  });
}

// Initialize animations
document.addEventListener('DOMContentLoaded', function() {
  // Animate on scroll - use IntersectionObserver when available
  const fadeEls = document.querySelectorAll('[data-fade]');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
          obs.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.15 });
    fadeEls.forEach(el => io.observe(el));
  } else {
    // Fallback
    animateOnScroll();
    let scrollTimeout;
    window.addEventListener('scroll', function() {
      if (scrollTimeout) { window.cancelAnimationFrame(scrollTimeout); }
      scrollTimeout = window.requestAnimationFrame(function() { animateOnScroll(); });
    });
  }
  // Auto start carousels kecuali video
  const carousels = document.querySelectorAll('.carousel');
  carousels.forEach(carousel => {
    if (carousel.id === 'videoCarousel') {
      new bootstrap.Carousel(carousel, {
        interval: false,
        ride: false,
        pause: 'hover'
      });
    } else {
      new bootstrap.Carousel(carousel, {
        interval: 3000,
        ride: 'carousel',
        pause: 'hover'
      });
    }
  });
  // Add staggered animation delay for semester cards
  const semesterCards = document.querySelectorAll('[data-fade][data-delay]');
  semesterCards.forEach(card => {
    const delay = card.getAttribute('data-delay');
    card.style.transitionDelay = delay + 'ms';
  });
});

// Modal function
function openGalleryModal(imgUrl, caption, semester) {
  const modalImg = document.getElementById('modalGalleryImg');
  const modalCaption = document.getElementById('modalGalleryCaption');
  const modalSemester = document.getElementById('modalGallerySemester');
  
  if (modalImg) modalImg.src = imgUrl;
  if (modalCaption) modalCaption.innerText = caption || '';
  if (modalSemester) modalSemester.innerHTML = '<i class="bi bi-calendar3 me-1"></i>' + (semester || 'Semester');
  
  const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
  modal.show();
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (href !== '#' && href.length > 1) {
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }
  });
});

// Add ripple effect to buttons
document.querySelectorAll('.btn-animated').forEach(button => {
  button.addEventListener('click', function(e) {
    // Respect reduced motion
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }
    const rect = this.getBoundingClientRect();
    const ripple = document.createElement('span');
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;
    
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');
    
    this.appendChild(ripple);
    
    setTimeout(() => {
      ripple.remove();
    }, 600);
  });
});

// Convert Google Drive URL from /view to /preview
function convertDriveUrlToEmbed(url) {
  return url.replace(/\/view(\?.*)?$/, '/preview');
}
</script>


