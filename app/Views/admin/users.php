<?php $title='Admin - Pengguna'; ?>
<?php if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . url('login'));
    exit;
} ?>

<div class="container-fluid mt-4">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= \App\Core\Session::flash('success', '') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_danger'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= \App\Core\Session::flash('danger', '') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_warning'])): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= \App\Core\Session::flash('warning', '') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-mustard text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1">
                                <i class="fas fa-users me-2"></i>
                                Kelola Users
                            </h3>
                            <p class="mb-0 opacity-75">Manajemen pengguna SIKC B 2023</p>
                        </div>
                        <div class="text-end">
                            <div class="text-white opacity-75">
                                <small>Total: <?= count($rows) ?> users</small>
                            </div>
                            <button class="btn btn-light text-mustard fw-bold ms-3" onclick="new bootstrap.Modal(document.getElementById('addUserModal')).show();">
                                <i class="fas fa-user-plus me-1"></i>Tambah User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(empty($rows)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada users terdaftar.
                </div>
            <?php else: ?>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Terdaftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2">
                                                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                                                </div>
                                                <div>
                                                    <strong><?= htmlspecialchars($user['name']) ?></strong>
                                                    <?php if($user['id'] == $_SESSION['user_id']): ?>
                                                        <small class="badge bg-info ms-1">Anda</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                                <?= htmlspecialchars(ucfirst($user['role'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d M Y, H:i', $user['created_at']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-secondary btn-sm me-1" onclick="editUser(
                                                <?= (int)$user['id'] ?>,
                                                '<?= htmlspecialchars(addslashes($user['name']), ENT_QUOTES) ?>',
                                                '<?= htmlspecialchars(addslashes($user['email']), ENT_QUOTES) ?>',
                                                '<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>'
                                            )" <?= $user['role'] === 'admin' ? 'disabled' : '' ?>>Edit</button>
                                            <?php if($user['id'] != $_SESSION['user_id']): ?>
                                                <form method="POST" action="<?= url('admin/users/delete') ?>" style="display:inline;" 
                                                      onsubmit="return confirm('Yakin ingin menghapus user <?= htmlspecialchars($user['name']) ?>?')">
                                                    <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
                                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-lock"></i> Akun Anda
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- User Stats Cards -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-2x text-danger mb-2"></i>
                    <h4 class="text-danger">
                        <?= count(array_filter($rows, function($u) { return $u['role'] === 'admin'; })) ?>
                    </h4>
                    <small class="text-muted">Total Admin</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h4 class="text-primary">
                        <?= count(array_filter($rows, function($u) { return $u['role'] === 'user'; })) ?>
                    </h4>
                    <small class="text-muted">Total User</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pengelolaan Users
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><strong>Role Admin:</strong> Dapat mengakses semua fitur admin panel</li>
                        <li><strong>Role User:</strong> Dapat mengakses dashboard user dan mata kuliah yang menjadi tanggung jawabnya</li>
                        <li><strong>Hapus User:</strong> Akan menghapus semua data terkait user (PJ mata kuliah akan di-reset)</li>
                        <li><strong>Akun Sendiri:</strong> Tidak dapat mengubah role atau menghapus akun sendiri</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="<?= url('admin/user/edit') ?>">
        <div class="modal-body">
          <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
          <input type="hidden" name="id" id="edit_user_id">
          <div class="mb-3">
            <label for="edit_user_name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="edit_user_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="edit_user_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit_user_email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="edit_user_role" class="form-label">Role</label>
            <select class="form-control" id="edit_user_role" name="role">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-mustard">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="<?= url('admin/user/add') ?>">
        <div class="modal-body">
          <input type="hidden" name="_csrf" value="<?= \App\Core\Session::csrf() ?>">
          <div class="mb-3">
            <label for="add_user_name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="add_user_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="add_user_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="add_user_email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="add_user_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="add_user_password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="add_user_role" class="form-label">Role</label>
            <select class="form-control" id="add_user_role" name="role">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-mustard">Tambah User</button>
        </div>
      </form>
    </div>
  </div>
</div>



<style>
.mustard-text {
    color: #D4AF37 !important;
}

.bg-gradient-mustard {
    background: linear-gradient(135deg, #D4AF37, #B8941F);
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

.user-avatar {
    width: 40px;
}

.form-select-sm {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(212, 175, 55, 0.1) !important;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}
</style>

<script>
// Auto submit form when role changes
document.querySelectorAll('select[name="role"]').forEach(function(select) {
    select.addEventListener('change', function() {
        if(confirm('Yakin ingin mengubah role user ini?')) {
            this.form.submit();
        } else {
            // Reset to original value if cancelled
            this.selectedIndex = this.value === 'admin' ? 0 : 1;
        }
    });
});

function editUser(id, name, email, role) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_user_name').value = name;
    document.getElementById('edit_user_email').value = email;
    document.getElementById('edit_user_role').value = role;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}

// Debug Add User Form
document.addEventListener('DOMContentLoaded', function() {
    const addUserForm = document.querySelector('#addUserModal form');
    if (addUserForm) {
        addUserForm.addEventListener('submit', function(e) {
            console.log('Add User form submitted');
            const formData = new FormData(this);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            console.log('Action:', this.action);
            console.log('Method:', this.method);
            
            // Check if all required fields are filled
            const name = formData.get('name');
            const email = formData.get('email');
            const password = formData.get('password');
            
            if (!name || !email || !password) {
                alert('Please fill all required fields');
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
