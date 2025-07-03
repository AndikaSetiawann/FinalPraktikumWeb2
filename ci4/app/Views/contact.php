<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* Contact Page Styles */
.contact-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.contact-card {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  height: 100%;
  transition: all 0.3s ease;
}

.contact-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.contact-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 1.8rem;
  color: white;
}

.contact-form {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}

.form-group-contact {
  margin-bottom: 1.5rem;
}

.form-label-contact {
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 0.5rem;
  display: block;
}

.form-control-contact {
  width: 100%;
  padding: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #f7fafc;
}

.form-control-contact:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  background: white;
}

.btn-contact {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-contact:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
  color: white;
}

/* Social Media Links */
.social-contact-link {
  display: flex;
  align-items: center;
  padding: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  text-decoration: none;
  color: #2d3748;
  transition: all 0.3s ease;
  background: #f7fafc;
}

.social-contact-link:hover {
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.social-contact-link.instagram:hover {
  background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
  border-color: transparent;
}

.social-contact-link.twitter:hover {
  background: #000000;
  border-color: #000000;
}

.social-contact-link i {
  width: 40px;
  text-align: center;
}

.x-icon {
  width: 40px;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
}

.social-contact-link strong {
  font-size: 1rem;
  font-weight: 600;
}

.social-contact-link small {
  font-size: 0.85rem;
}
</style>

<div class="container">
  <!-- Contact Hero -->
  <div class="contact-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-envelope me-3"></i>
            Hubungi Kami
          </h1>
          <p class="lead mb-0">
            Punya pertanyaan, saran, atau ingin berkolaborasi? Kami siap membantu Anda.
            Jangan ragu untuk menghubungi tim kami kapan saja.
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <div class="floating-card">
            <i class="fas fa-headset fa-3x text-primary mb-3"></i>
            <h5>24/7 Support</h5>
            <p class="mb-0">Always Here to Help</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Methods -->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="contact-card text-center">
        <div class="contact-icon bg-primary">
          <i class="fas fa-envelope"></i>
        </div>
        <h5>Email</h5>
        <p class="text-muted mb-3">Kirim email untuk pertanyaan detail</p>
        <a href="mailto:asetiawanandika@gmail.com" class="btn btn-outline-primary">
          <i class="fas fa-paper-plane me-2"></i>
          asetiawanandika@gmail.com
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="contact-card text-center">
        <div class="contact-icon bg-success">
          <i class="fas fa-phone"></i>
        </div>
        <h5>Telepon</h5>
        <p class="text-muted mb-3">Hubungi kami langsung</p>
        <a href="tel:+6281388209195" class="btn btn-outline-success">
          <i class="fas fa-phone me-2"></i>
          +62 813-8820-9195
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="contact-card text-center">
        <div class="contact-icon bg-info">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <h5>Alamat</h5>
        <p class="text-muted mb-3">Kunjungi kantor kami</p>
        <address class="mb-0">
          Universitas Pelita Bangsa<br>
          Bekasi, Jawa Barat<br>
          Indonesia
        </address>
      </div>
    </div>
  </div>

  <!-- Contact Form & Map -->
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="contact-form">
        <h3 class="mb-4">
          <i class="fas fa-paper-plane me-2"></i>
          Kirim Pesan
        </h3>
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-group-contact">
                <label class="form-label-contact">
                  <i class="fas fa-user me-2"></i>
                  Nama Lengkap
                </label>
                <input type="text" class="form-control-contact" placeholder="Masukkan nama lengkap Anda" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group-contact">
                <label class="form-label-contact">
                  <i class="fas fa-envelope me-2"></i>
                  Email
                </label>
                <input type="email" class="form-control-contact" placeholder="Masukkan email Anda" required>
              </div>
            </div>
          </div>

          <div class="form-group-contact">
            <label class="form-label-contact">
              <i class="fas fa-tag me-2"></i>
              Subjek
            </label>
            <input type="text" class="form-control-contact" placeholder="Subjek pesan Anda" required>
          </div>

          <div class="form-group-contact">
            <label class="form-label-contact">
              <i class="fas fa-comment me-2"></i>
              Pesan
            </label>
            <textarea class="form-control-contact" rows="6" placeholder="Tulis pesan Anda di sini..." required></textarea>
          </div>

          <button type="submit" class="btn-contact">
            <i class="fas fa-paper-plane"></i>
            Kirim Pesan
          </button>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="contact-card">


        <h5 class="mb-3">
          <i class="fas fa-share-alt me-2"></i>
          Follow Me
        </h5>
        <div class="social-media-links">
          <a href="https://www.instagram.com/andkkwan_/" target="_blank" class="social-contact-link instagram mb-3">
            <i class="fab fa-instagram fa-lg me-2"></i>
            <div>
              <strong>Instagram</strong><br>
              <small class="text-muted">@andkkwan_</small>
            </div>
          </a>
          <a href="https://x.com/waanz_z" target="_blank" class="social-contact-link twitter">
            <div class="x-icon me-2">𝕏</div>
            <div>
              <strong>X (Twitter)</strong><br>
              <small class="text-muted">@waanz_z</small>
            </div>
          </a>
        </div>

        <hr>

        <div class="text-center">
          <h6>Respon Time</h6>
          <div class="d-flex justify-content-between">
            <span>Email:</span>
            <span class="text-success">< 24 jam</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Telepon:</span>
            <span class="text-success">Langsung</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FAQ Link -->
  <div class="row mt-5">
    <div class="col-12">
      <div class="contact-card text-center">
        <h4 class="mb-3">Pertanyaan Umum?</h4>
        <p class="mb-4">Mungkin jawaban yang Anda cari sudah tersedia di halaman FAQ kami.</p>
        <a href="<?= base_url('/faqs') ?>" class="btn btn-outline-primary btn-lg">
          <i class="fas fa-question-circle me-2"></i>
          Lihat FAQ
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
