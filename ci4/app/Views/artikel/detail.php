<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* Article Detail Page Styles */
.article-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 3rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.article-meta {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.article-content {
  background: white;
  border-radius: 15px;
  padding: 2.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.article-image {
  width: 100%;
  max-height: 400px;
  object-fit: cover;
  border-radius: 15px;
  margin-bottom: 2rem;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.article-title {
  font-size: 2.5rem;
  font-weight: 800;
  color: #2d3748;
  line-height: 1.3;
  margin-bottom: 1.5rem;
}

.article-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #4a5568;
  text-align: justify;
}

.article-text h3 {
  color: #2d3748;
  font-weight: 700;
  margin: 2rem 0 1rem 0;
  font-size: 1.5rem;
}

.article-text p {
  margin-bottom: 1.5rem;
}

.article-text ul, .article-text ol {
  margin-bottom: 1.5rem;
  padding-left: 2rem;
}

.article-text li {
  margin-bottom: 0.5rem;
}

.back-button {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.back-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
  color: white;
  text-decoration: none;
}

.category-badge-detail {
  background: linear-gradient(135deg, #56ab2f, #a8e6cf);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 600;
  display: inline-block;
  margin-bottom: 1rem;
}

.article-actions {
  background: #f7fafc;
  border-radius: 15px;
  padding: 1.5rem;
  text-align: center;
  margin-top: 2rem;
}

@media (max-width: 768px) {
  .article-title {
    font-size: 2rem;
  }

  .article-content {
    padding: 1.5rem;
  }

  .article-text {
    font-size: 1rem;
  }
}
</style>

<div class="container">
  <!-- Article Hero -->
  <div class="article-hero">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
              <li class="breadcrumb-item">
                <a href="<?= base_url('/') ?>" class="text-white-50">
                  <i class="fas fa-home me-1"></i>
                  Home
                </a>
              </li>
              <li class="breadcrumb-item">
                <a href="<?= base_url('/artikel') ?>" class="text-white-50">
                  <i class="fas fa-newspaper me-1"></i>
                  Artikel
                </a>
              </li>
              <li class="breadcrumb-item active text-white" aria-current="page">
                <?= esc($artikel['judul']) ?>
              </li>
            </ol>
          </nav>

          <h1 class="display-5 fw-bold mb-0">
            <i class="fas fa-newspaper me-3"></i>
            Detail Artikel
          </h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Article Meta -->
  <div class="article-meta">
    <div class="row align-items-center">
      <div class="col-md-8">
        <div class="category-badge-detail">
          <i class="fas fa-tag me-1"></i>
          Artikel
        </div>
        <h2 class="article-title mb-0">
          <?= esc($artikel['judul']) ?>
        </h2>
      </div>
      <div class="col-md-4 text-end">
        <a href="<?= base_url('/artikel') ?>" class="back-button">
          <i class="fas fa-arrow-left"></i>
          Kembali ke Artikel
        </a>
      </div>
    </div>
  </div>

  <!-- Article Content -->
  <div class="article-content">
    <!-- Article Image -->
    <?php if (!empty($artikel['gambar'])): ?>
    <div class="text-center mb-4">
      <img src="<?= base_url('assets/gambar/' . $artikel['gambar']) ?>"
           alt="<?= esc($artikel['judul']) ?>"
           class="article-image">
    </div>
    <?php endif; ?>

    <!-- Article Text -->
    <div class="article-text">
      <?php
      // Load text helper
      helper('text');

      $content = $artikel['isi'] ?? 'Konten tidak tersedia.';
      echo format_text_content($content);
      ?>
    </div>

    <!-- Article Actions -->
    <div class="article-actions">
      <h5 class="mb-3">Bagikan Artikel Ini</h5>
      <div class="d-flex gap-2 justify-content-center">
        <a href="#" class="btn btn-outline-primary btn-sm" onclick="shareToFacebook()">
          <i class="fab fa-facebook me-1"></i>
          Facebook
        </a>
        <a href="#" class="btn btn-outline-info btn-sm" onclick="shareToTwitter()">
          <i class="fab fa-twitter me-1"></i>
          Twitter
        </a>
        <a href="#" class="btn btn-outline-success btn-sm" onclick="shareToWhatsApp()">
          <i class="fab fa-whatsapp me-1"></i>
          WhatsApp
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="copyLink()">
          <i class="fas fa-link me-1"></i>
          Copy Link
        </a>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <div class="row g-3">
    <div class="col-md-6">
      <a href="<?= base_url('/artikel') ?>" class="btn btn-outline-primary btn-lg w-100">
        <i class="fas fa-list me-2"></i>
        Lihat Semua Artikel
      </a>
    </div>
    <div class="col-md-6">
      <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg w-100">
        <i class="fas fa-home me-2"></i>
        Kembali ke Home
      </a>
    </div>
  </div>
</div>

<script>
function shareToFacebook() {
  const url = encodeURIComponent(window.location.href);
  const title = encodeURIComponent('<?= esc($artikel['judul']) ?>');
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareToTwitter() {
  const url = encodeURIComponent(window.location.href);
  const title = encodeURIComponent('<?= esc($artikel['judul']) ?>');
  window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank', 'width=600,height=400');
}

function shareToWhatsApp() {
  const url = encodeURIComponent(window.location.href);
  const title = encodeURIComponent('<?= esc($artikel['judul']) ?>');
  window.open(`https://wa.me/?text=${title} ${url}`, '_blank');
}

function copyLink() {
  navigator.clipboard.writeText(window.location.href).then(function() {
    alert('Link berhasil disalin!');
  });
}
</script>

<?= $this->endSection() ?>
