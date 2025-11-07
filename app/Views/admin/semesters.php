<?php $title='Admin - Semester'; ?>
<?php if (isset($_SESSION['flash_success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= \App\Core\Session::flash('success', '') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="container-fluid mt-4">
    <div class="card bg-gradient-mustard text-white mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-1">
                        <i class="fas fa-calendar me-2"></i>
                        Kelola Semester
                    </h3>
                    <p class="mb-0 opacity-75">Manajemen semester SIKC B 2023</p>
                </div>
                <div class="text-end">
                    <i class="fas fa-graduation-cap fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
<div class="row g-3">
  <div class="col-md-4">
    <div class="p-3 border rounded-2xl h-100">
      <form method="post" action="<?= url('admin/semester/save') ?>" enctype="multipart/form-data">
        <input type="hidden" name="_csrf" value="<?= $csrf ?>"/>
        <input type="hidden" name="id" id="sid"/>
        <div class="mb-2"><label class="form-label">Nama</label><input class="form-control" name="name" id="sname" required></div>
        <div class="mb-2"><label class="form-label">Label (cth: Ganjil 2025)</label><input class="form-control" name="term_label" id="sterm" required></div>
        <div class="mb-2"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" id="sdesc"></textarea></div>
        <div class="mb-2"><label class="form-label">Cover Image</label><input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*"></div>
        <button class="btn btn-primary w-100"><i class="bi bi-plus-lg me-1"></i>Simpan</button>
      </form>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card border-0 shadow-sm rounded-2xl">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>ID</th><th>Nama</th><th>Label</th><th>Cover</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
          <tbody>
            <?php if (empty($semesters)): ?>
              <tr>
                <td colspan="6" class="text-center py-4">
                  <i class="bi bi-inbox display-6 text-muted"></i>
                  <p class="text-muted mt-2">Belum ada semester. Silakan tambahkan semester pertama.</p>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach($semesters as $s): ?>
              <tr>
                  <td><?= $s['id'] ?></td>
                  <td><?= htmlspecialchars($s['name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($s['term_label'] ?? '') ?></td>
                  <td>
                    <?php if (!empty($s['cover_image'])): ?>
                      <img src="<?= url('image/semester/' . $s['id']) ?>" alt="cover" style="max-width:60px;max-height:40px;border-radius:6px;object-fit:cover;">
                    <?php else: ?>
                      <span class="text-muted small">-</span>
                    <?php endif; ?>
                  </td>
                  <td style="max-width:220px;white-space:normal;">
                    <span class="text-secondary small"><?= htmlspecialchars($s['description'] ?? '') ?></span>
                  </td>
                  <td>
                    <button class="btn btn-outline-secondary btn-sm" onclick="editSemester(
                        <?= (int)$s['id'] ?>,
                        '<?= htmlspecialchars(addslashes($s['name'] ?? ''), ENT_QUOTES) ?>',
                        '<?= htmlspecialchars(addslashes($s['term_label'] ?? ''), ENT_QUOTES) ?>',
                        '<?= htmlspecialchars(addslashes($s['description'] ?? ''), ENT_QUOTES) ?>'
                    )">Edit</button>
                    <form method="POST" action="<?= url('admin/semester/delete') ?>" class="d-inline" onsubmit="return confirm('Hapus semester?')">
                        <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                        <input type="hidden" name="operation" value="delete">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button class="btn btn-outline-danger btn-sm">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Semester</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="<?= url('admin/semesters') ?>">
                <div class="modal-body">
                    <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                    <input type="hidden" name="operation" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_term_label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="edit_term_label" name="term_label">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_cover_image" class="form-label">Cover Image (opsional)</label>
                        <input type="file" class="form-control" id="edit_cover_image" name="cover_image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mustard">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-mustard {
    background: linear-gradient(135deg, #D4AF37, #B8941F);
}

.text-mustard {
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

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    border-radius: 0.35rem;
}
</style>

<script>
function editSemester(id, name, term_label, description) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name || '';
    document.getElementById('edit_term_label').value = term_label || '';
    document.getElementById('edit_description').value = description || '';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
