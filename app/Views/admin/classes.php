<?php $title='Admin - Kelas'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-mustard text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1">
                                <i class="fas fa-book me-2"></i>
                                Kelola Mata Kuliah
                            </h3>
                            <p class="mb-0 opacity-75">Manajemen mata kuliah SIKC B 2023</p>
                        </div>
                        <div class="text-end">
                            <?php if(!empty($semesters)): ?>
                            <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus me-2"></i>Tambah Mata Kuliah
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
                            <option value="">Semua Semester</option>
                            <?php foreach($semesters as $semester): ?>
                                <option value="<?= $semester['id'] ?>" <?= isset($_GET['semester_id']) && $_GET['semester_id'] == $semester['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($semester['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if(empty($classes)): ?>
                    <div class="card shadow">
                        <div class="card-body text-center py-5">
                            <div class="empty-state mb-3">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-secondary mb-2">Belum Ada Mata Kuliah</h5>
                            <p class="text-muted mb-3">Klik tombol "Tambah Mata Kuliah" untuk menambah data.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Semester</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>Pengajar</th>
                                    <th>Jadwal</th>
                                    <th>SKS</th>
                                    <th>Status</th>
                                    <th>PJ</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($classes as $class): ?>
                                <tr>
                                    <td><?= $class['id'] ?></td>
                                    <td><?= htmlspecialchars($class['semester_name']) ?></td>
                                    <td><?= htmlspecialchars($class['name']) ?></td>
                                    <td><?= htmlspecialchars($class['teacher']) ?></td>
                                    <td><?= htmlspecialchars($class['schedule']) ?></td>
                                    <td><?= $class['sks'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $class['status'] === 'active' ? 'success' : ($class['status'] === 'completed' ? 'secondary' : 'warning') ?>">
                                            <?= ucfirst($class['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= $class['pj_name'] ? htmlspecialchars($class['pj_name']) : '<em class="text-muted">Belum ada</em>' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-mustard me-1" onclick="editClass(<?= htmlspecialchars(json_encode($class)) ?>)">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form method="POST" action="<?= url('admin/class/delete') ?>" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                            <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                                            <input type="hidden" name="operation" value="delete">
                                            <input type="hidden" name="id" value="<?= $class['id'] ?>">
                                            <input type="hidden" name="semester_id" value="<?= $class['semester_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="<?= url('admin/classes') ?>" id="addForm">
                    <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                    <input type="hidden" name="operation" value="add">
                    
                    <div class="form-group mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-control" id="semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            <?php foreach($semesters as $semester): ?>
                                <option value="<?= $semester['id'] ?>">
                                    <?= htmlspecialchars($semester['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="teacher" class="form-label">Pengajar</label>
                        <input type="text" class="form-control" id="teacher" name="teacher" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="schedule" class="form-label">Jadwal</label>
                        <input type="text" class="form-control" id="schedule" name="schedule" placeholder="Senin, 08:00-10:00">
                    </div>

                    <div class="form-group mb-3">
                        <label for="sks" class="form-label">SKS</label>
                        <input type="number" class="form-control" id="sks" name="sks" value="3" min="1" max="6" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="pj_user_id" class="form-label">Penanggung Jawab (PJ)</label>
                        <select class="form-control" id="pj_user_id" name="pj_user_id">
                            <option value="">Pilih PJ (Opsional)</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-mustard">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="<?= url('admin/classes') ?>" id="editForm">
                    <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                    <input type="hidden" name="operation" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="form-group mb-3">
                        <label for="edit_semester_id" class="form-label">Semester</label>
                        <select class="form-control" id="edit_semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            <?php foreach($semesters as $semester): ?>
                                <option value="<?= $semester['id'] ?>"><?= htmlspecialchars($semester['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_name" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_teacher" class="form-label">Pengajar</label>
                        <input type="text" class="form-control" id="edit_teacher" name="teacher" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_schedule" class="form-label">Jadwal</label>
                        <input type="text" class="form-control" id="edit_schedule" name="schedule">
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_sks" class="form-label">SKS</label>
                        <input type="number" class="form-control" id="edit_sks" name="sks" min="1" max="6" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_pj_user_id" class="form-label">Penanggung Jawab (PJ)</label>
                        <select class="form-control" id="edit_pj_user_id" name="pj_user_id">
                            <option value="">Pilih PJ (Opsional)</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-mustard">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function filterSemester(semesterId) {
    if (semesterId) {
        window.location.href = '<?= url('admin/classes') ?>?semester_id=' + semesterId;
    } else {
        window.location.href = '<?= url('admin/classes') ?>';
    }
}

function editClass(classData) {
    document.getElementById('edit_id').value = classData.id;
    document.getElementById('edit_semester_id').value = classData.semester_id;
    document.getElementById('edit_name').value = classData.name;
    document.getElementById('edit_teacher').value = classData.teacher;
    document.getElementById('edit_schedule').value = classData.schedule;
    document.getElementById('edit_sks').value = classData.sks;
    document.getElementById('edit_status').value = classData.status;
    document.getElementById('edit_description').value = classData.description;
    document.getElementById('edit_pj_user_id').value = classData.pj_user_id || '';
    
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<style>
.mustard-text { color: #D4AF37 !important; }
.btn-mustard {
    background-color: #D4AF37;
    border-color: #D4AF37;
    color: white;
}
.btn-outline-mustard {
    color: #D4AF37;
    border-color: #D4AF37;
}

.bg-gradient-mustard {
    background: linear-gradient(135deg, #D4AF37, #B8941F);
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    border-radius: 0.35rem;
}

.empty-state {
    opacity: 0.6;
}

.table-hover tbody tr:hover {
    background-color: rgba(212, 175, 55, 0.1) !important;
}
</style>
