<?php 
$title = 'Gallery Semua Semester'; 
// Load config with fallback (prioritize local development)
$configCandidates = [
    __DIR__ . '/../../Config/config.php',
    __DIR__ . '/../../Config/config_production.php'
];
foreach ($configCandidates as $cfg) {
    if (is_file($cfg)) { require_once $cfg; break; }
}
?>
<link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/lg.png?v=1') ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/lg.png?v=1') ?>">
<link rel="shortcut icon" href="<?= asset('images/lg.png?v=1') ?>">
<link rel="apple-touch-icon" href="<?= asset('images/lg.png?v=1') ?>">

<section class="gallery-sikc-section py-5 bg-light">
  <div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="section-icon">
                  <i class="bi bi-images"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                Gallery <span class="gradient-text">SIKC B 2023</span>
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Dokumentasi lengkap kegiatan dari semua semester</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Semester (Desktop/Tablet Only) -->
    <div class="d-none d-md-block">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body py-3 px-4">
          <div class="d-flex flex-wrap justify-content-center gap-3">
            <button class="btn btn-outline-mustard filter-btn active" data-semester="all">
              <i class="bi bi-collection me-1"></i> Semua Semester
            </button>
            <?php if (!empty($semesters)): ?>
              <?php foreach (array_reverse($semesters) as $sem): ?>
                <button class="btn btn-outline-mustard filter-btn" data-semester="<?= (int)$sem['id'] ?>">
                  <i class="bi bi-calendar3 me-1"></i> <?= htmlspecialchars($sem['name']) ?>
                </button>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Dropdown Filter Semester -->
    <div class="d-block d-md-none">
      <div class="custom-dropdown-semester mb-2" style="position:relative;max-width:350px;margin:0 auto;">
        <button class="btn btn-mustard w-100 d-flex align-items-center justify-content-between" id="dropdownSemesterBtn" onclick="toggleSemesterDropdown(event)" style="border-radius:15px;font-size:1.05rem;padding:0.9rem 1.2rem;">
          <span><i class="bi bi-collection me-2"></i> Semua Semester</span>
          <i class="bi bi-chevron-down" id="dropdownSemesterIcon" style="font-size:1.2rem;"></i>
        </button>
        <div class="dropdown-semester-list shadow-lg" id="dropdownSemesterList" style="display:none;position:absolute;top:110%;left:0;width:100%;background:linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);border-radius:15px;z-index:20;overflow:hidden;animation:fadeInDown 0.3s;">
          <button class="btn btn-outline-mustard w-100 text-start semester-list-btn" style="border-radius:0;font-size:1rem;padding:0.8rem 1.2rem;border:none;border-bottom:1px solid #f5e6c3;" data-semester="all">
            <i class="bi bi-collection me-2"></i> Semua Semester
          </button>
          <?php if (!empty($semesters)): ?>
            <?php foreach (array_reverse($semesters) as $sem): ?>
              <button class="btn btn-outline-mustard w-100 text-start semester-list-btn" style="border-radius:0;font-size:1rem;padding:0.8rem 1.2rem;border:none;border-bottom:1px solid #f5e6c3;" data-semester="<?= (int)$sem['id'] ?>">
                <i class="bi bi-calendar3 me-2"></i> <?= htmlspecialchars($sem['name']) ?>
              </button>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4" id="galleryContainer">
      <?php if (!empty($allGallery)): ?>
        <?php foreach ($allGallery as $g): ?>
          <div class="col-12 col-md-6">
            <div class="gallery-card h-100" data-semester="<?= (int)$g['semester_id'] ?>">
              <div class="gallery-item position-relative rounded overflow-hidden shadow-sm">
                <img
                  src="<?= htmlspecialchars($g['image_url']) ?>"
                  alt="<?= htmlspecialchars($g['semester_name'] ?? 'Gallery') ?>"
                  class="img-fluid gallery-thumb"
                  style="height:350px;object-fit:cover;width:100%;"
                >
                <div class="gallery-overlay">
                  <div class="text-white fw-semibold d-flex align-items-center gap-2">
                  </div>
                </div>
                <div class="semester-badge">
                  <small class="text-white fw-semibold">
                    <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($g['semester_name'] ?? 'Semester') ?>
                  </small>
                </div>
              </div>
              <?php if (!empty($g['caption'])): ?>
                <div class="small text-muted mt-2 text-truncate" title="<?= htmlspecialchars($g['caption']) ?>">
                  "<?= htmlspecialchars($g['caption']) ?>"
                </div>
              <?php endif; ?>
              <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-outline-mustard px-4 py-2" onclick="openModal('<?= htmlspecialchars($g['image_url']) ?>', '<?= htmlspecialchars($g['caption'] ?? '') ?>', '<?= htmlspecialchars($g['semester_name'] ?? '') ?>')">
                  <i class="bi bi-eye me-1"></i>Lihat
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-images"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum Ada Foto</h5>
              <p class="text-muted mb-0">Belum ada foto di galeri</p>
              <a href="<?= url('semesters') ?>" class="btn btn-mustard mt-3">
                <i class="bi bi-collection me-1"></i>Lihat Semester
              </a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
      <a href="<?= url() ?>" class="btn btn-outline-mustard">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
      </a>
    </div>
  </div>
