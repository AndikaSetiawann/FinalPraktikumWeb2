<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Article CMS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f8fafc;
            --accent-color: #06b6d4;
            --text-dark: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            padding: 2rem 0;
        }

        .dashboard-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid var(--primary-color);
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .stat-card {
            text-align: center;
            padding: 2rem 1rem;
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 1rem;
        }

        .article-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .article-card:hover {
            border-left-color: var(--accent-color);
        }

        .article-meta {
            color: #64748b;
            font-size: 0.9rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <i class="fas fa-newspaper me-2 text-primary"></i>
                Article CMS
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <?php if (session()->get('avatar')): ?>
                            <img src="<?= session()->get('avatar') ?>" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                        <?php else: ?>
                            <i class="fas fa-user-circle me-2"></i>
                        <?php endif; ?>
                        <?= session()->get('name') ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('/') ?>"><i class="fas fa-home me-2"></i>Home</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('artikel') ?>"><i class="fas fa-newspaper me-2"></i>Articles</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container" style="margin-top: 80px;">
        <div class="container">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-custom">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="user-info">
                    <?php if (session()->get('avatar')): ?>
                        <img src="<?= session()->get('avatar') ?>" alt="Avatar" class="user-avatar">
                    <?php else: ?>
                        <div class="user-avatar bg-primary d-flex align-items-center justify-content-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h2 class="mb-1">Welcome, <?= session()->get('name') ?>!</h2>
                        <p class="text-muted mb-0">
                            <i class="fas fa-envelope me-2"></i><?= session()->get('email') ?>
                            <span class="badge bg-info ms-2">User</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="dashboard-card stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-number"><?= $totalArticles ?? 0 ?></div>
                        <div class="stat-label">Total Articles</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-number"><?= $totalCategories ?? 0 ?></div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number"><?= $recentArticles ?? 0 ?></div>
                        <div class="stat-label">Recent Articles</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h5 class="mb-3"><i class="fas fa-newspaper me-2"></i>Browse Articles</h5>
                        <p class="text-muted mb-3">Explore all published articles and content.</p>
                        <a href="<?= base_url('artikel') ?>" class="btn btn-primary-custom">
                            <i class="fas fa-eye me-2"></i>View Articles
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h5 class="mb-3"><i class="fas fa-home me-2"></i>Back to Home</h5>
                        <p class="text-muted mb-3">Return to the main website homepage.</p>
                        <a href="<?= base_url('/') ?>" class="btn btn-primary-custom">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Articles -->
            <?php if (!empty($latestArticles)): ?>
            <div class="dashboard-card">
                <h5 class="mb-4"><i class="fas fa-clock me-2"></i>Latest Articles</h5>
                <div class="row">
                    <?php foreach ($latestArticles as $article): ?>
                    <div class="col-md-6 mb-3">
                        <div class="article-card dashboard-card">
                            <h6 class="mb-2"><?= esc($article['judul']) ?></h6>
                            <p class="article-meta mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d M Y', strtotime($article['created_at'])) ?>
                                <span class="ms-3">
                                    <i class="fas fa-tag me-1"></i>
                                    <?= esc($article['nama_kategori'] ?? 'Uncategorized') ?>
                                </span>
                            </p>
                            <p class="text-muted small mb-2"><?= substr(strip_tags($article['isi']), 0, 100) ?>...</p>
                            <a href="<?= base_url('artikel/' . $article['slug']) ?>" class="btn btn-sm btn-outline-primary">
                                Read More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
