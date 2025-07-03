<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* OAuth Setup Guide Styles */
.setup-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 3rem 0;
  margin-bottom: 3rem;
  border-radius: 20px;
}

.setup-card {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.step-number {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  margin-right: 1rem;
}

.code-block {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1rem;
  font-family: 'Courier New', monospace;
  font-size: 0.9rem;
  margin: 1rem 0;
}

.warning-box {
  background: linear-gradient(135deg, #fef5e7, #fed7aa);
  border: 1px solid #f6ad55;
  border-radius: 12px;
  padding: 1.5rem;
  margin: 1.5rem 0;
}

.success-box {
  background: linear-gradient(135deg, #e6fffa, #b2f5ea);
  border: 1px solid #4fd1c7;
  border-radius: 12px;
  padding: 1.5rem;
  margin: 1.5rem 0;
}
</style>

<div class="container">
  <!-- Setup Hero -->
  <div class="setup-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-5 fw-bold mb-3">
            <i class="fab fa-google me-3"></i>
            Google OAuth Setup Guide
          </h1>
          <p class="lead mb-0">
            Panduan lengkap untuk mengaktifkan login dengan Google di Article CMS
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <div class="floating-card">
            <i class="fas fa-cog fa-3x text-warning mb-3"></i>
            <h5>Configuration Required</h5>
            <p class="mb-0">Setup Google Cloud Console</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Step 1: Google Cloud Console -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">1</div>
      <div class="flex-grow-1">
        <h4>Buat Project di Google Cloud Console</h4>
        <p>Pertama, Anda perlu membuat project baru di Google Cloud Console:</p>
        
        <ol>
          <li>Buka <a href="https://console.cloud.google.com/" target="_blank" class="text-primary">Google Cloud Console</a></li>
          <li>Klik "Select a project" di bagian atas</li>
          <li>Klik "New Project"</li>
          <li>Masukkan nama project: <code>Article CMS OAuth</code></li>
          <li>Klik "Create"</li>
        </ol>

        <div class="warning-box">
          <h6><i class="fas fa-exclamation-triangle me-2"></i>Penting!</h6>
          <p class="mb-0">Pastikan project yang baru dibuat sudah terpilih sebelum melanjutkan ke langkah berikutnya.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Step 2: Enable APIs -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">2</div>
      <div class="flex-grow-1">
        <h4>Enable Google+ API</h4>
        <p>Aktifkan API yang diperlukan untuk OAuth:</p>
        
        <ol>
          <li>Di Google Cloud Console, buka menu "APIs & Services" → "Library"</li>
          <li>Cari "Google+ API" atau "People API"</li>
          <li>Klik pada API tersebut</li>
          <li>Klik tombol "Enable"</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Step 3: Create Credentials -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">3</div>
      <div class="flex-grow-1">
        <h4>Buat OAuth 2.0 Credentials</h4>
        <p>Buat credentials untuk aplikasi web:</p>
        
        <ol>
          <li>Buka "APIs & Services" → "Credentials"</li>
          <li>Klik "Create Credentials" → "OAuth 2.0 Client IDs"</li>
          <li>Jika diminta, konfigurasikan OAuth consent screen terlebih dahulu</li>
          <li>Pilih "Application type": <strong>Web application</strong></li>
          <li>Masukkan nama: <code>Article CMS</code></li>
          <li>Di "Authorized redirect URIs", tambahkan:</li>
        </ol>

        <div class="code-block">
          http://localhost:8080/auth/google/callback
        </div>

        <div class="warning-box">
          <h6><i class="fas fa-exclamation-triangle me-2"></i>Redirect URI Penting!</h6>
          <p class="mb-0">Pastikan URL redirect URI sama persis dengan yang di atas, termasuk port 8080.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Step 4: Get Credentials -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">4</div>
      <div class="flex-grow-1">
        <h4>Copy Client ID dan Client Secret</h4>
        <p>Setelah credentials dibuat, Anda akan mendapatkan:</p>
        
        <ul>
          <li><strong>Client ID</strong> - Format: <code>123456789-abc...xyz.apps.googleusercontent.com</code></li>
          <li><strong>Client Secret</strong> - Format: <code>GOCSPX-abcdefghijklmnop...</code></li>
        </ul>

        <p>Copy kedua nilai tersebut untuk langkah selanjutnya.</p>
      </div>
    </div>
  </div>

  <!-- Step 5: Environment Configuration -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">5</div>
      <div class="flex-grow-1">
        <h4>Konfigurasi Environment Variables</h4>
        <p>Buat atau edit file <code>.env</code> di root project:</p>
        
        <div class="code-block">
# Google OAuth Configuration<br>
GOOGLE_CLIENT_ID = 'your-client-id.apps.googleusercontent.com'<br>
GOOGLE_CLIENT_SECRET = 'your-client-secret'
        </div>

        <p>Ganti <code>your-client-id</code> dan <code>your-client-secret</code> dengan nilai yang Anda dapatkan dari Google Cloud Console.</p>

        <div class="warning-box">
          <h6><i class="fas fa-shield-alt me-2"></i>Keamanan</h6>
          <p class="mb-0">Jangan pernah commit file .env ke repository Git. Pastikan .env ada di .gitignore.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Step 6: Test -->
  <div class="setup-card">
    <div class="d-flex align-items-start">
      <div class="step-number">6</div>
      <div class="flex-grow-1">
        <h4>Test Google Login</h4>
        <p>Setelah konfigurasi selesai:</p>
        
        <ol>
          <li>Restart web server (jika menggunakan built-in server)</li>
          <li>Buka halaman <a href="<?= base_url('/user/login') ?>" class="text-primary">Login</a></li>
          <li>Klik tombol "Login dengan Google"</li>
          <li>Anda akan diarahkan ke Google untuk authorize</li>
          <li>Setelah authorize, akan kembali ke aplikasi dan login otomatis</li>
        </ol>

        <div class="success-box">
          <h6><i class="fas fa-check-circle me-2"></i>Berhasil!</h6>
          <p class="mb-0">Jika berhasil, Anda akan masuk ke dashboard dan data user tersimpan di database.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Troubleshooting -->
  <div class="setup-card">
    <h4><i class="fas fa-tools me-2"></i>Troubleshooting</h4>
    
    <div class="row">
      <div class="col-md-6">
        <h6>Error: "client_id missing"</h6>
        <p>Environment variables belum di-set dengan benar. Periksa file .env.</p>
        
        <h6>Error: "redirect_uri_mismatch"</h6>
        <p>URL redirect di Google Console tidak sama dengan yang digunakan aplikasi.</p>
      </div>
      <div class="col-md-6">
        <h6>Error: "access_denied"</h6>
        <p>User membatalkan authorize di Google. Coba lagi.</p>
        
        <h6>Error: "invalid_client"</h6>
        <p>Client ID atau Client Secret salah. Periksa kembali credentials.</p>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <div class="text-center">
    <a href="<?= base_url('/user/login') ?>" class="btn btn-primary btn-lg me-3">
      <i class="fas fa-sign-in-alt me-2"></i>
      Test Login
    </a>
    <a href="<?= base_url('/admin/artikel') ?>" class="btn btn-outline-primary btn-lg">
      <i class="fas fa-arrow-left me-2"></i>
      Kembali ke Dashboard
    </a>
  </div>
</div>

<?= $this->endSection() ?>
