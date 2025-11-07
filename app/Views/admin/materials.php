<?php $title='Admin - Materi'; ?>
<h3 class="mb-3">Kelola Materi</h3>

<?php if (empty($classes)): ?>
  <div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Belum ada kelas yang tersedia. <a href="<?= url('admin/classes') ?>" class="alert-link">Tambahkan kelas terlebih dahulu</a>.
  </div>
<?php else: ?>
  <form class="mb-3 d-flex" method="get" action="<?= url('admin/materials') ?>">
    <label class="me-2">Kelas</label>
    <select class="form-select me-2" style="max-width:280px" name="class_id" onchange="this.form.submit()">
      <?php foreach ($classes as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $cid===$c['id']?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?>
    </select>
  </form>
<?php endif; ?>
<div class="alert alert-warning">
    <h4>File Tidak Digunakan</h4>
    <p>Tabel <code>materials</code> tidak ada dalam database schema. File ini dapat dihapus.</p>
    <p>Database hanya memiliki tabel: users, semesters, classes, gallery, password_resets</p>
</div>
