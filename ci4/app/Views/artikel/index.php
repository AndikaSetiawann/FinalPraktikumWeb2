<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* Hero Section Styles */
.hero-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 0;
  position: relative;
  overflow: hidden;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
  opacity: 0.3;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-badge {
  display: inline-block;
  background: rgba(255, 255, 255, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  line-height: 1.2;
  margin-bottom: 1.5rem;
}

.text-gradient {
  background: linear-gradient(45deg, #ffd700, #ffed4e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-subtitle {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.hero-actions {
  margin-top: 2rem;
}



.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #2d3748;
  margin-bottom: 1rem;
}

.section-subtitle {
  font-size: 1.1rem;
  color: #718096;
  margin-bottom: 3rem;
}



@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
  }

  .hero-actions {
    text-align: center;
  }

  .hero-actions .btn {
    display: block;
    margin: 0.5rem auto;
    width: 100%;
    max-width: 300px;
  }
}
</style>
<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center min-vh-50">
      <div class="col-lg-6">
        <div class="hero-content">
          <div class="hero-badge">
            <i class="fas fa-rocket me-2"></i>
            Article Management System
          </div>
          <h1 class="hero-title">
            Kelola Artikel dengan
            <span class="text-gradient">Mudah & Modern</span>
          </h1>
          <p class="hero-subtitle">
            Temukan dan baca artikel-artikel menarik sesuai dengan minat dan kebutuhan Anda.
          </p>
          <div class="hero-actions">
            <a href="<?= base_url('/artikel') ?>" class="btn btn-primary btn-lg me-3">
              <i class="fas fa-newspaper me-2"></i>
              Lihat Artikel
            </a>
            <?php if (session()->get('logged_in')): ?>
              <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('/admin/artikel') ?>" class="btn btn-primary btn-lg me-3">
                  <i class="fas fa-cogs me-2"></i>
                  Dashboard Admin
                </a>
                <a href="https://setiawanarticle.my.id/vue/" target="_blank" class="btn btn-success btn-lg">
                  <i class="fab fa-vuejs me-2"></i>
                  Vue.js Frontend
                </a>
              <?php else: ?>
                <a href="<?= base_url('/user/dashboard') ?>" class="btn btn-primary btn-lg">
                  <i class="fas fa-tachometer-alt me-2"></i>
                  User Dashboard
                </a>
              <?php endif; ?>
            <?php else: ?>
              <a href="<?= base_url('/user/login') ?>" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>
                Login
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image">
          <!-- Hero image space - bisa diisi dengan gambar atau dibiarkan kosong -->
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Search Section -->
<div class="container mb-4">
  <div class="row">
    <div class="col-12">
      <div class="search-box bg-light p-3 rounded border">
        <h5 class="mb-3"><i class="fas fa-search me-2"></i>Cari Artikel</h5>
        <form method="GET" action="<?= base_url('artikel') ?>">
          <div class="row g-2">
            <div class="col-md-5">
              <input type="text"
                     name="search"
                     class="form-control"
                     placeholder="Masukkan kata kunci artikel..."
                     value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-4">
              <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                <?php if (!empty($kategori)): ?>
                  <?php foreach ($kategori as $kat): ?>
                    <option value="<?= esc($kat['id_kategori']) ?>"
                            <?= ($kategori_id == $kat['id_kategori']) ? 'selected' : '' ?>>
                      <?= esc($kat['nama_kategori']) ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Cari
              </button>
            </div>
            <div class="col-md-1">
              <a href="<?= base_url('artikel') ?>" class="btn btn-outline-secondary w-100" title="Reset">
                <i class="fas fa-refresh"></i>
              </a>
            </div>
          </div>
        </form>

        <!-- Search Results Info -->
        <?php if (!empty($search) || !empty($kategori_id)): ?>
          <div class="mt-3 p-2 bg-info bg-opacity-10 rounded">
            <small class="text-muted">
              <i class="fas fa-info-circle me-1"></i>
              Menampilkan hasil untuk:
              <?php if (!empty($search)): ?>
                "<strong><?= esc($search) ?></strong>"
              <?php endif; ?>
              <?php if (!empty($kategori_id)): ?>
                <?php if (!empty($search)): ?> dalam <?php endif; ?>
                kategori "<strong><?= esc($kategori[array_search($kategori_id, array_column($kategori, 'id_kategori'))]['nama_kategori'] ?? 'Unknown') ?></strong>"
              <?php endif; ?>
              - Ditemukan <strong><?= count($artikel) ?></strong> artikel
            </small>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Latest Articles Section -->
