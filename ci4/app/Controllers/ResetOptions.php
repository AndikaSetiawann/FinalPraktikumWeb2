<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ResetOptions extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get current data info
        $artikelCount = $db->query("SELECT COUNT(*) as count FROM artikel")->getRow()->count;
        $maxId = $db->query("SELECT MAX(id) as max_id FROM artikel")->getRow()->max_id ?? 0;
        $autoIncrementResult = $db->query("SHOW TABLE STATUS LIKE 'artikel'")->getRow();
        $nextAutoIncrement = $autoIncrementResult->Auto_increment ?? 'Unknown';
        
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Reset ID Options</title>";
        echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
        echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>";
        echo "</head>";
        echo "<body class='bg-light'>";
        
        echo "<div class='container mt-5'>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='col-md-8'>";
        
        // Header
        echo "<div class='card shadow-lg border-0'>";
        echo "<div class='card-header bg-primary text-white text-center py-4'>";
        echo "<h2><i class='fas fa-cogs me-2'></i>Reset ID Options</h2>";
        echo "<p class='mb-0'>Pilih cara reset auto increment ID artikel</p>";
        echo "</div>";
        
        echo "<div class='card-body p-4'>";
        
        // Current Status
        echo "<div class='alert alert-info'>";
        echo "<h5><i class='fas fa-info-circle me-2'></i>Status Saat Ini:</h5>";
        echo "<ul class='mb-0'>";
        echo "<li><strong>Total Artikel:</strong> $artikelCount</li>";
        echo "<li><strong>ID Tertinggi:</strong> $maxId</li>";
        echo "<li><strong>ID Artikel Baru:</strong> $nextAutoIncrement</li>";
        echo "</ul>";
        echo "</div>";
        
        // Options
        echo "<div class='row g-4'>";
        
        // Option 1: Reset tanpa hapus data
        echo "<div class='col-md-6'>";
        echo "<div class='card h-100 border-success'>";
        echo "<div class='card-header bg-success text-white text-center'>";
        echo "<h5><i class='fas fa-refresh me-2'></i>Reset Auto Increment</h5>";
        echo "</div>";
        echo "<div class='card-body text-center'>";
        echo "<p class='card-text'>Reset auto increment tanpa menghapus data yang ada.</p>";
        echo "<ul class='text-start'>";
        echo "<li>✅ Data artikel tetap ada</li>";
        echo "<li>✅ ID baru mulai dari " . ($maxId + 1) . "</li>";
        echo "<li>✅ Aman, tidak ada data hilang</li>";
        echo "</ul>";
        echo "<a href='/reset-to-one' class='btn btn-success btn-lg'>";
        echo "<i class='fas fa-play me-2'></i>Reset Auto Increment";
        echo "</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        // Option 2: Hapus semua data
        echo "<div class='col-md-6'>";
        echo "<div class='card h-100 border-danger'>";
        echo "<div class='card-header bg-danger text-white text-center'>";
        echo "<h5><i class='fas fa-trash me-2'></i>Hapus Semua & Reset</h5>";
        echo "</div>";
        echo "<div class='card-body text-center'>";
        echo "<p class='card-text'>Hapus semua artikel dan reset ID ke 1.</p>";
        echo "<ul class='text-start'>";
        echo "<li>⚠️ Semua artikel akan dihapus</li>";
        echo "<li>✅ ID baru mulai dari 1</li>";
        echo "<li>❌ Data tidak bisa dikembalikan</li>";
        echo "</ul>";
        echo "<button class='btn btn-danger btn-lg' onclick='confirmDelete()'>";
        echo "<i class='fas fa-exclamation-triangle me-2'></i>Hapus Semua";
        echo "</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        echo "</div>"; // End row
        
        // Navigation
        echo "<div class='text-center mt-4'>";
        echo "<a href='/lab8_vuejs/index.html' class='btn btn-primary me-3'>";
        echo "<i class='fab fa-vuejs me-2'></i>Ke Vue.js";
        echo "</a>";
        echo "<a href='/admin/artikel' class='btn btn-success'>";
        echo "<i class='fas fa-cog me-2'></i>Ke Admin";
        echo "</a>";
        echo "</div>";
        
        echo "</div>"; // End card-body
        echo "</div>"; // End card
        echo "</div>"; // End col
        echo "</div>"; // End row
        echo "</div>"; // End container
        
        // JavaScript for confirmation
        echo "<script>";
        echo "function confirmDelete() {";
        echo "  if (confirm('⚠️ PERINGATAN!\\n\\nAnda akan menghapus SEMUA artikel yang ada.\\nTindakan ini tidak dapat dibatalkan!\\n\\nApakah Anda yakin?')) {";
        echo "    if (confirm('Konfirmasi sekali lagi:\\nSemua data artikel akan HILANG PERMANEN!\\n\\nLanjutkan?')) {";
        echo "      window.location.href = '/delete-all-articles';";
        echo "    }";
        echo "  }";
        echo "}";
        echo "</script>";
        
        echo "</body>";
        echo "</html>";
    }
}
?>