</section>

<!-- Bootstrap Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imageModalImg" src="" class="img-fluid" alt="Gallery Image" style="max-height: 70vh;">
      </div>
      <div class="modal-footer">
        <p id="imageModalCaption" class="text-muted mb-0"></p>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
// 🔒 SECURE Filter Gallery by Semester with defensive programming
document.addEventListener('DOMContentLoaded', function() {
  try {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryCards = document.querySelectorAll('.gallery-card');

    if (!filterBtns.length || !galleryCards.length) {
      console.warn('Gallery filter elements not found');
      return;
    }

    filterBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        try {
          e.preventDefault();
          
          // Remove active class safely
          filterBtns.forEach(b => {
            if (b && b.classList) b.classList.remove('active');
          });
          
          if (this.classList) this.classList.add('active');

          const selectedSemester = this.getAttribute('data-semester');
          
          // Validate semester value (should be 'all' or numeric)
          if (selectedSemester !== 'all' && !/^\d+$/.test(selectedSemester)) {
            console.error('Invalid semester filter value');
            return;
          }
          
          galleryCards.forEach(card => {
            if (!card || !card.getAttribute) return;
            const cardSemester = card.getAttribute('data-semester');
            const shouldShow = selectedSemester === 'all' || cardSemester === selectedSemester;
            card.style.display = shouldShow ? 'block' : 'none';
          });
        } catch (error) {
          console.error('Error in filter click handler:', error);
        }
      });
    });
  } catch (error) {
    console.error('Error initializing gallery filters:', error);
  }
});

// 🔒 SECURE modal function with input validation and XSS prevention
function openModal(imgUrl, caption, semesterName) {
  // Input validation and sanitization
  if (!imgUrl || typeof imgUrl !== 'string') {
    console.error('Invalid image URL provided');
    return;
  }
  
  // Validate URL format (basic check)
  try {
    const url = new URL(imgUrl, window.location.origin);
    if (!url.protocol.match(/^https?:$/)) {
      console.error('Invalid protocol in image URL');
      return;
    }
  } catch (e) {
    console.error('Invalid image URL format');
    return;
  }
  
  // Safe assignment with XSS protection
  const modalImg = document.getElementById('imageModalImg');
  const modalLabel = document.getElementById('imageModalLabel');
  const modalCaption = document.getElementById('imageModalCaption');
  
  if (modalImg) modalImg.src = imgUrl;
  if (modalLabel) {
    // Use textContent to prevent XSS
    modalLabel.textContent = semesterName && typeof semesterName === 'string' 
      ? 'Gallery - ' + semesterName.substring(0, 100) // Limit length
      : 'Preview Foto';
  }
  if (modalCaption) {
    // Use textContent to prevent XSS and limit length
    modalCaption.textContent = caption && typeof caption === 'string' 
      ? caption.substring(0, 200) 
      : '';
  }
  
  const modalEl = document.getElementById('imageModal');
  if (!modalEl) {
    // Only open trusted URLs
    if (imgUrl.startsWith(window.location.origin) || imgUrl.startsWith('/')) {
      window.open(imgUrl, '_blank');
    }
    return;
  }
  
  if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
    const myModal = new bootstrap.Modal(modalEl);
    myModal.show();
  } else {
    // Fallback: only open trusted URLs
    if (imgUrl.startsWith(window.location.origin) || imgUrl.startsWith('/')) {
      window.open(imgUrl, '_blank');
    }
  }
}

