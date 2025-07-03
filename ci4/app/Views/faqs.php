<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* FAQ Page Styles */
.faq-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.faq-section {
  margin-bottom: 3rem;
}

.faq-category {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.faq-item {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  margin-bottom: 1rem;
  overflow: hidden;
  transition: all 0.3s ease;
}

.faq-item:hover {
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.faq-question {
  background: #f7fafc;
  padding: 1.5rem;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 600;
  color: #2d3748;
  transition: all 0.3s ease;
}

.faq-question:hover {
  background: #edf2f7;
}

.faq-question.active {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
}

.faq-answer {
  padding: 1.5rem;
  background: white;
  color: #4a5568;
  line-height: 1.6;
  display: none;
}

.faq-answer.show {
  display: block;
  animation: slideDown 0.3s ease;
}

.faq-icon {
  transition: transform 0.3s ease;
}

.faq-icon.rotate {
  transform: rotate(180deg);
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.search-faq {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.search-input {
  width: 100%;
  padding: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #f7fafc;
}

.search-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  background: white;
}
</style>

<div class="container">
  <!-- FAQ Hero -->
  <div class="faq-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-question-circle me-3"></i>
            Frequently Asked Questions
          </h1>
          <p class="lead mb-0">
            Temukan jawaban untuk pertanyaan yang sering diajukan tentang platform Article CMS kami.
            Jika tidak menemukan jawaban, jangan ragu untuk menghubungi kami.
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <div class="floating-card">
            <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
            <h5>Need Help?</h5>
            <p class="mb-0">Find Your Answers</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search FAQ -->
  <div class="search-faq">
    <h5 class="mb-3">
      <i class="fas fa-search me-2"></i>
      Cari Pertanyaan
    </h5>
    <input type="text" class="search-input" id="searchFAQ" placeholder="Ketik kata kunci untuk mencari FAQ...">
  </div>

  <!-- General FAQs -->
  <div class="faq-category">
    <h3 class="mb-4">
      <i class="fas fa-info-circle me-2 text-primary"></i>
      Pertanyaan Umum
    </h3>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Apa itu Article CMS?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Article CMS adalah platform manajemen konten modern yang dibangun dengan Vue.js 3 dan CodeIgniter 4.
        Platform ini memungkinkan Anda untuk mengelola artikel, kategori, dan konten website dengan mudah dan efisien.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Bagaimana cara memulai menggunakan platform ini?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Untuk memulai, Anda perlu login sebagai admin menggunakan kredensial yang telah disediakan.
        Setelah login, Anda dapat mengakses dashboard admin untuk mengelola artikel dan kategori.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Apakah platform ini gratis?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Ya, Article CMS adalah platform open source yang dapat digunakan secara gratis.
        Anda dapat mengunduh, memodifikasi, dan menggunakannya sesuai kebutuhan Anda.
      </div>
    </div>
  </div>

  <!-- Technical FAQs -->
  <div class="faq-category">
    <h3 class="mb-4">
      <i class="fas fa-cogs me-2 text-success"></i>
      Pertanyaan Teknis
    </h3>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Teknologi apa saja yang digunakan?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Platform ini menggunakan Vue.js 3 untuk frontend, CodeIgniter 4 untuk backend,
        MySQL untuk database, dan Bootstrap 5 untuk styling. Kombinasi teknologi ini memberikan
        performa optimal dan pengalaman pengguna yang excellent.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Bagaimana cara mengintegrasikan Vue.js dengan CodeIgniter?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Vue.js frontend berkomunikasi dengan CodeIgniter backend melalui REST API.
        Data dikirim dalam format JSON dan diproses secara asynchronous menggunakan Axios
        untuk memberikan pengalaman real-time yang smooth.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Apakah platform ini responsive?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Ya, platform ini fully responsive dan dapat diakses dengan sempurna di desktop,
        tablet, dan mobile devices. Design menggunakan Bootstrap 5 grid system untuk
        memastikan tampilan optimal di semua ukuran layar.
      </div>
    </div>
  </div>

  <!-- Feature FAQs -->
  <div class="faq-category">
    <h3 class="mb-4">
      <i class="fas fa-star me-2 text-warning"></i>
      Fitur & Fungsionalitas
    </h3>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Fitur apa saja yang tersedia?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Platform ini menyediakan CRUD artikel, manajemen kategori, upload gambar,
        rich text editor, search & filter, pagination, user authentication,
        dan dashboard admin yang comprehensive.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Bagaimana cara mengelola gambar artikel?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Anda dapat upload gambar melalui form artikel dengan drag & drop atau file picker.
        Gambar akan otomatis di-resize dan di-optimize untuk web. Preview gambar tersedia
        sebelum menyimpan artikel.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Apakah ada fitur search dan filter?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Ya, tersedia fitur search real-time berdasarkan judul dan konten artikel,
        serta filter berdasarkan kategori dan status publikasi. Semua dilakukan
        secara asynchronous untuk performa yang optimal.
      </div>
    </div>
  </div>

  <!-- Support FAQs -->
  <div class="faq-category">
    <h3 class="mb-4">
      <i class="fas fa-headset me-2 text-info"></i>
      Support & Bantuan
    </h3>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Bagaimana cara mendapatkan bantuan?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Anda dapat menghubungi kami melalui halaman Contact, email, atau telepon.
        Tim support kami siap membantu Anda dengan response time kurang dari 24 jam
        untuk email dan langsung untuk telepon.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Apakah ada dokumentasi lengkap?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Ya, dokumentasi lengkap tersedia termasuk installation guide, API documentation,
        dan user manual. Dokumentasi selalu diupdate seiring dengan perkembangan platform.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>Bagaimana cara melaporkan bug atau request fitur?</span>
        <i class="fas fa-chevron-down faq-icon"></i>
      </div>
      <div class="faq-answer">
        Anda dapat melaporkan bug atau request fitur melalui halaman Contact atau
        email langsung ke tim development. Setiap laporan akan ditindaklanjuti
        dan diprioritaskan berdasarkan tingkat kepentingan.
      </div>
    </div>
  </div>

  <!-- Contact CTA -->
  <div class="faq-section">
    <div class="faq-category text-center">
      <h4 class="mb-3">Tidak Menemukan Jawaban?</h4>
      <p class="mb-4">Tim support kami siap membantu Anda dengan pertanyaan apapun.</p>
      <div class="d-flex gap-3 justify-content-center">
        <a href="<?= base_url('/contact') ?>" class="btn btn-primary btn-lg">
          <i class="fas fa-envelope me-2"></i>
          Hubungi Support
        </a>
        <a href="<?= base_url('/about') ?>" class="btn btn-outline-primary btn-lg">
          <i class="fas fa-info-circle me-2"></i>
          Tentang Kami
        </a>
      </div>
    </div>
  </div>
</div>

<script>
function toggleFAQ(element) {
  const answer = element.nextElementSibling;
  const icon = element.querySelector('.faq-icon');

  // Close all other FAQs
  document.querySelectorAll('.faq-answer').forEach(ans => {
    if (ans !== answer) {
      ans.classList.remove('show');
      ans.previousElementSibling.classList.remove('active');
      ans.previousElementSibling.querySelector('.faq-icon').classList.remove('rotate');
    }
  });

  // Toggle current FAQ
  answer.classList.toggle('show');
  element.classList.toggle('active');
  icon.classList.toggle('rotate');
}

// Search functionality
document.getElementById('searchFAQ').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question span').textContent.toLowerCase();
    const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
});
</script>

<?= $this->endSection() ?>
