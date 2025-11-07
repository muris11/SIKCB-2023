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
                Gallery <span class="gradient-text"><?= htmlspecialchars($semester['name']) ?></span>
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

    <!-- Quick Navigation -->
    <div class="row mb-4 justify-content-center">
      <div class="col-lg-11">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <?php if($isLoggedIn): ?>
            <a href="<?= url('semester/' . $semester['id']) ?>" class="btn btn-outline-mustard">
              <i class="bi bi-journal-text me-1"></i> Lihat Mata Kuliah
            </a>
          <?php endif; ?>
          <a href="<?= url('semesters') ?>" class="btn btn-outline-mustard">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Semester
          </a>
        </div>
      </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4 justify-content-center">
      <div class="col-lg-11">
        <?php if(!empty($gallery)): ?>
          <div class="row g-4">
            <?php foreach($gallery as $index => $image): ?>
              <div class="col-12 col-md-6">
                <div class="gallery-card h-100" data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
                  <div class="gallery-item position-relative rounded overflow-hidden shadow-sm">
                    <img
                      src="<?= htmlspecialchars($image['image_url']) ?>"
                      alt="Gallery"
                      class="img-fluid gallery-thumb"
                      style="height:350px;object-fit:cover;width:100%;"
                      onclick="openImageModal('<?= htmlspecialchars($image['image_url']) ?>')"
                    >
                    <div class="gallery-overlay">
                      <div class="text-white fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-zoom-in"></i><span>Lihat</span>
                      </div>
                    </div>
                  </div>
                  <div class="text-center mt-3">
                    <button class="btn btn-mustard btn-lg px-4 py-2" onclick="openImageModal('<?= htmlspecialchars($image['image_url']) ?>')">
                      <i class="bi bi-zoom-in me-2"></i>Lihat Ukuran Penuh
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-images"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum ada foto di galeri</h5>
              <p class="text-muted mb-0">Galeri semester ini masih kosong.</p>
              <?php if($isLoggedIn): ?>
                <a href="<?= url('semester/' . $semester['id']) ?>" class="btn btn-mustard mt-3">
                  <i class="bi bi-journal-text me-1"></i> Lihat Mata Kuliah
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Galeri - <?= htmlspecialchars($semester['name']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center p-0">
        <img id="modalImage" src="" class="img-fluid rounded-bottom" alt="Gallery Image">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

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
.gallery-card:hover .gallery-thumb {
  transform: scale(1.05);
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
.btn-mustard {
  background-color: var(--mustard);
  border-color: var(--mustard);
  color: #fff;
  border-radius: 15px;
  font-weight: 600;
  transition: all 0.25s ease;
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
    height: 220px;
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
    height: 160px;
  }
}
</style>

<script>
function openImageModal(imageUrl){
  document.getElementById('modalImage').src = imageUrl;
  new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
