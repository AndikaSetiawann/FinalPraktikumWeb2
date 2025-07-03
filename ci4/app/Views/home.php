<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5 mb-5 rounded">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold"><?= esc($title ?? 'Beranda'); ?></h1>
                <p class="lead"><?= esc($content ?? 'Selamat datang di halaman utama.'); ?></p>
                <a href="/artikel" class="btn btn-light btn-lg">Lihat Semua Artikel</a>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper fa-5x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<!-- Latest Articles Section -->
<?php if (!empty($artikel)): ?>
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 fw-bold text-center mb-4">
                <i class="fas fa-star text-warning me-2"></i>
                Artikel Terbaru
            </h2>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($artikel as $item): ?>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <!-- Article Image -->
                <?php if (!empty($item['gambar'])): ?>
                <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden;">
                    <img src="<?= base_url('assets/gambar/' . $item['gambar']) ?>"
                         class="card-img-top"
                         alt="<?= esc($item['judul']) ?>"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <!-- Category Badge -->
                    <?php if (!empty($item['nama_kategori'])): ?>
                    <span class="badge bg-secondary mb-2 align-self-start">
                        <?= esc($item['nama_kategori']) ?>
                    </span>
                    <?php endif; ?>

                    <!-- Article Title -->
                    <h5 class="card-title fw-bold">
                        <a href="/artikel/<?= esc($item['slug']) ?>" class="text-decoration-none text-dark">
                            <?= esc($item['judul']) ?>
                        </a>
                    </h5>

                    <!-- Article Preview -->
                    <p class="card-text text-muted flex-grow-1">
                        <?php
                        $preview = strip_tags($item['isi']);
                        echo esc(strlen($preview) > 120 ? substr($preview, 0, 120) . '...' : $preview);
                        ?>
                    </p>

                    <!-- Read More Button -->
                    <div class="mt-auto">
                        <a href="/artikel/<?= esc($item['slug']) ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- View All Articles Button -->
    <div class="text-center mt-5">
        <a href="/artikel" class="btn btn-primary btn-lg">
            <i class="fas fa-list me-2"></i>
            Lihat Semua Artikel
        </a>
    </div>
</div>
<?php else: ?>
<!-- No Articles Message -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Belum Ada Artikel</h4>
                <p class="mb-0">Artikel akan ditampilkan di sini setelah dipublikasikan.</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
<?= $this->endSection() ?>