// 🔒 SECURE Toggle Semester Dropdown with error handling
function toggleSemesterDropdown(e) {
  try {
    if (e && e.preventDefault) e.preventDefault();
    
    const list = document.getElementById('dropdownSemesterList');
    const icon = document.getElementById('dropdownSemesterIcon');
    
    if (!list || !icon) {
      console.warn('Dropdown elements not found');
      return;
    }
    
    const isHidden = list.style.display === 'none' || list.style.display === '';
    
    list.style.display = isHidden ? 'block' : 'none';
    
    if (icon.classList) {
      if (isHidden) {
        icon.classList.add('rotate');
      } else {
        icon.classList.remove('rotate');
      }
    }
  } catch (error) {
    console.error('Error toggling dropdown:', error);
  }
}
// 🔒 SECURE Click outside handler with error protection
document.addEventListener('click', function(e) {
  try {
    const btn = document.getElementById('dropdownSemesterBtn');
    const list = document.getElementById('dropdownSemesterList');
    const icon = document.getElementById('dropdownSemesterIcon');
    
    if (!btn || !list || !e.target) return;
    
    // Check if click is outside dropdown
    if (!btn.contains(e.target) && !list.contains(e.target)) {
      list.style.display = 'none';
      if (icon && icon.classList) {
        icon.classList.remove('rotate');
      }
    }
  } catch (error) {
    console.error('Error in click outside handler:', error);
  }
});
// 🔒 SECURE Semester list button handlers with comprehensive protection
document.querySelectorAll('.semester-list-btn').forEach(function(btn) {
  if (!btn) return;
  
  btn.addEventListener('click', function(e) {
    try {
      if (e && e.preventDefault) e.preventDefault();
      
      const dropdownList = document.getElementById('dropdownSemesterList');
      const dropdownIcon = document.getElementById('dropdownSemesterIcon');
      const dropdownBtn = document.getElementById('dropdownSemesterBtn');
      
      if (!dropdownList || !dropdownBtn) {
        console.warn('Required dropdown elements not found');
        return;
      }
      
      // Close dropdown safely
      dropdownList.style.display = 'none';
      if (dropdownIcon && dropdownIcon.classList) {
        dropdownIcon.classList.remove('rotate');
      }
      
      // 🔒 SECURITY: Safely update button text to prevent XSS
      const semesterText = this.textContent ? this.textContent.trim() : '';
      
      // Validate and limit text length
      if (semesterText.length > 50) {
        console.warn('Semester text too long, truncating');
        semesterText = semesterText.substring(0, 50);
      }
      
      // Clear existing content safely
      dropdownBtn.innerHTML = '';
      
      // Create elements safely to prevent XSS
      const spanElement = document.createElement('span');
      const iconElement = document.createElement('i');
      const calendarIcon = document.createElement('i');
      
      calendarIcon.className = 'bi bi-calendar3 me-2';
      spanElement.appendChild(calendarIcon);
      spanElement.appendChild(document.createTextNode(semesterText));
      
      iconElement.className = 'bi bi-chevron-down';
      iconElement.id = 'dropdownSemesterIcon';
      iconElement.style.fontSize = '1.2rem';
      
      dropdownBtn.appendChild(spanElement);
      dropdownBtn.appendChild(iconElement);
      
      // Filter gallery cards with validation
      const selectedSemester = this.getAttribute('data-semester');
      
      // Validate semester value
      if (selectedSemester !== 'all' && !/^\d+$/.test(selectedSemester)) {
        console.error('Invalid semester value for filtering');
        return;
      }
      
      document.querySelectorAll('.gallery-card').forEach(function(card) {
        if (!card || !card.getAttribute) return;
        
        const cardSemester = card.getAttribute('data-semester');
        const shouldShow = selectedSemester === 'all' || cardSemester === selectedSemester;
        card.style.display = shouldShow ? 'block' : 'none';
      });
      
    } catch (error) {
      console.error('Error in semester list button handler:', error);
    }
  });
});
</script>

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

.gallery-sikc-section {
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

/* Card & Gallery Modern */
.gallery-card {
  padding: 2rem 1.5rem;
  background: white;
  border-radius: 25px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
}

.gallery-card:hover {
  transform: translateY(-12px) rotate(-1deg);
  box-shadow: 0 20px 50px rgba(212, 175, 55, 0.25);
  border-color: var(--mustard-light);
}

.gallery-thumb {
  width: 100%;
  height: 350px;
  object-fit: cover;
  border-radius: 18px;
  background: #fafafa;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: transform .25s ease;
}

@media (max-width: 992px) {
  .gallery-thumb {
    height: 220px;
  }
}

@media (max-width: 768px) {
  .gallery-thumb {
    height: 160px;
  }
}

.gallery-item {
  position: relative;
  cursor: pointer;
  transition: transform .2s ease;
}

.gallery-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.35);
  opacity: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .25s ease;
  border-radius: 18px;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.semester-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border-radius: 15px;
  padding: 4px 12px;
  z-index: 2;
  font-size: 0.95rem;
}

