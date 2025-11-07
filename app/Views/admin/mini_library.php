<?php $title = 'Admin - Mini Library'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-mustard text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1">
                                <i class="bi bi-collection me-2"></i>
                                Kelola Mini Library
                            </h3>
                            <p class="mb-0 opacity-75">Manajemen proyek mini library SIKC B 2023</p>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#addLibraryModal">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Mini Library
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php $flashes = \App\Core\Session::flashes(); ?>
            <?php foreach ($flashes as $flash): ?>
                <?php $type = $flash['t'] ?? 'info';
                      $message = $flash['m'] ?? '';
                      $alertType = $type === 'success' ? 'success' : ($type === 'error' ? 'danger' : 'info'); ?>
                <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="searchLibrary" class="form-label">Cari Mini Library:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari nama grup, kategori, atau anggota..." id="searchLibrary">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-end justify-content-end">
                    <small class="text-muted">Total: <strong id="totalCount"><?= count($libraries ?? []) ?></strong> mini library</small>
                </div>
            </div>

            <?php if (empty($libraries)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada mini library. Klik tombol "Tambah Mini Library" untuk menambah proyek pertama.
                </div>
            <?php else: ?>
                <div class="row" id="libraryContainer">
                    <?php foreach ($libraries as $index => $library):
                        $id = htmlspecialchars($library['id'] ?? '', ENT_QUOTES, 'UTF-8');
                        $groupName = htmlspecialchars($library['group_name'] ?? 'Untitled', ENT_QUOTES, 'UTF-8');
                        $description = htmlspecialchars($library['description'] ?? '', ENT_QUOTES, 'UTF-8');
                        $category = htmlspecialchars($library['category'] ?? '', ENT_QUOTES, 'UTF-8');
                        $image = htmlspecialchars($library['image'] ?? '', ENT_QUOTES, 'UTF-8');
                        $link = htmlspecialchars($library['link'] ?? '', ENT_QUOTES, 'UTF-8');
                        $createdAt = !empty($library['created_at']) ? date('d/m/Y', strtotime($library['created_at'])) : '-';
                        $members = [];
                        if (isset($library['members'])) {
                            if (is_string($library['members'])) {
                                $members = json_decode($library['members'], true) ?: [];
                            } elseif (is_array($library['members'])) {
                                $members = $library['members'];
                            }
                        }
                        $memberCount = count($members);
                        $memberNames = array_map(function($member) {
                            return is_array($member) && isset($member['name']) ? $member['name'] : (string)$member;
                        }, $members);
                    ?>
                    <div class="col-md-3 col-sm-6 mb-4 library-item" data-search="<?= strtolower($groupName . ' ' . $category . ' ' . implode(' ', array_map('htmlspecialchars', $memberNames))) ?>">
                        <div class="card library-card">
                            <div class="library-image-container">
                                <?php if (!empty($image)): ?>
                                    <img src="<?= $image ?>" alt="<?= $groupName ?>" class="card-img-top library-image" onclick="viewImage('<?= $image ?>')">
                                <?php else: ?>
                                    <div class="library-placeholder" onclick="viewImage('/assets/img/placeholder.png')">
                                        <i class="bi bi-collection text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="library-overlay">
                                    <span class="badge bg-info text-dark"><?= $category ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title mb-2 text-truncate" title="<?= $groupName ?>"><?= $groupName ?></h6>
                                <p class="card-text text-muted small mb-2" style="height: 40px; overflow: hidden;">
                                    <?= mb_substr($description, 0, 80) ?><?= mb_strlen($description) > 80 ? '...' : '' ?>
                                </p>
                                
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-people me-1"></i>Anggota Tim:
                                    </small>
                                    <?php if ($memberCount > 0): ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach (array_slice($members, 0, 2) as $member):
                                                $memberName = is_array($member) && isset($member['name']) ? htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8') : htmlspecialchars($member, ENT_QUOTES, 'UTF-8');
                                            ?>
                                                <span class="badge bg-secondary small"><?= $memberName ?></span>
                                            <?php endforeach; ?>
                                            <?php if ($memberCount > 2): ?>
                                                <span class="badge bg-dark small" title="<?= implode(', ', array_slice(array_map(function($m) { return is_array($m) && isset($m['name']) ? $m['name'] : $m; }, $members), 2)) ?>">
                                                    +<?= $memberCount - 2 ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">Tidak ada anggota</span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i><?= $createdAt ?>
                                    </small>
                                    <div class="btn-group" role="group">
                                        <?php if (!empty($link) && filter_var($link, FILTER_VALIDATE_URL)): ?>
                                            <a href="<?= htmlspecialchars($link, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Kunjungi Link">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editLibrary(this)"
                                            data-id="<?= $id ?>"
                                            data-group-name="<?= $groupName ?>"
                                            data-description="<?= $description ?>"
                                            data-category="<?= $category ?>"
                                            data-image="<?= $image ?>"
                                            data-link="<?= $link ?>"
                                            data-members='<?= htmlspecialchars(json_encode($members), ENT_QUOTES, 'UTF-8') ?>'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteLibrary(<?= $id ?>, '<?= addslashes($groupName) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div id="noResults" class="alert alert-warning d-none">
                    <i class="bi bi-search me-2"></i>Tidak ada hasil yang ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Mini Library -->
<div class="modal fade" id="addLibraryModal" tabindex="-1" aria-labelledby="addLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Mini Library Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="libraryForm" action="<?= url('admin/mini_library/save') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf'] ?? bin2hex(random_bytes(16)), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="id" id="libraryId" value="">
                <input type="hidden" name="image" id="imageHidden" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="groupName" class="form-label">Nama Grup <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="group_name" id="groupName" placeholder="Masukkan nama kelompok" required maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" name="category" id="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Programming">Programming</option>
                                    <option value="Design">Design</option>
                                    <option value="Data Science">Data Science</option>
                                    <option value="Web Development">Web Development</option>
                                    <option value="Mobile Development">Mobile Development</option>
                                    <option value="DevOps">DevOps</option>
                                    <option value="AI/ML">AI/ML</option>
                                    <option value="Cybersecurity">Cybersecurity</option>
                                    <option value="Game Development">Game Development</option>
                                    <option value="Smart City">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="libraryImage" class="form-label">Gambar Proyek</label>
                                <input type="file" class="form-control" name="library_image" id="libraryImage" accept="image/jpeg,image/png,image/gif,image/webp">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, WEBP — gambar akan dikompresi otomatis.</small>
                                <div class="mt-2" id="imagePreviewContainer">
                                    <img id="imagePreview" src="" alt="Preview" class="img-thumbnail d-none" style="max-width: 100%; max-height: 150px; object-fit: cover;">
                                    <button type="button" id="removeImageBtn" class="btn btn-sm btn-outline-danger mt-2 d-none" onclick="removeImage()">
                                        <i class="bi bi-x-circle me-1"></i>Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Deskripsi singkat tentang proyek..." required maxlength="1000"></textarea>
                        <small class="text-muted"><span id="charCount">0</span>/1000 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Anggota Tim <span class="text-danger">*</span></label>
                        <div id="membersContainer">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control member-input" name="members[]" placeholder="Nama anggota tim" required maxlength="100">
                                <button type="button" class="btn btn-outline-success" onclick="addMember()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Minimal harus ada satu anggota tim</small>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link Proyek <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="link" id="link" placeholder="https://example.com" required>
                        <small class="text-muted">Link ke GitHub, demo, atau website proyek</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-mustard" id="submitBtn">
                        <i class="bi bi-save me-1"></i>Simpan Mini Library
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image View Modal -->
<div class="modal fade" id="imageViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="viewImage" src="" class="img-fluid" alt="Library Image">
            </div>
        </div>
    </div>
</div>

<style>
.library-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.library-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.library-image-container {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.library-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.library-image:hover {
    transform: scale(1.05);
}

.library-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.library-placeholder:hover {
    background-color: #e9ecef;
}

.library-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
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

.badge {
    font-weight: 500;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

#imagePreview {
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.member-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: row;
    }
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}
</style>

<script>
let memberCount = 1;

function addMember() {
    memberCount++;
    const container = document.getElementById('membersContainer');
    const memberDiv = document.createElement('div');
    memberDiv.className = 'input-group mb-2 member-item';
    memberDiv.innerHTML = `
        <input type="text" class="form-control member-input" name="members[]" placeholder="Nama anggota tim" required maxlength="100">
        <button type="button" class="btn btn-outline-danger" onclick="removeMember(this)"><i class="bi bi-dash"></i></button>
    `;
    container.appendChild(memberDiv);
}

function removeMember(button) {
    if (memberCount > 1) {
        button.closest('.member-item').remove();
        memberCount--;
    } else {
        alert('Minimal harus ada satu anggota tim!');
    }
}

function editLibrary(btn) {
    const id = btn.dataset.id || '';
    const groupName = btn.dataset.groupName || '';
    const description = btn.dataset.description || '';
    const category = btn.dataset.category || '';
    const link = btn.dataset.link || '';
    const image = btn.dataset.image || '';
    let members = [];
    try { members = JSON.parse(btn.dataset.members || '[]'); } catch (e) { members = []; }
    
    document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Mini Library';
    document.getElementById('submitBtn').innerHTML = '<i class="bi bi-save me-1"></i>Update Mini Library';
    
    document.getElementById('libraryId').value = id;
    document.getElementById('groupName').value = groupName;
    document.getElementById('description').value = description;
    document.getElementById('category').value = category;
    document.getElementById('link').value = link;
    document.getElementById('imageHidden').value = image;
    
    // Image preview
    if (image) {
        const preview = document.getElementById('imagePreview');
        const removeBtn = document.getElementById('removeImageBtn');
        preview.src = image;
        preview.classList.remove('d-none');
        removeBtn.classList.remove('d-none');
    }
    
    // Members
    const container = document.getElementById('membersContainer');
    container.innerHTML = '';
    memberCount = 0;
    if (members.length > 0) {
        members.forEach((member, index) => {
            const memberName = typeof member === 'object' && member.name ? member.name : member;
            const memberDiv = document.createElement('div');
            memberDiv.className = 'input-group mb-2' + (index > 0 ? ' member-item' : '');
            memberDiv.innerHTML = `
                <input type="text" class="form-control member-input" name="members[]" value="${escapeHtml(memberName)}" placeholder="Nama anggota tim" required maxlength="100">
                <button type="button" class="btn btn-outline-${index === 0 ? 'success' : 'danger'}" onclick="${index === 0 ? 'addMember()' : 'removeMember(this)'}"><i class="bi bi-${index === 0 ? 'plus' : 'dash'}"></i></button>
            `;
            container.appendChild(memberDiv);
            memberCount++;
        });
    } else {
        addMember();
    }
    
    const modal = new bootstrap.Modal(document.getElementById('addLibraryModal'));
    modal.show();
}

function deleteLibrary(id, groupName) {
    if (confirm(`Apakah Anda yakin ingin menghapus mini library "${groupName}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= url('admin/mini_library/delete') ?>';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_csrf';
        csrfInput.value = '<?= htmlspecialchars($_SESSION['csrf'] ?? '', ENT_QUOTES, 'UTF-8') ?>';
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(csrfInput);
        form.appendChild(idInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function removeImage() {
    document.getElementById('libraryImage').value = '';
    document.getElementById('imagePreview').classList.add('d-none');
    document.getElementById('removeImageBtn').classList.add('d-none');
}

function viewImage(imageUrl) {
    document.getElementById('viewImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('imageViewModal')).show();
}

function escapeHtml(text) {
    const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
    return String(text).replace(/[&<>"']/g, m => map[m]);
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchLibrary');
    const libraryContainer = document.getElementById('libraryContainer');
    const noResults = document.getElementById('noResults');
    const totalCount = document.getElementById('totalCount');
    
    if (searchInput && libraryContainer) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = libraryContainer.querySelectorAll('.library-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchData = item.dataset.search || '';
                if (searchData.includes(searchTerm)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (totalCount) totalCount.textContent = visibleCount;
            if (noResults) noResults.classList.toggle('d-none', visibleCount > 0 || searchTerm === '');
        });
    }
    
    const fileInput = document.getElementById('libraryImage');
    const preview = document.getElementById('imagePreview');
    const removeBtn = document.getElementById('removeImageBtn');
    
    if (fileInput && preview) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid. Gunakan JPG, PNG, GIF, atau WEBP.');
                fileInput.value = '';
                return;
            }
            
            // No client-side hard size limit; server will compress automatically
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                removeBtn.classList.remove('d-none');
            };
            reader.onerror = function() { alert('Gagal membaca file. Silakan coba lagi.'); };
            reader.readAsDataURL(file);
        });
    }
    
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    if (description && charCount) {
        description.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
    
    const modal = document.getElementById('addLibraryModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            document.getElementById('libraryForm').reset();
            document.getElementById('libraryId').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Tambah Mini Library Baru';
            document.getElementById('submitBtn').innerHTML = '<i class="bi bi-save me-1"></i>Simpan Mini Library';
            document.getElementById('imagePreview').classList.add('d-none');
            document.getElementById('removeImageBtn').classList.add('d-none');
            document.getElementById('charCount').textContent = '0';
            const container = document.getElementById('membersContainer');
            container.innerHTML = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control member-input" name="members[]" placeholder="Nama anggota tim" required maxlength="100">
                    <button type="button" class="btn btn-outline-success" onclick="addMember()"><i class="bi bi-plus"></i></button>
                </div>
            `;
            memberCount = 1;
        });
    }
    
    const form = document.getElementById('libraryForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const memberInputs = document.querySelectorAll('.member-input');
            let hasValidMember = false;
            memberInputs.forEach(input => { if (input.value.trim() !== '') hasValidMember = true; });
            if (!hasValidMember) {
                e.preventDefault();
                alert('Minimal harus ada satu anggota tim yang diisi!');
                return false;
            }
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        });
    }
    
    const alerts = document.querySelectorAll('.alert:not(.alert-warning)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
