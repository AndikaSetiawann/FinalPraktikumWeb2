# 🚀 PANDUAN SETUP PRODUCTION HOSTING

## 📋 CHECKLIST SEBELUM UPLOAD

### 1. **Update Konfigurasi di File .env**
```env
# Environment
CI_ENVIRONMENT = production

# Domain (WAJIB DIUBAH)
app.baseURL = 'https://yourdomain.com/'

# Database Hosting (WAJIB DIUBAH)
database.default.hostname = your_hosting_database_host
database.default.database = your_database_name  
database.default.username = your_database_username
database.default.password = your_database_password

# Encryption Key (WAJIB DIUBAH - 32 karakter)
encryption.key = your_32_character_encryption_key_here

# Google OAuth Production (WAJIB DIUBAH)
GOOGLE_CLIENT_ID = 'your_production_google_client_id'
GOOGLE_CLIENT_SECRET = 'your_production_google_client_secret'
```

### 2. **Generate Encryption Key**
Jalankan command ini untuk generate encryption key:
```bash
php spark key:generate
```
Atau buat manual 32 karakter random.

### 3. **Setup Google OAuth untuk Production**
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Pilih project atau buat baru
3. Enable Google+ API
4. Buat OAuth 2.0 credentials
5. Tambahkan Authorized redirect URIs:
   - `https://yourdomain.com/auth/google/callback`
6. Copy Client ID dan Client Secret ke .env

### 4. **Database Setup di Hosting**
1. Buat database baru di cPanel/hosting panel
2. Import file `database_complete.sql`
3. Update kredensial database di .env

### 5. **File Upload ke Hosting**
Upload semua file KECUALI:
- `/vendor/` (akan diinstall via composer)
- `/.git/` (jika ada)
- `/node_modules/` (jika ada)

### 6. **Composer Install di Server**
Jalankan di terminal hosting:
```bash
composer install --no-dev --optimize-autoloader
```

### 7. **Set File Permissions**
```bash
chmod 755 public/
chmod -R 777 writable/
chmod -R 755 public/uploads/
```

### 8. **Test Website**
1. Akses domain Anda
2. Test login Google OAuth
3. Test upload gambar
4. Test CRUD artikel

## ⚠️ SECURITY CHECKLIST

- ✅ Environment = production
- ✅ Database debug = false  
- ✅ Error display = off
- ✅ Strong encryption key
- ✅ Production OAuth credentials
- ✅ File permissions correct
- ✅ .env file tidak accessible dari web

## 🔧 TROUBLESHOOTING

**Error 500:**
- Check file permissions
- Check .env configuration
- Check error logs di hosting

**Database connection error:**
- Verify database credentials
- Check database host
- Ensure database exists

**OAuth error:**
- Check redirect URLs
- Verify client credentials
- Check domain configuration

## 📞 SUPPORT
Jika ada masalah, cek error log di:
- `writable/logs/`
- Error log hosting panel
