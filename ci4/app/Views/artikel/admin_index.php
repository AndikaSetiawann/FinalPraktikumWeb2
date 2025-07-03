<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* Admin Dashboard Styles */
.admin-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem 0;
  margin-bottom: 2rem;
  border-radius: 15px;
}

.admin-stats {
  margin-bottom: 2rem;
}

.stat-card-admin {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
}

.stat-card-admin:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon-admin {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
  font-size: 1.5rem;
  color: white;
}

.search-section {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.table-section {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}
</style>

<div class="container">
  <!-- Admin Header -->
  <div class="admin-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1 class="mb-1">
            <i class="fas fa-cogs me-2"></i>
            Dashboard Admin
          </h1>
          <p class="mb-0 opacity-75">Kelola artikel dan konten website</p>
        </div>
        <div class="col-md-4 text-end">
          <div class="alert alert-info mb-0 py-2">
            <i class="fas fa-info-circle me-2"></i>
            <small>Tambah artikel via Vue.js Frontend</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="admin-stats">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="stat-card-admin">
          <div class="stat-icon-admin bg-primary">
            <i class="fas fa-newspaper"></i>
          </div>
          <h4 id="total-articles">0</h4>
          <p class="text-muted mb-0">Total Artikel</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card-admin">
          <div class="stat-icon-admin bg-success">
            <i class="fas fa-check-circle"></i>
          </div>
          <h4 id="published-articles">0</h4>
          <p class="text-muted mb-0">Published</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card-admin">
          <div class="stat-icon-admin bg-warning">
            <i class="fas fa-clock"></i>
          </div>
          <h4 id="draft-articles">0</h4>
          <p class="text-muted mb-0">Draft</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card-admin">
          <div class="stat-icon-admin bg-info">
            <i class="fas fa-folder"></i>
          </div>
          <h4><?= count($kategori) ?></h4>
          <p class="text-muted mb-0">Kategori</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Section -->
  <div class="search-section">
    <h5 class="mb-3">
      <i class="fas fa-search me-2"></i>
      Pencarian & Filter
    </h5>
    <form id="search-form" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Cari Artikel</label>
        <input type="text" name="q" id="search-box" value="<?= esc($q); ?>"
               placeholder="Cari judul artikel..." class="form-control">
      </div>
      <div class="col-md-3">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" id="category-filter" class="form-select">
          <option value="">Semua Kategori</option>
          <?php foreach ($kategori as $k): ?>
            <option value="<?= esc($k['id_kategori']); ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
              <?= esc($k['nama_kategori']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary d-block w-100">
          <i class="fas fa-search me-2"></i>
          Cari
        </button>
      </div>
      <div class="col-md-3">
        <label class="form-label">&nbsp;</label>
        <?php if (session()->get('role') === 'admin'): ?>
          <a href="https://setiawanarticle.my.id/vue/" target="_blank" class="btn btn-success d-block w-100">
            <i class="fab fa-vuejs me-2"></i>
            Vue.js Frontend
          </a>
        <?php else: ?>
          <button class="btn btn-secondary d-block w-100" disabled>
            <i class="fas fa-lock me-2"></i>
            Admin Only
          </button>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Table Section -->
  <div class="table-section">
    <h5 class="mb-3">
      <i class="fas fa-list me-2"></i>
      Daftar Artikel
    </h5>
    <div id="article-container"></div>
    <div id="pagination-container" class="mt-3"></div>
  </div>
</div>

<div id="article-container"></div>
<div id="pagination-container"></div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    const fetchData = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (data) {
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            }
        });
    };

    // Function to format text content (similar to PHP helper)
    const formatTextContent = (text) => {
        if (!text) return '';

        // Escape HTML first
        let formatted = text.replace(/&/g, '&amp;')
                           .replace(/</g, '&lt;')
                           .replace(/>/g, '&gt;')
                           .replace(/"/g, '&quot;')
                           .replace(/'/g, '&#39;');

        // Use temporary placeholders to avoid conflicts
        formatted = formatted.replace(/\*\*([^\*\r\n]+)\*\*/g, '___BOLD_START___$1___BOLD_END___');
        formatted = formatted.replace(/\*([^\*\r\n]+)\*/g, '___ITALIC_START___$1___ITALIC_END___');
        formatted = formatted.replace(/__([^_\r\n]+)__/g, '___UNDERLINE_START___$1___UNDERLINE_END___');

        // Replace placeholders with HTML tags
        formatted = formatted.replace(/___BOLD_START___/g, '<strong>')
                           .replace(/___BOLD_END___/g, '</strong>')
                           .replace(/___ITALIC_START___/g, '<em>')
                           .replace(/___ITALIC_END___/g, '</em>')
                           .replace(/___UNDERLINE_START___/g, '<u>')
                           .replace(/___UNDERLINE_END___/g, '</u>');

        return formatted;
    };

    const renderArticles = (articles) => {
        // Update stats
        const totalArticles = articles.length;
        const publishedArticles = articles.filter(a => a.status == 1).length;
        const draftArticles = articles.filter(a => a.status == 0).length;

        $('#total-articles').text(totalArticles);
        $('#published-articles').text(publishedArticles);
        $('#draft-articles').text(draftArticles);

        let html = '<div class="table-responsive">';
        html += '<table class="table table-hover">';
        html += '<thead class="table-dark"><tr><th width="60">ID</th><th>Artikel</th><th width="120">Kategori</th><th width="100">Status</th><th width="200" class="text-center">Aksi</th></tr></thead><tbody>';

        if (articles.length > 0) {
            articles.forEach(article => {
                const preview = formatTextContent(article.isi.substring(0, 80));
                const statusBadge = article.status == 1 ?
                    '<span class="badge bg-success">Published</span>' :
                    '<span class="badge bg-warning">Draft</span>';

                const categoryBadge = getCategoryBadge(article.nama_kategori);

                html += `
                <tr>
                    <td class="text-center">
                        <strong>#${article.id}</strong>
                    </td>
                    <td>
                        <h6 class="mb-1">${article.judul}</h6>
                        <small class="text-muted">${preview}${article.isi.length > 80 ? '...' : ''}</small>
                    </td>
                    <td>${categoryBadge}</td>
                    <td>${statusBadge}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn-outline-primary" href="/admin/artikel/edit/${article.id}" title="Edit Artikel">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-outline-success" href="/artikel/${article.slug}" target="_blank" title="Lihat Artikel">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-danger" onclick="return confirm('Yakin menghapus artikel: ${article.judul}?');" href="/admin/artikel/delete/${article.id}" title="Hapus Artikel">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5" class="text-center py-4"><i class="fas fa-newspaper fa-2x text-muted mb-2"></i><br>Tidak ada data artikel.</td></tr>';
        }

        html += '</tbody></table></div>';
        articleContainer.html(html);
    };

    const getCategoryBadge = (categoryName) => {
        const categoryClasses = {
            'Bisnis': 'bg-primary',
            'Teknologi': 'bg-success',
            'Olahraga': 'bg-warning',
            'Game': 'bg-danger',
            'Kesehatan': 'bg-info'
        };

        const badgeClass = categoryClasses[categoryName] || 'bg-secondary';
        return `<span class="badge ${badgeClass}">${categoryName || 'Tanpa Kategori'}</span>`;
    };

    const renderPagination = (pager, q, kategori_id) => {
        let html = '<nav><ul class="pagination justify-content-center">';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
            const isDisabled = !link.url && !link.active ? 'disabled' : '';
            html += `<li class="page-item ${link.active ? 'active' : ''} ${isDisabled}">
                        <a class="page-link" href="${url}">${link.title}</a>
                     </li>`;
        });
        html += '</ul></nav>';
        paginationContainer.html(html);
    };

    searchForm.on('submit', function (e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}`);
    });

    categoryFilter.on('change', function () {
        searchForm.trigger('submit');
    });

    // Load awal
    fetchData('/admin/artikel');
});
</script>

<?= $this->endSection() ?>
