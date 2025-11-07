<?php $title='Detail Semester'; ?>
<section id="semester" class="semester-sikc-section py-5 bg-light">
  <div class="container py-4">

    <!-- Header Section -->
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="icon-glow"></div>
              </div>
              <?php if (!empty($semester['cover_image'])): ?>
                <div class="mb-4">
                  <img src="<?= url('image/semester/' . $semester['id']) ?>" alt="Cover Semester" class="img-fluid rounded-4 shadow" style="max-height:260px;object-fit:cover;">
                </div>
              <?php endif; ?>
              <h2 class="display-6 fw-bold mb-3">
                <span class="gradient-text"><?= htmlspecialchars($semester['name']) ?></span>
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3"><?= htmlspecialchars($semester['description']) ?></p>
              <div class="mt-4">
                <span class="badge bg-mustard fs-6 px-3 py-2">
                  <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($semester['term_label']) ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mata Kuliah Section (Full Width) -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4">
          <div class="section-icon me-3">
            <i class="bi bi-journal-text"></i>
          </div>
          <div>
            <h3 class="text-mustard fw-bold mb-0">Mata Kuliah</h3>
            <p class="text-muted small mb-0">Daftar mata kuliah semester ini</p>
          </div>
        </div>

        <?php if($isLoggedIn && !empty($classes)): ?>
          <div class="row g-3">
            <?php foreach($classes as $class): ?>
              <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm class-card h-100">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-3">
                      <div class="class-icon me-3">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="flex-grow-1">
                        <h5 class="card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($class['name']) ?></h5>
                        <p class="card-text text-secondary small mb-3"><?= htmlspecialchars($class['description']) ?></p>
                      </div>
                      <div class="sks-badge-small ms-2">
                        <div class="sks-number-small"><?= (int)$class['sks'] ?></div>
                        <div class="sks-label-small">SKS</div>
                      </div>
                    </div>
                    
                    <div class="class-info mb-3">
                      <div class="info-item mb-2">
                        <i class="bi bi-person-workspace text-mustard me-2"></i>
                        <span class="text-secondary small"><?= htmlspecialchars($class['teacher']) ?></span>
                      </div>
                      <div class="info-item mb-2">
                        <i class="bi bi-calendar-event text-mustard me-2"></i>
                        <span class="text-secondary small"><?= htmlspecialchars($class['schedule']) ?></span>
                      </div>
                      <?php if($class['pj_name']): ?>
                      <div class="info-item">
                        <i class="bi bi-person-badge text-mustard me-2"></i>
                        <span class="text-secondary small">PJ: <?= htmlspecialchars($class['pj_name']) ?></span>
                      </div>
                      <?php endif; ?>
                    </div>

                    <div>
                      <span class="badge status-badge status-<?= $class['status'] ?> px-3 py-2">
                        <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                        <?= ucfirst($class['status']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        <?php elseif($isLoggedIn && empty($classes)): ?>
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-inbox"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum Ada Mata Kuliah</h5>
              <p class="text-muted mb-0">Belum ada mata kuliah untuk semester ini.</p>
            </div>
          </div>

        <?php elseif(!$isLoggedIn): ?>
          <div class="card border-0 shadow-sm bg-warning-subtle">
            <div class="card-body p-4">
              <div class="d-flex align-items-center">
                <div class="locked-icon me-3">
                  <i class="bi bi-lock-fill"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-2 text-warning-emphasis">Butuh Akses</h5>
                  <p class="mb-0 text-secondary">Silakan <a href="<?= url('login') ?>" class="text-mustard fw-semibold text-decoration-none">login</a> untuk melihat mata kuliah di semester ini.</p>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Galeri Section (Full Width) -->
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4">
          <div class="section-icon me-3">
            <i class="bi bi-images"></i>
          </div>
          <div>
            <h3 class="text-mustard fw-bold mb-0">Galeri Album</h3>
            <p class="text-muted small mb-0">Dokumentasi kegiatan semester ini</p>
          </div>
        </div>

        <?php if(!empty($gallery)): ?>
          <div class="gallery-grid-2col">
            <?php foreach(array_slice($gallery, 0, 4) as $index => $image): ?>
              <div class="gallery-item" onclick="openImageModal('<?= htmlspecialchars($image['image_url']) ?>')">
                <div class="gallery-overlay">
                  <div class="gallery-overlay-content">
                    <i class="bi bi-zoom-in"></i>
                    <span class="mt-2">Lihat Foto</span>
                  </div>
                </div>
                <img src="<?= htmlspecialchars($image['image_url']) ?>" 
                     alt="Gallery <?= $index + 1 ?>" 
                     class="gallery-image">
              </div>
            <?php endforeach; ?>
          </div>
          
          <div class="text-center mt-4">
  <a href="<?= url('semester/' . $semester['id'] . '/gallery') ?>"
     class="btn btn-mustard btn-lg fw-semibold d-inline-flex align-items-center gap-2 shadow-sm px-4 py-3">
    <i class="bi bi-images fs-5"></i>
    <span>Lihat Semua Galeri (<?= count($gallery) ?> Foto)</span>
  </a>
</div>

        <?php else: ?>
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-images"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum Ada Foto</h5>
              <p class="text-muted mb-0">Belum ada foto di galeri</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <!-- Image Modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title text-mustard fw-bold">
            <i class="bi bi-image me-2"></i><?= htmlspecialchars($semester['name']) ?>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body p-2">
          <img id="modalImage" src="" class="img-fluid w-100 rounded" alt="Gallery Image">
        </div>
      </div>
    </div>
  </div>

  <style>
    .btn-mustard {
  background-color: #D4AF37;
  border-color: #D4AF37;
  color: #fff;
  border-radius: 0.75rem;
  transition: all 0.25s ease;
}

.btn-mustard:hover {
  background-color: #b8941f;
  border-color: #b8941f;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(212, 175, 55, 0.25);
}

  :root {
    --mustard: #D4AF37;
    --mustard-dark: #B8941F;
    --mustard-light: #F5E6C3;
  }

  .text-mustard { color: var(--mustard) !important; }
  .bg-mustard { background: var(--mustard) !important; }
  
  .semester-sikc-section {
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
  
  /* Gradient Overlay */
  .bg-gradient-overlay {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.3) 0%, rgba(184, 148, 31, 0.3) 100%);
  }
  
  .object-fit-cover {
    object-fit: cover;
  }

  /* Section Icon */
  .section-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
  }

  /* Class Card */
  .class-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 4px solid var(--mustard);
    background: white;
  }
  
  .class-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(212, 175, 55, 0.2) !important;
    border-left-width: 6px;
  }

  .class-icon {
    width: 45px;
    height: 45px;
    background: var(--mustard-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--mustard);
    flex-shrink: 0;
  }

  .info-item {
    display: flex;
    align-items: center;
  }

  .info-item i {
    font-size: 1rem;
    flex-shrink: 0;
  }

  /* SKS Badge Small */
  .sks-badge-small {
    background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
    border-radius: 10px;
    padding: 0.5rem 0.75rem;
    text-align: center;
    color: white;
    min-width: 60px;
    flex-shrink: 0;
  }

  .sks-number-small {
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
    margin-bottom: 0.1rem;
  }

  .sks-label-small {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
  }

  /* Status Badge */
  .status-badge {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
    border-radius: 20px;
  }

  .status-active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .status-completed {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
  }

  .status-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }

  /* Gallery Grid - 2 Columns */
  .gallery-grid-2col {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }

  .gallery-item {
    position: relative;
    aspect-ratio: 4/3;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(212, 175, 55, 0.25);
  }

  .gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .gallery-item:hover .gallery-image {
    transform: scale(1.15);
  }

  .gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(184, 148, 31, 0.95) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
  }

  .gallery-item:hover .gallery-overlay {
    opacity: 1;
  }

  .gallery-overlay-content {
    text-align: center;
    color: white;
    transform: scale(0.8);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .gallery-item:hover .gallery-overlay-content {
    transform: scale(1);
  }

  .gallery-overlay-content i {
    font-size: 3rem;
    display: block;
  }

  .gallery-overlay-content span {
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  /* Empty State */
  .empty-state {
    font-size: 4rem;
    color: #e5e7eb;
    margin-bottom: 1rem;
  }

  /* Locked Icon */
  .locked-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    flex-shrink: 0;
  }

  /* Modal Enhancements */
  .modal-content {
    border-radius: 20px;
    overflow: hidden;
  }

  .modal-header {
    background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);
  }

  .modal-body img {
    max-height: 80vh;
    object-fit: contain;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .gallery-grid-2col {
      gap: 1rem;
    }
  }

  @media (max-width: 768px) {
    .section-icon {
      width: 40px;
      height: 40px;
      font-size: 1.2rem;
    }

    .class-icon {
      width: 40px;
      height: 40px;
      font-size: 1.1rem;
    }

    .sks-badge-small {
      padding: 0.4rem 0.6rem;
      min-width: 50px;
    }

    .sks-number-small {
      font-size: 1.2rem;
    }

    .gallery-grid-2col {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .gallery-item {
      aspect-ratio: 16/10;
    }

    .gallery-overlay-content i {
      font-size: 2.5rem;
    }

    .gallery-overlay-content span {
      font-size: 0.9rem;
    }
  }

  @media (max-width: 576px) {
    .locked-icon {
      width: 50px;
      height: 50px;
      font-size: 1.5rem;
    }

    .gallery-item {
      border-radius: 15px;
    }
  }
  </style>

  <script>
  function openImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
  }
  </script>
</section>