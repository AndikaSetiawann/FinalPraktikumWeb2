<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* Terms of Service Page Styles */
.tos-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 4rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.tos-section {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.tos-toc {
  background: #f7fafc;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  border-left: 4px solid #667eea;
}

.tos-toc ul {
  margin: 0;
  padding-left: 1.5rem;
}

.tos-toc li {
  margin-bottom: 0.5rem;
}

.tos-toc a {
  color: #667eea;
  text-decoration: none;
  font-weight: 500;
}

.tos-toc a:hover {
  text-decoration: underline;
}

.tos-article {
  margin-bottom: 3rem;
}

.tos-article h3 {
  color: #2d3748;
  font-weight: 700;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #e2e8f0;
}

.tos-article h4 {
  color: #4a5568;
  font-weight: 600;
  margin: 1.5rem 0 1rem 0;
}

.tos-article p {
  color: #4a5568;
  line-height: 1.7;
  margin-bottom: 1rem;
}

.tos-article ul, .tos-article ol {
  color: #4a5568;
  line-height: 1.7;
  margin-bottom: 1rem;
  padding-left: 2rem;
}

.tos-article li {
  margin-bottom: 0.5rem;
}

.highlight-box {
  background: linear-gradient(135deg, #fef5e7, #fed7aa);
  border: 1px solid #f6ad55;
  border-radius: 12px;
  padding: 1.5rem;
  margin: 2rem 0;
}

.highlight-box h5 {
  color: #c05621;
  font-weight: 700;
  margin-bottom: 1rem;
}

.highlight-box p {
  color: #9c4221;
  margin: 0;
}

.contact-box {
  background: linear-gradient(135deg, #e6fffa, #b2f5ea);
  border: 1px solid #4fd1c7;
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  margin-top: 3rem;
}

.contact-box h4 {
  color: #234e52;
  margin-bottom: 1rem;
}

.contact-box p {
  color: #2c7a7b;
  margin-bottom: 1.5rem;
}
</style>

<div class="container">
  <!-- TOS Hero -->
  <div class="tos-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-file-contract me-3"></i>
            Terms of Service
          </h1>
          <p class="lead mb-0">
            Syarat dan ketentuan penggunaan platform Article CMS. Harap baca dengan seksama
            sebelum menggunakan layanan kami.
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <div class="floating-card">
            <i class="fas fa-balance-scale fa-3x text-warning mb-3"></i>
            <h5>Legal Terms</h5>
            <p class="mb-0">Updated: Jan 2025</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table of Contents -->
  <div class="tos-section">
    <div class="tos-toc">
      <h5 class="mb-3">
        <i class="fas fa-list me-2"></i>
        Daftar Isi
      </h5>
      <ul>
        <li><a href="#acceptance">1. Penerimaan Syarat</a></li>
        <li><a href="#description">2. Deskripsi Layanan</a></li>
        <li><a href="#user-accounts">3. Akun Pengguna</a></li>
        <li><a href="#acceptable-use">4. Penggunaan yang Dapat Diterima</a></li>
        <li><a href="#content">5. Konten dan Hak Kekayaan Intelektual</a></li>
        <li><a href="#privacy">6. Privasi dan Data</a></li>
        <li><a href="#limitation">7. Batasan Tanggung Jawab</a></li>
        <li><a href="#termination">8. Penghentian Layanan</a></li>
        <li><a href="#changes">9. Perubahan Syarat</a></li>
        <li><a href="#contact">10. Kontak</a></li>
      </ul>
    </div>
  </div>

  <!-- Terms Content -->
  <div class="tos-section">
    <div class="tos-article" id="acceptance">
      <h3>1. Penerimaan Syarat</h3>
      <p>
        Dengan mengakses dan menggunakan platform Article CMS ("Layanan"), Anda menyetujui
        untuk terikat oleh syarat dan ketentuan ini ("Syarat"). Jika Anda tidak menyetujui
        semua syarat ini, jangan gunakan Layanan kami.
      </p>
      <p>
        Syarat ini berlaku untuk semua pengguna Layanan, termasuk namun tidak terbatas pada
        pengguna yang merupakan kontributor konten, informasi, dan layanan lainnya.
      </p>
    </div>

    <div class="tos-article" id="description">
      <h3>2. Deskripsi Layanan</h3>
      <p>
        Article CMS adalah platform manajemen konten yang memungkinkan pengguna untuk:
      </p>
      <ul>
        <li>Membuat, mengedit, dan mengelola artikel</li>
        <li>Mengorganisir konten dalam kategori</li>
        <li>Mengunggah dan mengelola media</li>
        <li>Mempublikasikan konten ke website</li>
        <li>Mengakses dashboard admin untuk manajemen</li>
      </ul>
      <p>
        Layanan ini disediakan "sebagaimana adanya" dan dapat diubah atau dihentikan
        sewaktu-waktu tanpa pemberitahuan sebelumnya.
      </p>
    </div>

    <div class="tos-article" id="user-accounts">
      <h3>3. Akun Pengguna</h3>
      <h4>3.1 Registrasi Akun</h4>
      <p>
        Untuk menggunakan fitur tertentu dari Layanan, Anda mungkin diminta untuk
        membuat akun. Anda bertanggung jawab untuk:
      </p>
      <ul>
        <li>Memberikan informasi yang akurat dan lengkap</li>
        <li>Menjaga keamanan password dan akun Anda</li>
        <li>Memperbarui informasi akun jika terjadi perubahan</li>
        <li>Bertanggung jawab atas semua aktivitas yang terjadi di akun Anda</li>
      </ul>

      <h4>3.2 Keamanan Akun</h4>
      <p>
        Anda harus segera memberitahu kami jika mengetahui adanya penggunaan tidak sah
        atas akun Anda atau pelanggaran keamanan lainnya.
      </p>
    </div>

    <div class="tos-article" id="acceptable-use">
      <h3>4. Penggunaan yang Dapat Diterima</h3>
      <p>Anda setuju untuk TIDAK menggunakan Layanan untuk:</p>
      <ul>
        <li>Mengunggah konten yang melanggar hukum, berbahaya, atau menyinggung</li>
        <li>Melanggar hak kekayaan intelektual pihak lain</li>
        <li>Mengirim spam, virus, atau kode berbahaya lainnya</li>
        <li>Mencoba mengakses sistem secara tidak sah</li>
        <li>Mengganggu atau merusak integritas atau kinerja Layanan</li>
        <li>Menggunakan Layanan untuk tujuan komersial tanpa izin</li>
      </ul>

      <div class="highlight-box">
        <h5><i class="fas fa-exclamation-triangle me-2"></i>Peringatan Penting</h5>
        <p>
          Pelanggaran terhadap kebijakan penggunaan dapat mengakibatkan penangguhan
          atau penghentian akun Anda tanpa pemberitahuan sebelumnya.
        </p>
      </div>
    </div>

    <div class="tos-article" id="content">
      <h3>5. Konten dan Hak Kekayaan Intelektual</h3>
      <h4>5.1 Konten Pengguna</h4>
      <p>
        Anda mempertahankan kepemilikan atas konten yang Anda buat dan unggah ke Layanan.
        Namun, dengan mengunggah konten, Anda memberikan kami lisensi non-eksklusif untuk
        menggunakan, menyimpan, dan menampilkan konten tersebut dalam rangka menyediakan Layanan.
      </p>

      <h4>5.2 Hak Kekayaan Intelektual Kami</h4>
      <p>
        Layanan dan konten aslinya, fitur, dan fungsionalitasnya adalah dan akan tetap
        menjadi milik eksklusif Article CMS dan pemberi lisensinya. Layanan dilindungi
        oleh hak cipta, merek dagang, dan hukum lainnya.
      </p>
    </div>

    <div class="tos-article" id="privacy">
      <h3>6. Privasi dan Data</h3>
      <p>
        Privasi Anda penting bagi kami. Pengumpulan dan penggunaan informasi pribadi
        Anda diatur oleh Kebijakan Privasi kami, yang merupakan bagian integral dari
        Syarat ini.
      </p>
      <p>
        Dengan menggunakan Layanan, Anda menyetujui pengumpulan dan penggunaan informasi
        sesuai dengan Kebijakan Privasi kami.
      </p>
    </div>

    <div class="tos-article" id="limitation">
      <h3>7. Batasan Tanggung Jawab</h3>
      <p>
        Dalam batas maksimum yang diizinkan oleh hukum yang berlaku, Article CMS tidak
        akan bertanggung jawab atas kerugian tidak langsung, insidental, khusus,
        konsekuensial, atau punitif.
      </p>
      <p>
        Layanan disediakan "sebagaimana adanya" tanpa jaminan apapun, baik tersurat
        maupun tersirat, termasuk namun tidak terbatas pada jaminan kelayakan untuk
        tujuan tertentu.
      </p>
    </div>

    <div class="tos-article" id="termination">
      <h3>8. Penghentian Layanan</h3>
      <p>
        Kami dapat menghentikan atau menangguhkan akses Anda segera, tanpa pemberitahuan
        sebelumnya atau tanggung jawab, karena alasan apapun, termasuk namun tidak
        terbatas pada pelanggaran Syarat.
      </p>
      <p>
        Setelah penghentian, hak Anda untuk menggunakan Layanan akan berakhir segera.
      </p>
    </div>

    <div class="tos-article" id="changes">
      <h3>9. Perubahan Syarat</h3>
      <p>
        Kami berhak, atas kebijakan kami sendiri, untuk memodifikasi atau mengganti
        Syarat ini kapan saja. Jika revisi bersifat material, kami akan berusaha
        memberikan pemberitahuan setidaknya 30 hari sebelum syarat baru berlaku.
      </p>
      <p>
        Penggunaan berkelanjutan atas Layanan setelah perubahan tersebut berlaku
        akan dianggap sebagai penerimaan Anda atas syarat yang baru.
      </p>
    </div>

    <div class="tos-article" id="contact">
      <h3>10. Kontak</h3>
      <p>
        Jika Anda memiliki pertanyaan tentang Syarat ini, silakan hubungi kami melalui:
      </p>
      <ul>
        <li>Email: asetiawanandika@gmail.com</li>
        <li>Telepon: +62 813-8820-9195</li>
        <li>Alamat: Universitas Pelita Bangsa, Bekasi, Jawa Barat, Indonesia</li>
      </ul>
    </div>
  </div>

  <!-- Contact Box -->
  <div class="contact-box">
    <h4>Butuh Bantuan Memahami Syarat Ini?</h4>
    <p>Tim legal kami siap membantu menjelaskan syarat dan ketentuan dengan bahasa yang lebih mudah dipahami.</p>
    <div class="d-flex gap-3 justify-content-center">
      <a href="<?= base_url('/contact') ?>" class="btn btn-primary">
        <i class="fas fa-envelope me-2"></i>
        Hubungi Tim Legal
      </a>
      <a href="<?= base_url('/faqs') ?>" class="btn btn-outline-primary">
        <i class="fas fa-question-circle me-2"></i>
        Lihat FAQ
      </a>
    </div>
  </div>

  <!-- Last Updated -->
  <div class="text-center mt-4">
    <small class="text-muted">
      <i class="fas fa-calendar me-2"></i>
      Terakhir diperbarui: 1 Januari 2025
    </small>
  </div>
</div>

<script>
// Smooth scroll for table of contents links
document.querySelectorAll('.tos-toc a').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const targetId = this.getAttribute('href').substring(1);
    const targetElement = document.getElementById(targetId);

    if (targetElement) {
      targetElement.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});
</script>

<?= $this->endSection() ?>
