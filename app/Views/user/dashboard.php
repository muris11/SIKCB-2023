<?php
// Load config with fallback (prioritize local development)
$configCandidates = [
    __DIR__ . '/../../Config/config.php',
    __DIR__ . '/../../Config/config_production.php'
];
foreach ($configCandidates as $cfg) {
    if (is_file($cfg)) { require_once $cfg; break; }
}

// Ambil user berdasarkan ID dari database langsung
$currentUser = null;
$displayName = 'User';
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && isset($GLOBALS['pdo'])) {
    $stmt = $GLOBALS['pdo']->prepare('SELECT name, email, role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($currentUser && !empty(trim($currentUser['name']))) {
        $displayName = trim($currentUser['name']);
    } elseif ($currentUser && !empty($currentUser['email'])) {
        $displayName = ucfirst(explode('@', $currentUser['email'])[0]);
    }
}

// Debug: Cek apakah variable $myClasses ada
if (!isset($myClasses)) {
    $myClasses = [];
}
if (!isset($semesters)) {
    $semesters = [];
}

// Jika data tidak ada, coba ambil langsung dari database
if (empty($myClasses) && isset($_SESSION['user_id']) && isset($GLOBALS['pdo'])) {
    try {
        // Query mata kuliah yang dikelola user (pj_user_id)
        $stmt = $GLOBALS['pdo']->prepare("
            SELECT c.*, s.name as semester_name, c.name as class_name,
                   COALESCE(c.teacher, 'Belum diatur') as teacher,
                   COALESCE(c.schedule, 'Belum dijadwalkan') as schedule,
                   COALESCE(c.status, 'active') as status
            FROM classes c 
            LEFT JOIN semesters s ON c.semester_id = s.id 
            WHERE c.pj_user_id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $myClasses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching classes: " . $e->getMessage());
        $myClasses = [];
    }
}

// Debug info (aktif untuk testing)
echo "<!-- Debug: myClasses count: " . count($myClasses) . " -->";
echo "<!-- Debug: user_id: " . ($_SESSION['user_id'] ?? 'not set') . " -->";
if (!empty($myClasses)) {
    echo "<!-- Debug: First class: " . json_encode($myClasses[0]) . " -->";
}
?>
<section class="dashboard-sikc-section py-5 bg-light">
  <div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="section-icon">
                  <i class="bi bi-person-circle"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                Selamat datang, <span class="gradient-text"><?= htmlspecialchars($displayName) ?></span>!
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Kelola mata kuliah dan lihat informasi semester Anda</p>
              <div class="mt-4">
                <span class="badge bg-mustard fs-6 px-3 py-2">
                  <i class="bi bi-person-circle me-1"></i>Dashboard User
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4">
          <div class="section-icon-small me-3">
            <i class="bi bi-bar-chart"></i>
          </div>
          <div>
            <h3 class="text-mustard fw-bold mb-0">Statistik</h3>
            <p class="text-muted small mb-0">Ringkasan data Anda</p>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="card border-0 shadow-sm class-card h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                  <div class="class-icon me-3">
                    <i class="bi bi-easel2"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h5 class="card-title fw-bold mb-2 text-dark">Mata Kuliah PJ</h5>
                    <p class="card-text text-secondary small mb-3">
                      <?php
                        if (!empty($myClasses)) {
                          $classNames = array_map(function($c) {
                            return htmlspecialchars($c['name']);
                          }, $myClasses);
                          echo implode(', ', $classNames);
                        } else {
                          echo 'Belum ada mata kuliah yang Anda kelola';
                        }
                      ?>
                    </p>
                  </div>
                  <div class="sks-badge-small ms-2">
                    <div class="sks-number-small"><?= count($myClasses) ?></div>
                    <div class="sks-label-small">MK</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card border-0 shadow-sm class-card h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                  <div class="class-icon me-3">
                    <i class="bi bi-calendar-event"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h5 class="card-title fw-bold mb-2 text-dark">Total Semester</h5>
                    <p class="card-text text-secondary small mb-3">Jumlah semester tersedia</p>
                  </div>
                  <div class="sks-badge-small ms-2">
                    <div class="sks-number-small"><?= count($semesters) ?></div>
                    <div class="sks-label-small">SEM</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- My Classes Section -->
    <?php if(!empty($myClasses)): ?>
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4">
          <div class="section-icon me-3">
            <i class="bi bi-journal-text"></i>
          </div>
          <div>
            <h3 class="text-mustard fw-bold mb-0">Mata Kuliah PJ</h3>
            <p class="text-muted small mb-0">Mata kuliah yang Anda kelola</p>
          </div>
        </div>

        <div class="row g-3">
          <?php foreach($myClasses as $class): ?>
            <div class="col-12 col-lg-6">
              <div class="card border-0 shadow-sm class-card h-100">
                <div class="card-body p-4">
                  <div class="d-flex align-items-start mb-3">
                    <div class="class-icon me-3">
                      <i class="bi bi-book"></i>
                    </div>
                    <div class="flex-grow-1">
                      <h5 class="card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($class['name']) ?></h5>
                      <p class="card-text text-secondary small mb-3">Semester: <?= htmlspecialchars($class['semester_name']) ?></p>
                    </div>
                  </div>
                  
                  <div class="class-info mb-3">
                    <div class="info-item mb-2">
                      <i class="bi bi-person-workspace text-mustard me-2"></i>
                      <span class="text-secondary small"><?= htmlspecialchars($class['teacher']) ?></span>
                    </div>
                    <div class="info-item mb-2">
                      <i class="bi bi-calendar-event text-mustard me-2"></i>
                      <span class="text-secondary small"><?= htmlspecialchars($class['schedule']) ?></span>
                    </div>
                  </div>

                  <div>
                    <span class="badge status-badge status-<?= $class['status'] ?> px-3 py-2">
                      <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                      <?= ucfirst($class['status']) ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- All Semesters Section -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4">
          <div class="section-icon me-3">
            <i class="bi bi-collection"></i>
          </div>
          <div>
            <h3 class="text-mustard fw-bold mb-0">Semua Semester</h3>
            <p class="text-muted small mb-0">Daftar semester tersedia</p>
          </div>
        </div>

        <?php if(!empty($semesters)): ?>
          <div class="row g-3">
            <?php foreach($semesters as $semester): ?>
              <div class="col-md-4">
                <div class="card border-0 shadow-sm class-card h-100 text-center">
                  <div class="card-body p-4">
                    <div class="class-icon mx-auto mb-3">
                      <i class="bi bi-calendar2-event"></i>
                    </div>
                    <h6 class="card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($semester['name']) ?></h6>
                    <p class="card-text text-secondary small mb-3"><?= htmlspecialchars($semester['term_label']) ?></p>
                    <a href="<?= url('semester/' . $semester['id']) ?>" class="btn btn-outline-mustard">
                      <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
              <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
              </div>
              <h5 class="text-secondary mb-2">Belum Ada Semester</h5>
              <p class="text-muted mb-0">Belum ada semester tersedia</p>
            </div>
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

/* Section Styling */
.dashboard-sikc-section {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
}

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

.section-icon-small {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
  box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
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
  font-size: 1.5rem;
  font-weight: bold;
  line-height: 1;
  margin-bottom: 0.1rem;
}

.sks-label-small {
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  opacity: 0.9;
}

/* Status Badge */
.status-badge {
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: capitalize;
  border-radius: 20px;
}

.status-active {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
}

.status-completed {
  background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
  color: white;
}

.status-warning {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
}

/* Button Styles */
.btn-mustard {
  background-color: var(--mustard);
  border-color: var(--mustard);
  color: #fff;
  border-radius: 0.75rem;
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
  
  .section-icon-small {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
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

  .sks-number-small {
    font-size: 1.2rem;
  }
}
</style>
