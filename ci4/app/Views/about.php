<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* About Page Styles */
.about-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.about-section {
  margin-bottom: 3rem;
}

.about-card {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  height: 100%;
  transition: all 0.3s ease;
}

.about-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.about-icon {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2rem;
  color: white;
}

.team-card {
  text-align: center;
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.team-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.team-avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
  font-size: 2.5rem;
  color: white;
}
</style>

<div class="container">
  <!-- About Hero -->
  <div class="about-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-info-circle me-3"></i>
            Tentang Kami
          </h1>
          <p class="lead mb-0">
            Kami adalah tim yang berdedikasi untuk menciptakan platform manajemen artikel yang modern,
            powerful, dan mudah digunakan dengan teknologi terdepan.
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <div class="floating-card">
            <i class="fas fa-users fa-3x text-primary mb-3"></i>
            <h5>Our Team</h5>
            <p class="mb-0">Passionate Developers</p>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Technology Stack -->
  <div class="about-section">
    <div class="row text-center mb-5">
      <div class="col-12">
        <h2 class="section-title">Teknologi yang Kami Gunakan</h2>
        <p class="section-subtitle">Stack teknologi modern untuk performa optimal</p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-3">
        <div class="about-card text-center">
          <div class="about-icon bg-success">
            <i class="fab fa-vuejs"></i>
          </div>
          <h5>Vue.js 3</h5>
          <p>Frontend framework modern untuk interface yang responsif dan interaktif.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="about-card text-center">
          <div class="about-icon bg-danger">
            <i class="fab fa-php"></i>
          </div>
          <h5>CodeIgniter 4</h5>
          <p>Backend framework PHP yang powerful dan secure untuk API yang robust.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="about-card text-center">
          <div class="about-icon bg-primary">
            <i class="fas fa-database"></i>
          </div>
          <h5>MySQL</h5>
          <p>Database management system yang reliable untuk penyimpanan data.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="about-card text-center">
          <div class="about-icon bg-info">
            <i class="fab fa-bootstrap"></i>
          </div>
          <h5>Bootstrap 5</h5>
          <p>CSS framework untuk design yang responsive dan modern.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <div class="about-section">
    <div class="row text-center mb-5">
      <div class="col-12">
        <h2 class="section-title">Tim Pengembang</h2>
        <p class="section-subtitle">Orang-orang hebat di balik platform ini</p>
      </div>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="team-card">
          <div class="team-avatar">
            <i class="fas fa-user"></i>
          </div>
          <h5>Developer Team</h5>
          <p class="text-muted">Full Stack Developer</p>
          <p>Mengembangkan dan memelihara platform dengan teknologi terdepan.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-card">
          <div class="team-avatar">
            <i class="fas fa-palette"></i>
          </div>
          <h5>Design Team</h5>
          <p class="text-muted">UI/UX Designer</p>
          <p>Menciptakan pengalaman pengguna yang intuitif dan menarik.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-card">
          <div class="team-avatar">
            <i class="fas fa-cogs"></i>
          </div>
          <h5>DevOps Team</h5>
          <p class="text-muted">System Administrator</p>
          <p>Memastikan platform berjalan dengan optimal dan secure.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact CTA -->
  <div class="about-section">
    <div class="row">
      <div class="col-12">
        <div class="about-card text-center">
          <h3 class="mb-3">Tertarik Bekerja Sama?</h3>
          <p class="mb-4">Kami selalu terbuka untuk kolaborasi dan partnership yang saling menguntungkan.</p>
          <div class="d-flex gap-3 justify-content-center">
            <a href="<?= base_url('/contact') ?>" class="btn btn-primary btn-lg">
              <i class="fas fa-envelope me-2"></i>
              Hubungi Kami
            </a>
            <a href="<?= base_url('/artikel') ?>" class="btn btn-outline-primary btn-lg">
              <i class="fas fa-newspaper me-2"></i>
              Lihat Artikel
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
