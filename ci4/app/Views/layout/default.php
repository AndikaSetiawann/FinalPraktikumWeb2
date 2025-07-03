<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Article Management System') ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <style>
    /* Modern Layout Styles */
    body {
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8fafc;
      line-height: 1.6;
    }

    .navbar-modern {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 1rem 0;
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.5rem;
    }

    .navbar-logo {
      height: 35px;
      width: auto;
      max-width: 150px;
      object-fit: contain;
    }

    .nav-link {
      font-weight: 500;
      transition: all 0.3s ease;
      border-radius: 8px;
      margin: 0 0.25rem;
      padding: 0.5rem 1rem !important;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
    }

    .nav-link.active {
      background: rgba(255, 255, 255, 0.3);
      font-weight: 600;
    }

    .main-content {
      min-height: calc(100vh - 200px);
      padding: 2rem 0;
    }

    .footer-modern {
      background: #2d3748;
      color: white;
      padding: 2rem 0;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  <!-- Modern Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-modern">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
        <img src="<?= base_url('assets/gambar/favicon.svg'); ?>" alt="Logo" class="navbar-logo me-2">
        Article CMS
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link <?= (current_url() == base_url('/')) ? 'active' : '' ?>" href="<?= base_url('/') ?>">
              <i class="fas fa-home me-1"></i>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (strpos(current_url(), 'artikel') !== false && strpos(current_url(), 'admin') === false) ? 'active' : '' ?>" href="<?= base_url('/artikel') ?>">
              <i class="fas fa-newspaper me-1"></i>
              Artikel
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (strpos(current_url(), 'about') !== false) ? 'active' : '' ?>" href="<?= base_url('/about') ?>">
              <i class="fas fa-info-circle me-1"></i>
              About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (strpos(current_url(), 'contact') !== false) ? 'active' : '' ?>" href="<?= base_url('/contact') ?>">
              <i class="fas fa-envelope me-1"></i>
              Contact
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-ellipsis-h me-1"></i>
              More
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= base_url('/faqs') ?>">
                <i class="fas fa-question-circle me-2"></i>FAQs
              </a></li>
              <li><a class="dropdown-item" href="<?= base_url('/tos') ?>">
                <i class="fas fa-file-contract me-2"></i>Terms of Service
              </a></li>
            </ul>
          </li>
        </ul>

        <ul class="navbar-nav">
          <?php if (session()->get('logged_in')): ?>
            <?php if (session()->get('role') === 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'admin') !== false) ? 'active' : '' ?>" href="<?= base_url('/admin/artikel') ?>">
                  <i class="fas fa-cogs me-1"></i>
                  Dashboard Admin
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://setiawanarticle.my.id/vue/" target="_blank">
                  <i class="fab fa-vuejs me-1"></i>
                  Vue.js Frontend
                </a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link <?= (strpos(current_url(), 'user/dashboard') !== false) ? 'active' : '' ?>" href="<?= base_url('/user/dashboard') ?>">
                  <i class="fas fa-tachometer-alt me-1"></i>
                  Dashboard
                </a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/auth/logout') ?>">
                <i class="fas fa-sign-out-alt me-1"></i>
                Logout
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?= (strpos(current_url(), 'login') !== false) ? 'active' : '' ?>" href="<?= base_url('/user/login') ?>">
                <i class="fas fa-sign-in-alt me-1"></i>
                Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Modern Footer -->
  <footer class="footer-modern">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <p class="mb-0">&copy; 2025 Universitas Pelita Bangsa</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
