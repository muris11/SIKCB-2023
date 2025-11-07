<?php $title = 'Gallery ' . ($semester['name'] ?? 'Semester'); ?>
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
              <p class="text-secondary lead mt-3">Dokumentasi lengkap kegiatan semester ini</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Gallery Grid Responsive -->
    <div class="row g-4 <?= count($gallery ?? []) === 1 ? 'justify-content-center' : '' ?>">
      <?php if (!empty($gallery)): ?>
        <?php foreach ($gallery as $index => $img): ?>
          <div class="<?= count($gallery) === 1 ? 'col-12 col-md-8 col-lg-6' : 'col-12 col-md-6 col-lg-6' ?>">
            <div class="gallery-card h-100" data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
              <div class="gallery-item position-relative rounded overflow-hidden shadow-sm">
                <img
                  src="<?= htmlspecialchars($img['image_url']) ?>"
                  alt="Gallery <?= $index + 1 ?>"
                  class="img-fluid gallery-thumb"
                  style="height:350px;object-fit:cover;width:100%;"
                  onclick="openGalleryModal('<?= htmlspecialchars($img['image_url']) ?>', '<?= htmlspecialchars($img['caption'] ?? '') ?>')"
                >
                <div class="gallery-overlay">
                  <div class="text-white fw-semibold d-flex align-items-center gap-2">
                  </div>
                </div>
              </div>
              <div class="text-center mt-3">
                <?php if (!empty($img['caption'])): ?>
                  <div class="small text-muted text-truncate" title="<?= htmlspecialchars($img['caption']) ?>">
                    "<?= htmlspecialchars($img['caption']) ?>"
                  </div>
                <?php else: ?>
                  <div class="small text-muted">Dokumentasi Kegiatan</div>
                <?php endif; ?>
                <button class="btn btn-mustard btn-lg mt-3 px-4 py-2" onclick="openGalleryModal('<?= htmlspecialchars($img['image_url']) ?>', '<?= htmlspecialchars($img['caption'] ?? '') ?>')">
                  <i class="bi bi-zoom-in me-2"></i>Lihat Ukuran Penuh
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
              <p class="text-muted mb-0">Belum ada foto di galeri semester ini</p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Modal Preview -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title text-mustard fw-bold">
          <i class="bi bi-image me-2"></i>Preview Foto
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-2">
        <img id="modalGalleryImg" src="" class="img-fluid w-100 rounded mb-3" alt="Preview">
        <div id="modalGalleryCaption" class="text-center text-secondary"></div>
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
.empty-state {
  font-size: 4rem;
  color: #e5e7eb;
  margin-bottom: 1rem;
}
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
function openGalleryModal(imgUrl, caption) {
  document.getElementById('modalGalleryImg').src = imgUrl;
  document.getElementById('modalGalleryCaption').innerText = caption || '';
  const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
  modal.show();
}
</script>
