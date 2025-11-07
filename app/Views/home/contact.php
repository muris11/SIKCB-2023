<?php $title = 'Kontak SIKC B 2023'; ?>

<div class="contact-sikc-section py-5 bg-light">
  <div class="container py-4">
    
    <!-- Header Section -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="section-header text-center mb-5">
              <div class="section-icon-wrapper mx-auto mb-3">
                <div class="section-icon">
                  <i class="bi bi-envelope-fill"></i>
                </div>
                <div class="icon-glow"></div>
              </div>
              <h2 class="display-6 fw-bold mb-3">
                Hubungi <span class="gradient-text">SIKC B 2023</span>
              </h2>
              <div class="section-divider mx-auto"></div>
              <p class="text-secondary lead mt-3">Kami siap membantu Anda dengan pertanyaan dan kebutuhan akademik</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-11">
        <div class="row g-4">
          <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="contact-card-modern text-center h-100">
              <div class="contact-icon-wrapper">
                <div class="contact-icon-modern">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
              </div>
              <h5 class="fw-bold text-mustard mb-3">Alamat Kampus</h5>
              <p class="text-secondary small mb-0">
                Politeknik Negeri Indramayu<br>
                Jl. Lohbener Lama No.08<br>
                Indramayu, Jawa Barat 45252
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
            <div class="contact-card-modern text-center h-100">
              <div class="contact-icon-wrapper">
                <div class="contact-icon-modern">
                  <i class="bi bi-telephone-fill"></i>
                </div>
              </div>
              <h5 class="fw-bold text-mustard mb-3">Telepon</h5>
              <p class="text-secondary small mb-0">
                <a href="tel:+6281314226401" class="text-decoration-none text-secondary">+62 813 1422 6401</a><br>
                <a href="tel:+6285773818846" class="text-decoration-none text-secondary">+62 857 7381 8846</a>
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
            <div class="contact-card-modern text-center h-100">
              <div class="contact-icon-wrapper">
                <div class="contact-icon-modern">
                  <i class="bi bi-envelope-at-fill"></i>
                </div>
              </div>
              <h5 class="fw-bold text-mustard mb-3">Email</h5>
              <p class="text-secondary small mb-0">
                <a href="mailto:memories.ofsikc23@gmail.com" class="text-decoration-none text-secondary">memories.ofsikc23@gmail.com</a><br>
                <a href="mailto:rifqysaputra1102@gmail.com" class="text-decoration-none text-secondary">rifqysaputra1102@gmail.com</a>
              </p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
            <div class="contact-card-modern text-center h-100">
              <div class="contact-icon-wrapper">
                <div class="contact-icon-modern">
                  <i class="bi bi-clock-fill"></i>
                </div>
              </div>
              <h5 class="fw-bold text-mustard mb-3">Jam Operasional</h5>
              <p class="text-secondary small mb-0">
                Senin - Jumat: 08:00 - 16:00<br>
                Sabtu dan Minggu: Tutup
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form & Map -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4">
            <div class="row g-5">
              <div class="col-lg-6">
                <h3 class="fw-bold mb-4 text-mustard display-6">Kirim Pesan</h3>
                <form id="contactForm" class="contact-form-modern">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-modern" id="name" placeholder="Nama Lengkap" required>
                    <label for="name"><i class="bi bi-person-fill me-2"></i>Nama Lengkap</label>
                  </div>
                  
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control form-control-modern" id="email" placeholder="Email" required>
                    <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                  </div>
                  
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-modern" id="subject" placeholder="Subjek" required>
                    <label for="subject"><i class="bi bi-chat-text-fill me-2"></i>Subjek</label>
                  </div>
                  
                  <div class="form-floating mb-4">
                    <textarea class="form-control form-control-modern" id="message" placeholder="Pesan Anda" style="height: 120px" required></textarea>
                    <label for="message"><i class="bi bi-pencil-fill me-2"></i>Pesan Anda</label>
                  </div>
                  
                  <button type="submit" class="btn btn-mustard-modern btn-lg w-100">
                    <i class="bi bi-send-fill me-2"></i>Kirim Pesan
                  </button>
                </form>
                <script>
                  document.getElementById('contactForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const subject = document.getElementById('subject').value;
                    const message = document.getElementById('message').value;
                    const waNumber = '6285773818846';
                    const waText = `Halo, saya ingin menghubungi SIKC B 2023.\n\nNama: ${name}\nEmail: ${email}\nSubjek: ${subject}\nPesan: ${message}`;
                    const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waText)}`;
                    window.open(waUrl, '_blank');
                  });
                </script>
                <div id="alertContainer" class="mt-4"></div>
              </div>

              <div class="col-lg-6">
                <h3 class="fw-bold mb-4 text-mustard display-6">Lokasi Kampus</h3>
                <div class="map-container-modern mb-4" id="mapContainer">
                  <!-- Google Maps Embed -->
                  <div id="googleMapContainer" class="ratio ratio-16x9" style="border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(212,175,55,0.2);">
                    <iframe 
                      src="https://maps.google.com/maps?q=-6.408350660802865,108.27813507620495&z=16&hl=id&output=embed" 
                      width="100%" 
                      height="100%" 
                      style="border:0; border-radius: 20px;" 
                      allowfullscreen 
                      loading="lazy" 
                      referrerpolicy="no-referrer-when-downgrade"
                      title="Lokasi Politeknik Negeri Indramayu"
                      aria-label="Peta lokasi Politeknik Negeri Indramayu">
                    </iframe>
                    <noscript>
                      <a href="https://maps.google.com/?q=Politeknik%20Negeri%20Indramayu" target="_blank" rel="noopener">Lihat lokasi di Google Maps</a>
                    </noscript>
                  </div>
                  
                  <!-- Fallback: If Maps blocked, show interactive card -->
                  <div id="mapFallback" class="d-none" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(184,148,31,0.1) 100%); padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(212,175,55,0.2);">
                    <i class="bi bi-geo-alt-fill text-mustard" style="font-size: 3rem; display: block; margin-bottom: 15px;"></i>
                    <h5 class="fw-bold text-dark mb-2">Politeknik Negeri Indramayu</h5>
                    <p class="text-secondary mb-3">Jl. Lohbener Lama No.08<br>Indramayu, Jawa Barat 45252</p>
                    <button class="btn btn-mustard" onclick="openGoogleMaps()" style="padding: 10px 25px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                      <i class="bi bi-map me-2"></i>Buka di Google Maps
                    </button>
                  </div>
                </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Social Media & Quick Links -->
    <div class="row justify-content-center">
      <div class="col-lg-11">
        <div class="card border-0 shadow-lg rounded-5 bg-gradient-mustard" data-aos="fade-up">
          <div class="card-body p-lg-5 p-4 text-center">
            <h3 class="fw-bold mb-4 text-mustard display-6">Terhubung Dengan Kami</h3>
            
            <div class="social-media-modern mb-4">
              <!-- <a href="#" class="social-btn-modern facebook" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-facebook"></i>
                <span>Facebook</span>
              </a> -->
              <a href="https://www.instagram.com/sikc3b_polindra/" class="social-btn-modern instagram" data-aos="zoom-in" data-aos-delay="200">
                <i class="bi bi-instagram"></i>
                <span>Instagram</span>
              </a>
              <a href="https://www.youtube.com" class="social-btn-modern youtube" data-aos="zoom-in" data-aos-delay="300">
                <i class="bi bi-youtube"></i>
                <span>YouTube</span>
              </a>
              <!-- <a href="#" class="social-btn-modern whatsapp" data-aos="zoom-in" data-aos-delay="400">
                <i class="bi bi-whatsapp"></i>
                <span>WhatsApp</span>
              </a> -->
            </div>

            <div class="quick-links-modern">
              <a href="<?= url() ?>" class="btn btn-outline-mustard-modern me-3">
                <i class="bi bi-house-fill me-2"></i>Beranda
              </a>
              <a href="<?= url('about') ?>" class="btn btn-outline-mustard-modern">
                <i class="bi bi-info-circle-fill me-2"></i>Tentang SIKC
              </a>
            </div>
          </div>
        </div>
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

/* Section Styling */
.contact-sikc-section {
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

/* Contact Card Modern */
.contact-card-modern {
  padding: 2.5rem 2rem;
  background: white;
  border-radius: 25px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
}

.contact-card-modern:hover {
  transform: translateY(-12px) rotate(-1deg);
  box-shadow: 0 20px 50px rgba(212, 175, 55, 0.25);
  border-color: var(--mustard-light);
}

.contact-icon-wrapper {
  position: relative;
  margin-bottom: 2rem;
}

.contact-icon-modern {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--mustard-light) 0%, #fff 100%);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.2rem;
  color: var(--mustard);
  margin: 0 auto;
  transition: all 0.4s ease;
  border: 3px solid var(--mustard-light);
}

.contact-card-modern:hover .contact-icon-modern {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  color: white;
  transform: scale(1.15) rotate(8deg);
  border-color: var(--mustard);
}

/* Form Modern */
.contact-form-modern {
  margin-top: 1rem;
}

.form-control-modern {
  border-radius: 15px;
  border: 2px solid var(--mustard-light);
  padding: 1rem 1.2rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #fafafa;
}

.form-control-modern:focus {
  border-color: var(--mustard);
  box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
  background: white;
}

.form-floating > label {
  color: var(--mustard);
  font-weight: 500;
}

.btn-mustard-modern {
  background: linear-gradient(135deg, var(--mustard) 0%, var(--mustard-dark) 100%);
  border: none;
  color: white;
  border-radius: 15px;
  font-weight: 600;
  padding: 1rem 2rem;
  transition: all 0.3s ease;
  box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

.btn-mustard-modern:hover {
  background: linear-gradient(135deg, var(--mustard-dark) 0%, var(--mustard) 100%);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(212, 175, 55, 0.5);
}

/* Map Container Interactive */
.map-container-modern {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.map-interactive-card {
  cursor: pointer;
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  border: 2px solid var(--mustard-light);
  min-height: 300px;
}

.map-interactive-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
}

.map-preview-bg {
  min-height: 300px;
  position: relative;
  background-size: cover !important;
  background-position: center !important;
}

.map-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(1px);
  display: flex;
  align-items: center;
  justify-content: center;
}

.map-icon-wrapper {
  position: relative;
  display: inline-block;
}

.map-pulse {
  position: absolute;
  inset: -20px;
  border: 3px solid var(--mustard);
  border-radius: 50%;
  opacity: 0.3;
  animation: mapPulse 2s ease-in-out infinite;
}

@keyframes mapPulse {
  0% { transform: scale(0.8); opacity: 0.7; }
  50% { transform: scale(1.2); opacity: 0.3; }
  100% { transform: scale(0.8); opacity: 0.7; }
}

/* Facility Info */
.facility-info-modern {
  padding: 1.5rem;
  background: var(--mustard-light);
  border-radius: 20px;
  border: 2px solid var(--mustard-light);
}

.facility-list-modern {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}

.facility-item-modern {
  display: flex;
  align-items: center;
  padding: 0.8rem;
  background: white;
  border-radius: 12px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.facility-item-modern:hover {
  transform: translateX(8px);
  box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
}

.facility-item-modern i {
  font-size: 1.2rem;
  width: 20px;
}

.facility-item-modern span {
  font-weight: 500;
  color: #333;
}

/* Social Media Modern */
.social-media-modern {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.social-btn-modern {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1.5rem 1rem;
  background: white;
  border-radius: 20px;
  text-decoration: none;
  color: #333;
  font-weight: 600;
  transition: all 0.4s ease;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  min-width: 120px;
}

.social-btn-modern:hover {
  transform: translateY(-8px) scale(1.05);
  color: white;
}

.social-btn-modern.facebook:hover {
  background: linear-gradient(135deg, #1877f2, #4267B2);
  box-shadow: 0 8px 25px rgba(24, 119, 242, 0.4);
}

.social-btn-modern.instagram:hover {
  background: linear-gradient(135deg, #E4405F, #C13584);
  box-shadow: 0 8px 25px rgba(228, 64, 95, 0.4);
}

.social-btn-modern.youtube:hover {
  background: linear-gradient(135deg, #FF0000, #CC0000);
  box-shadow: 0 8px 25px rgba(255, 0, 0, 0.4);
}

.social-btn-modern.whatsapp:hover {
  background: linear-gradient(135deg, #25D366, #128C7E);
  box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
}

.social-btn-modern i {
  font-size: 2rem;
}

.social-btn-modern span {
  font-size: 0.9rem;
}

/* Quick Links Modern */
.quick-links-modern {
  margin-top: 2rem;
}

.btn-outline-mustard-modern {
  color: var(--mustard);
  border: 2px solid var(--mustard);
  border-radius: 15px;
  font-weight: 600;
  padding: 0.8rem 1.5rem;
  transition: all 0.3s ease;
}

.btn-outline-mustard-modern:hover {
  background: var(--mustard);
  border-color: var(--mustard);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
}

/* Content Text */
.content-text {
  font-size: 1.05rem;
  line-height: 1.9;
}

/* Animations */
[data-aos] {
  opacity: 0;
  transition-property: transform, opacity;
}

[data-aos].aos-animate {
  opacity: 1;
}

[data-aos="fade-up"] {
  transform: translateY(30px);
}

[data-aos="fade-up"].aos-animate {
  transform: translateY(0);
}

[data-aos="zoom-in"] {
  transform: scale(0.6);
}

[data-aos="zoom-in"].aos-animate {
  transform: scale(1);
}

/* Responsive Design */
@media (max-width: 992px) {
  .section-icon {
    width: 70px;
    height: 70px;
    font-size: 2.2rem;
  }
  
  .contact-card-modern {
    padding: 2rem 1.5rem;
    margin-bottom: 1.5rem;
  }
  
  .contact-icon-modern {
    width: 70px;
    height: 70px;
    font-size: 2rem;
  }
  
  .social-media-modern {
    gap: 0.8rem;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .social-btn-modern {
    min-width: 100px;
    padding: 1.2rem 0.8rem;
    flex: 0 0 auto;
  }
  
  .social-btn-modern i {
    font-size: 1.8rem;
  }

  .display-6 {
    font-size: 2rem;
  }

  .quick-links-modern {
    text-align: center;
  }

  .quick-links-modern .btn {
    display: inline-block;
    margin: 0.25rem;
  }
}

@media (max-width: 768px) {
  .contact-sikc-section {
    padding: 2rem 0;
  }
  
  .card-body {
    padding: 1.5rem !important;
  }
  
  .contact-card-modern {
    padding: 1.5rem 1rem;
    margin-bottom: 1rem;
  }
  
  .contact-icon-modern {
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
  }
  
  .social-media-modern {
    gap: 0.5rem;
    justify-content: center;
  }
  
  .social-btn-modern {
    min-width: 90px;
    padding: 1rem 0.6rem;
    flex: 0 0 calc(50% - 0.25rem);
    max-width: 140px;
  }
  
  .social-btn-modern i {
    font-size: 1.6rem;
  }
  
  .facility-item-modern {
    padding: 0.6rem;
  }

  .display-6 {
    font-size: 1.75rem;
  }

  .section-header h2 {
    font-size: 1.75rem;
  }

  .form-control-modern {
    font-size: 0.95rem;
  }

  .btn-mustard-modern {
    padding: 0.875rem 1.5rem;
    font-size: 0.95rem;
  }

  .map-container-modern iframe {
    height: 250px;
  }

  .quick-links-modern .btn {
    display: block;
    width: 100%;
    margin-bottom: 0.5rem;
  }

  .quick-links-modern .btn:last-child {
    margin-bottom: 0;
  }
}

@media (max-width: 576px) {
  .contact-sikc-section {
    padding: 1.5rem 0;
  }

  .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .section-icon {
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
  }
  
  .contact-card-modern {
    padding: 1.2rem 0.8rem;
    margin-bottom: 1rem;
  }
  
  .contact-icon-modern {
    width: 50px;
    height: 50px;
    font-size: 1.5rem;
  }
  
  .social-media-modern {
    gap: 0.5rem;
    justify-content: center;
  }
  
  .social-btn-modern {
    min-width: 80px;
    padding: 0.8rem 0.5rem;
    flex: 0 0 calc(50% - 0.25rem);
    max-width: 120px;
  }
  
  .social-btn-modern i {
    font-size: 1.4rem;
  }
  
  .social-btn-modern span {
    font-size: 0.8rem;
  }
  
  .facility-info-modern {
    padding: 1rem;
  }
  
  .facility-item-modern {
    padding: 0.5rem;
    gap: 0.6rem;
  }

  .display-6 {
    font-size: 1.5rem;
  }

  .section-header h2 {
    font-size: 1.5rem;
  }

  .lead {
    font-size: 1rem;
  }

  .card-body {
    padding: 1rem !important;
  }

  .form-control-modern {
    font-size: 0.9rem;
    padding: 0.875rem 1rem;
  }

  .btn-mustard-modern {
    padding: 0.75rem 1.25rem;
    font-size: 0.9rem;
  }

  .map-container-modern iframe {
    height: 220px;
  }

  .quick-links-modern .btn {
    display: block;
    width: 100%;
    margin-bottom: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
  }

  .contact-card-modern h5 {
    font-size: 1.1rem;
    margin-bottom: 1rem;
  }

  .contact-card-modern p {
    font-size: 0.85rem;
  }

  .row.g-4 {
    --bs-gutter-x: 1rem;
    --bs-gutter-y: 1rem;
  }

  .row.g-5 {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 1.5rem;
  }
}

/* Extra Small Devices */
@media (max-width: 400px) {
  .social-btn-modern {
    min-width: 70px;
    padding: 0.6rem 0.3rem;
    flex: 0 0 calc(50% - 0.25rem);
  }

  .social-btn-modern span {
    font-size: 0.75rem;
  }

  .social-btn-modern i {
    font-size: 1.2rem;
  }

  .display-6 {
    font-size: 1.3rem;
  }

  .section-header h2 {
    font-size: 1.3rem;
  }

  .contact-card-modern {
    padding: 1rem 0.6rem;
  }

  .contact-card-modern h5 {
    font-size: 1rem;
  }

  .contact-card-modern p {
    font-size: 0.8rem;
  }

  .form-control-modern {
    font-size: 0.85rem;
    padding: 0.75rem 0.875rem;
  }

  .btn-mustard-modern {
    padding: 0.675rem 1rem;
    font-size: 0.85rem;
  }
}

/* Print Styles */
@media print {
  .contact-sikc-section {
    background: white !important;
  }
  
  .card {
    box-shadow: none !important;
    border: 1px solid #ddd !important;
  }
  
  .gradient-text {
    -webkit-text-fill-color: var(--mustard) !important;
  }
  
  .bg-gradient-mustard {
    background: var(--mustard-light) !important;
  }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
  
  .icon-glow {
    animation: none !important;
  }
}
</style>

<!-- AOS (Animate On Scroll) Library with Local Fallback -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" onerror="this.onerror=null;this.href='<?= asset('aos-fallback.css') ?>';">
<link href="<?= asset('aos-fallback.css') ?>" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

<script>
  // Initialize AOS with fallback
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
      // AOS loaded successfully
      window.addEventListener('load', function(){
        AOS.init({
          duration: 700,
          easing: 'ease-out-cubic',
          once: true,
          mirror: false,
          offset: 60
        });
      });
    } else {
      // AOS failed to load - ensure content is visible
      console.warn('AOS library failed to load - content displayed without animations');
    }
  });

  // Contact Form Handler
  document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
    submitBtn.disabled = true;
    
    // Simulate form submission
    setTimeout(() => {
      const alertContainer = document.getElementById('alertContainer');
      alertContainer.innerHTML = `
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
          <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>
              <strong>Pesan Terkirim!</strong><br>
              <small>Kami akan segera merespons pesan Anda. Terima kasih!</small>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      `;
      
      // Reset form and button
      this.reset();
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
      
      // Smooth scroll to alert
      alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 1500);
  });

  // Smooth scrolling for internal links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Enhanced form validation
  document.querySelectorAll('.form-control-modern').forEach(input => {
    input.addEventListener('blur', function() {
      if (this.checkValidity()) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
      } else {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
      }
    });
  });

  // Google Maps handler
  function openGoogleMaps() {
    const address = "Politeknik Negeri Indramayu, Jl. Lohbener Lama No.08, Indramayu, Jawa Barat 45252";
    const encodedAddress = encodeURIComponent(address);
    const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
    
    // Try to open in Google Maps app first, fallback to web
    const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
      // Try Google Maps app URL
      const appUrl = `https://maps.google.com/?q=${encodedAddress}`;
      window.open(appUrl, '_blank');
    } else {
      window.open(googleMapsUrl, '_blank');
    }
  }

  // Show map fallback when image fails
  function showMapFallback() {
    const googleMapContainer = document.getElementById('googleMapContainer');
    const fallback = document.getElementById('mapFallback');
    
    if (googleMapContainer) googleMapContainer.style.display = 'none';
    if (fallback) fallback.classList.remove('d-none');
  }

  // Enhanced Google Maps fallback system
  function setupMapsFallback() {
    // Check if Google Maps iframe is accessible
    const googleMapContainer = document.getElementById('googleMapContainer');
    const mapFallback = document.getElementById('mapFallback');
    
    if (!googleMapContainer) return;
    
    // Setup iframe load detection
    const iframe = googleMapContainer.querySelector('iframe');
    
    if (iframe) {
      // Check if iframe loads successfully
      let iframeLoadTimeout = setTimeout(() => {
        // If maps doesn't load in 5 seconds, show fallback
        console.warn('⚠️ Google Maps iframe may be blocked');
        showMapFallback();
      }, 5000);
      
      iframe.addEventListener('load', () => {
        clearTimeout(iframeLoadTimeout);
        console.log('✅ Google Maps loaded successfully');
      });
      
      iframe.addEventListener('error', () => {
        clearTimeout(iframeLoadTimeout);
        console.warn('⚠️ Google Maps iframe error - showing fallback');
        showMapFallback();
      });
    }
  }

  // Initialize maps and interactions
  document.addEventListener('DOMContentLoaded', function() {
    // Setup maps fallback detection
    setupMapsFallback();
    
    const mapCard = document.querySelector('.map-interactive-card');
    
    if (mapCard) {
      // Hover effects
      mapCard.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.02)';
        this.style.boxShadow = '0 10px 30px rgba(212,175,55,0.2)';
      });
      
      mapCard.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
        this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
      });
      
      // Click animation
      mapCard.addEventListener('click', function() {
        this.style.transform = 'scale(0.98)';
        setTimeout(() => {
          this.style.transform = 'scale(1.02)';
        }, 150);
      });
    }
    
    // Option to show OpenStreetMap as alternative
    const showOSMBtn = document.getElementById('showOSMMap');
    if (showOSMBtn) {
      showOSMBtn.addEventListener('click', function() {
        const osmMap = document.getElementById('osmMap');
        if (osmMap) {
          osmMap.classList.toggle('d-none');
          this.innerHTML = osmMap.classList.contains('d-none') ? 
            '<i class="bi bi-map me-2"></i>Tampilkan Peta Alternatif' : 
            '<i class="bi bi-eye-slash me-2"></i>Sembunyikan Peta Alternatif';
        }
      });
    }
  });
</script>