<div class="container">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="section-title">
        <?php if (!empty($search) || !empty($kategori_id)): ?>
          <i class="fas fa-search-plus me-2"></i>Hasil Pencarian
        <?php else: ?>
          <i class="fas fa-newspaper me-2"></i>Artikel Terbaru
        <?php endif; ?>
      </h2>
      <p class="section-subtitle">
        <?php if (!empty($search) || !empty($kategori_id)): ?>
          Ditemukan <?= count($artikel) ?> artikel yang sesuai dengan pencarian Anda
        <?php else: ?>
          Temukan artikel menarik dan informatif
        <?php endif; ?>
      </p>
    </div>
  </div>

    <!-- Articles Grid -->
    <?php if (!empty($artikel)): ?>
    <div class="row g-4">
        <?php foreach ($artikel as $row): ?>
        <div class="col-lg-6 col-md-6">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <!-- Article Image -->
                <?php if (!empty($row['gambar'])): ?>
                <div class="card-img-top-wrapper" style="height: 250px; overflow: hidden;">
                    <img src="<?= base_url('assets/gambar/' . $row['gambar']) ?>"
                         class="card-img-top"
                         alt="<?= esc($row['judul']) ?>"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                    <i class="fas fa-image fa-4x text-muted"></i>
                </div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <!-- Category Badge -->
                    <?php if (!empty($row['nama_kategori'])): ?>
                    <span class="badge bg-primary mb-3 align-self-start">
                        <i class="fas fa-tag me-1"></i>
                        <?= esc($row['nama_kategori']) ?>
                    </span>
                    <?php endif; ?>

                    <!-- Article Title -->
                    <h4 class="card-title fw-bold mb-3">
                        <a href="/artikel/<?= esc($row['slug']) ?>" class="text-decoration-none text-dark">
                            <?= esc($row['judul']) ?>
                        </a>
                    </h4>

                    <!-- Article Preview -->
                    <div class="card-text text-muted flex-grow-1 mb-3">
                        <?php
                        helper('text');
                        $preview = strip_tags($row['isi']);
                        $formatted_preview = strlen($preview) > 200 ? substr($preview, 0, 200) . '...' : $preview;
                        ?>
                        <div style="line-height: 1.6;">
                            <?= nl2br(esc($formatted_preview)) ?>
                        </div>
                    </div>

                    <!-- Read More Button -->
                    <div class="mt-auto">
                        <a href="/artikel/<?= esc($row['slug']) ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-2"></i>
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Back to Home Button -->
    <div class="text-center mt-5">
        <a href="/" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-home me-2"></i>
            Kembali ke Beranda
        </a>
    </div>

    <?php else: ?>
    <!-- No Articles Message -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning text-center py-5">
                <?php if (!empty($search) || !empty($kategori_id)): ?>
                    <i class="fas fa-search fa-4x mb-4 text-warning"></i>
                    <h3>Tidak Ada Hasil Ditemukan</h3>
                    <p class="lead">Maaf, tidak ditemukan artikel yang sesuai dengan pencarian Anda.</p>
                    <div class="mt-3">
                        <a href="<?= base_url('artikel') ?>" class="btn btn-primary me-2">
                            <i class="fas fa-list me-2"></i>
                            Lihat Semua Artikel
                        </a>
                        <a href="/" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            💡 Tips: Coba gunakan kata kunci yang berbeda atau pilih kategori lain
                        </small>
                    </div>
                <?php else: ?>
                    <i class="fas fa-info-circle fa-4x mb-4 text-primary"></i>
                    <h3>Belum Ada Artikel</h3>
                    <p class="lead">Artikel akan ditampilkan di sini setelah dipublikasikan.</p>
                    <a href="/" class="btn btn-primary mt-3">
                        <i class="fas fa-home me-2"></i>
                        Kembali ke Beranda
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.search-box {
    border: 1px solid #dee2e6;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.search-box h5 {
    color: #495057;
    font-weight: 600;
}

.search-box .form-control:focus,
.search-box .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.section-title {
    color: #495057;
}

.section-subtitle {
    color: #6c757d;
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0b5ed7 0%, #0a58ca 100%);
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .search-box .row > div {
        margin-bottom: 0.5rem;
    }
}
</style>
<?= $this->endSection() ?>