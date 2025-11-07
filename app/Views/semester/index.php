<?php $title = 'Semua Semester'; ?>
<section class="py-5 bg-light">
  <div class="container">
    <!-- Header Section -->
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="section-icon">
                  <i class="bi bi-collection"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                Semua <span class="gradient-text">Semester</span>
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Jelajahi <?= count($semesters) ?> semester tersedia dan pilih untuk melihat mata kuliah serta galeri foto</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Semesters Grid -->
    <div class="row mb-5">
      <div class="col-12">
        <?php if (empty($semesters)): ?>
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum Ada Semester</h5>
              <p class="text-muted mb-0">Hubungi admin untuk informasi lebih lanjut</p>
            </div>
          </div>
        <?php else: ?>
          <div class="row g-4">
            <?php foreach($semesters as $semester): ?>
              <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm class-card h-100">
                  <div class="card-body p-0">
                    <?php 
                      $coverUrl = !empty($semester['cover_image']) ? url('image/semester/' . $semester['id']) : asset('img/default-semester.jpg');
                    ?>
                    <div class="ratio ratio-16x9 mb-3">
                      <img src="<?= htmlspecialchars($coverUrl) ?>" 
                           alt="<?= htmlspecialchars($semester['name']) ?>" 
                           class="w-100 h-100 object-fit-cover rounded-top">
                    </div>
                    
                    <div class="p-4">
                      <div class="d-flex align-items-start mb-3">
                        <div class="class-icon me-3">
                          <i class="bi bi-calendar2-event"></i>
                        </div>
                        <div class="flex-grow-1">
                          <h5 class="card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($semester['name']) ?></h5>
                          <p class="card-text text-secondary small mb-3">
                            <?= htmlspecialchars($semester['description'] ?: 'Tidak ada deskripsi') ?>
                          </p>
                        </div>
                        <div class="sks-badge-small ms-2">
                          <div class="sks-number-small"><?= htmlspecialchars($semester['term_label']) ?></div>
                        </div>
                      </div>
                      
                      <div class="class-info mb-3">
                        <div class="info-item mb-2">
                          <i class="bi bi-journal-text text-mustard me-2"></i>
                          <span class="text-secondary small"><?= (int)$semester['class_count'] ?> mata kuliah</span>
                        </div>
                        <div class="info-item mb-2">
                          <i class="bi bi-images text-mustard me-2"></i>
                          <span class="text-secondary small"><?= (int)$semester['gallery_count'] ?> foto</span>
                        </div>
                      </div>

                      <div>
                        <a href="<?= url('semester/' . $semester['id']) ?>" class="btn btn-outline-mustard w-100">
                          <i class="bi bi-eye me-2"></i>Lihat Detail
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

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
.bg-gradient-mustard { background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%); }
.object-fit-cover { object-fit: cover; }

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
  font-size: 0.75rem;
  font-weight: bold;
  line-height: 1;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Button Styles */
.btn-outline-mustard {
  color: var(--mustard);
  border-color: var(--mustard);
}

.btn-outline-mustard:hover {
  background: var(--mustard);
  border-color: var(--mustard);
  color: white;
}

/* Empty State */
.empty-state {
  font-size: 4rem;
  color: #e5e7eb;
  margin-bottom: 1rem;
}

/* Responsive */
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

  .class-icon {
    width: 40px;
    height: 40px;
    font-size: 1.1rem;
  }

  .sks-badge-small {
    padding: 0.4rem 0.6rem;
    min-width: 50px;
  }
}
</style>
