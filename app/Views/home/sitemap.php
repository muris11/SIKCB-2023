<div class="container py-5">
  <div class="row justify-content-center mb-4">
    <div class="col-lg-10">
      <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
        <div class="card-body p-lg-5 p-4">
          <div class="text-center mb-4">
            <div class="section-icon-wrapper mx-auto mb-3">
              <div class="section-icon"><i class="bi bi-diagram-3"></i></div>
              <div class="icon-glow"></div>
            </div>
            <h2 class="display-6 fw-bold mb-2">Sitemap</h2>
            <div class="section-divider mx-auto"></div>
            <p class="text-secondary mt-3 mb-0">Peta situs SIKC B 2023</p>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <h5 class="text-mustard mb-3"><i class="bi bi-house-door-fill me-2"></i>Halaman Utama</h5>
              <ul class="list-modern">
                <li><a href="<?= url() ?>">Beranda</a></li>
                <li><a href="<?= url('about') ?>">Tentang</a></li>
                <li><a href="<?= url('contact') ?>">Kontak</a></li>
                <li><a href="<?= url('semesters') ?>">Semester</a></li>
                <li><a href="<?= url('gallery') ?>">Galeri</a></li>
              </ul>

              <h5 class="text-mustard mt-4 mb-3"><i class="bi bi-shield-lock-fill me-2"></i>Autentikasi</h5>
              <ul class="list-modern">
                <li><a href="<?= url('login') ?>">Login</a></li>
                <li><a href="<?= url('register') ?>">Register</a></li>
                <li><a href="<?= url('password/forgot') ?>">Lupa Password</a></li>
              </ul>
            </div>

            <div class="col-md-6">
              <h5 class="text-mustard mb-3"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h5>
              <?php $isAdmin = \App\Core\Auth::check() && ((\App\Core\Auth::user()['role'] ?? '') === 'admin'); ?>
              <ul class="list-modern">
                <li><a href="<?= url('dashboard') ?>">Dashboard User</a></li>
                <li><a href="<?= $isAdmin ? url('admin') : url('login') ?>">Admin Panel</a></li>
              </ul>

              <h5 class="text-mustard mt-4 mb-3"><i class="bi bi-gear-fill me-2"></i>Admin</h5>
              <ul class="list-modern">
                <li><a href="<?= $isAdmin ? url('admin/users') : url('login') ?>">Kelola Users</a></li>
                <li><a href="<?= $isAdmin ? url('admin/semesters') : url('login') ?>">Kelola Semester</a></li>
                <li><a href="<?= $isAdmin ? url('admin/classes') : url('login') ?>">Kelola Mata Kuliah</a></li>
                <li><a href="<?= $isAdmin ? url('admin/gallery') : url('login') ?>">Kelola Galeri</a></li>
              </ul>

              <h5 class="text-mustard mt-4 mb-3"><i class="bi bi-file-earmark-text-fill me-2"></i>Legal</h5>
              <ul class="list-modern">
                <li><a href="<?= url('privacy') ?>">Privacy Policy</a></li>
                <li><a href="<?= url('terms') ?>">Terms of Service</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
:root{ --mustard:#D4AF37; --mustard-dark:#B8941F; --mustard-light:#F5E6C3; }
.text-mustard{ color:var(--mustard)!important; }
.section-icon-wrapper{ position:relative;width:fit-content; }
.section-icon{ width:70px;height:70px;display:flex;align-items:center;justify-content:center;border-radius:20px;color:#fff;background:linear-gradient(135deg,var(--mustard),var(--mustard-dark));box-shadow:0 12px 30px rgba(212,175,55,.35);font-size:1.6rem;z-index:1 }
.icon-glow{ position:absolute;inset:-8px;border-radius:24px;background:linear-gradient(135deg,var(--mustard-light),transparent);opacity:.5;z-index:0;animation:pulse 3s ease-in-out infinite }
.section-divider{ width:80px;height:4px;border-radius:2px;background:linear-gradient(90deg,transparent,var(--mustard),transparent) }
@keyframes pulse{0%,100%{opacity:.5;transform:scale(1)}50%{opacity:.8;transform:scale(1.05)}}
.list-modern{ list-style:none;margin:0;padding:0 }
.list-modern li{ padding:.5rem 0; display:flex; align-items:center; gap:.5rem; border-bottom:1px dashed #eee }
.list-modern li:last-child{ border-bottom:0 }
.list-modern a{ text-decoration:none; color:#374151 }
.list-modern a:hover{ color:var(--mustard) }
@media(max-width:768px){ .section-icon{ width:60px;height:60px } }
</style>
