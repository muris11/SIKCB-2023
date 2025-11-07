<?php $title='Admin Panel'; ?>

<?php if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect('login');
} 

// Get statistics (only for existing tables)
$totalUsers = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalSemesters = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM semesters")->fetchColumn();
$totalClasses = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$totalGallery = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$totalMiniLibrary = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM mini_library")->fetchColumn();
?>

<div class="container-fluid mt-4">
    <!-- Welcome Header -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-mustard text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard Administrator
                            </h3>
                            <p class="mb-0 opacity-75">Selamat datang di panel admin SIKC B 2023</p>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-user-shield fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-mustard shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-mustard text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Semester</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalSemesters ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Mata Kuliah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalClasses ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Galeri</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalGallery ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Mini Library</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalMiniLibrary ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Semester Terbaru</h6>
                </div>
                <div class="card-body">
                    <?php
                    $recentSemesters = $GLOBALS['pdo']->query("SELECT * FROM semesters ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($recentSemesters)):
                    ?>
                        <div class="list-group list-group-flush">
                            <?php foreach($recentSemesters as $semester): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= htmlspecialchars($semester['name']) ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($semester['term_label']) ?></small>
                                    </div>
                                    <span class="badge bg-mustard">ID: <?= $semester['id'] ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada semester</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Users Terbaru</h6>
                </div>
                <div class="card-body">
                    <?php
                    $recentUsers = $GLOBALS['pdo']->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($recentUsers)):
                    ?>
                        <div class="list-group list-group-flush">
                            <?php foreach($recentUsers as $user): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= htmlspecialchars($user['name']) ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                    </div>
                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada users</p>
                    <?php endif; ?>
                </div>
            </div>
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

.border-left-mustard {
    border-left: 0.25rem solid #D4AF37 !important;
}

.btn-outline-mustard {
    color: #D4AF37;
    border-color: #D4AF37;
}

.btn-outline-mustard:hover {
    background-color: #D4AF37;
    border-color: #D4AF37;
    color: white;
}

.bg-mustard {
    background-color: #D4AF37 !important;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.text-xs {
    font-size: 0.7rem;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}
</style>
