<?php $title='Admin - Galeri Semester'; ?>
<?php if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . url('login'));
    exit;
} ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-mustard text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1">
                                <i class="fas fa-images me-2"></i>
                                Kelola Galeri
                            </h3>
                            <p class="mb-0 opacity-75">Manajemen galeri foto SIKC B 2023</p>
                        </div>
                        <div class="text-end">
                            <?php if(!empty($semesters)): ?>
                            <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus me-2"></i>Tambah Foto
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(empty($semesters)): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Belum ada semester. <a href="<?= url('admin/semesters') ?>" class="alert-link">Tambah semester</a> terlebih dahulu.
                </div>
            <?php else: ?>
                <!-- Semester Filter -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="semesterFilter" class="form-label">Filter berdasarkan Semester:</label>
                        <select class="form-select" id="semesterFilter" onchange="filterSemester(this.value)">
                            <?php foreach($semesters as $semester): ?>
                                <option value="<?= $semester['id'] ?>" <?= $semester['id'] == $sid ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($semester['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if(empty($gallery)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Belum ada foto di galeri semester ini. Klik tombol "Tambah Foto" untuk menambah foto.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach($gallery as $image): ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card gallery-card">
                                <div class="gallery-image-container">
                                    <img src="<?= htmlspecialchars($image['image_url'] ?? '/assets/img/placeholder.png') ?>" 
                                         alt="Gallery Image" 
                                         class="card-img-top gallery-image"
                                         onclick="viewImage('<?= htmlspecialchars($image['image_url'] ?? '/assets/img/placeholder.png') ?>')">
                                </div>
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">ID: <?= $image['id'] ?></small>
                                        <form method="POST" action="<?= url('admin/gallery/delete') ?>" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                            <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                                            <input type="hidden" name="operation" value="delete">
                                            <input type="hidden" name="id" value="<?= $image['id'] ?>">
                                            <input type="hidden" name="semester_id" value="<?= $sid ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<?php if(!empty($semesters)): ?>
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Foto ke Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                    <input type="hidden" name="operation" value="add">
                    
                    <div class="form-group mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-control" id="semester_id" name="semester_id" required>
                            <?php foreach($semesters as $semester): ?>
                                <option value="<?= $semester['id'] ?>" <?= $semester['id'] == $sid ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($semester['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="gallery_image" class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control" id="gallery_image" name="gallery_image" accept="image/*" required>
                        <small class="form-text text-muted">Format didukung: JPG, JPEG, PNG, GIF, WebP — gambar akan dikompresi otomatis.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mustard">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Image View Modal -->
<div class="modal fade" id="imageViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="viewImage" src="" class="img-fluid" alt="Gallery Image">
            </div>
        </div>
    </div>
</div>

<style>
.gallery-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.gallery-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.gallery-image-container {
    height: 200px;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-image:hover {
    transform: scale(1.05);
}

.mustard-text {
    color: #D4AF37 !important;
}

.btn-mustard {
    background-color: #D4AF37;
    border-color: #D4AF37;
    color: white;
}

.btn-mustard:hover {
    background-color: #B8941F;
    border-color: #B8941F;
    color: white;
}

.bg-gradient-mustard {
    background: linear-gradient(135deg, #D4AF37, #B8941F);
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    border-radius: 0.35rem;
}
</style>

<script>
function filterSemester(semesterId) {
    window.location.href = '<?= url('admin/gallery') ?>?semester_id=' + semesterId;
}

function viewImage(imageUrl) {
    document.getElementById('viewImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('imageViewModal')).show();
}
</script>