.filter-btn {
  transition: all 0.2s ease;
  border-radius: 15px;
  font-weight: 600;
  padding: 0.7rem 1.5rem;
}

.filter-btn.active,
.filter-btn:hover {
  background: var(--mustard);
  border-color: var(--mustard);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(212, 175, 55, 0.15);
}

.btn-mustard {
  background-color: var(--mustard);
  border-color: var(--mustard);
  color: #fff;
  border-radius: 15px;
  font-weight: 600;
  transition: all 0.25s ease;
  padding: 0.8rem 1.5rem;
}

.btn-mustard:hover {
  background-color: var(--mustard-dark);
  border-color: var(--mustard-dark);
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(212, 175, 55, 0.25);
}

.btn-outline-mustard {
  color: var(--mustard);
  border-color: var(--mustard);
  border-radius: 15px;
  font-weight: 600;
  padding: 0.8rem 1.5rem;
  transition: all 0.3s ease;
}

.btn-outline-mustard:hover {
  background: var(--mustard);
  border-color: var(--mustard);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
}

.empty-state {
  font-size: 4rem;
  color: #e5e7eb;
  margin-bottom: 1rem;
}

/* Modal Modern */
.modal-content {
  border-radius: 20px;
  overflow: hidden;
  background: #000;
}

.modal-header {
  background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);
  position: relative;
  z-index: 10;
}

.modal-body {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.image-container {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 60vh;
}

.modal-image {
  max-width: 100%;
  max-height: 85vh;
  width: auto;
  height: auto;
  object-fit: contain;
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.5);
}

.caption-overlay {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0,0,0,0.8);
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.9rem;
  max-width: 80%;
  text-align: center;
}

.modal-footer {
  background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);
  position: relative;
  z-index: 10;
}

/* Bootstrap Modal Enhancement */
.modal-content {
  border-radius: 15px;
  border: none;
}

.modal-header {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  color: white;
  border-radius: 15px 15px 0 0;
}

.modal-body {
  padding: 1rem;
  background: #f8f9fa;
}

.modal-footer {
  background: #fff;
  border-radius: 0 0 15px 15px;
  border-top: 1px solid #dee2e6;
}

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
  .gallery-card {
    padding: 1.5rem 1rem;
  }
  .gallery-thumb {
    height: 150px;
  }
}

@media (max-width: 768px) {
  .section-icon {
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
  }
  .gallery-card {
    padding: 1rem 0.5rem;
  }
  .gallery-thumb {
    height: 120px;
  }
  
  .image-modal-content {
    margin: 10% auto;
    width: 95%;
  }
  
  .image-modal-close {
    top: 10px;
    right: 15px;
    font-size: 28px;
    width: 40px;
    height: 40px;
  }
  
  .image-modal-header h3 {
    font-size: 1.2rem;
  }
  
  .image-modal-body img {
    max-height: 60vh;
  }
}

@keyframes fadeInDown {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
.custom-dropdown-semester .btn-mustard {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%) !important;
  color: #fff !important;
  font-weight: 600;
  box-shadow: 0 8px 24px rgba(212,175,55,0.18);
  border: none;
  transition: box-shadow 0.3s, background 0.3s;
}
.custom-dropdown-semester .btn-mustard:focus {
  box-shadow: 0 0 0 2px var(--mustard-dark);
  outline: none;
}
.custom-dropdown-semester .btn-mustard .bi-chevron-down.rotate {
  transform: rotate(180deg);
  transition: transform 0.3s;
}
.dropdown-semester-list {
  box-shadow: 0 8px 32px rgba(212,175,55,0.18);
  border-radius: 15px;
  animation: fadeInDown 0.3s;
}
.semester-list-btn {
  background: transparent !important;
  color: var(--mustard) !important;
  font-weight: 600;
  border-radius: 0 !important;
  transition: background 0.2s, color 0.2s;
}
.semester-list-btn:hover, .semester-list-btn:focus {
  background: var(--mustard-light) !important;
  color: var(--mustard-dark) !important;
}
</style>