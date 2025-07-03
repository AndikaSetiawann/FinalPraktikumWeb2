<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ResetToOne extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        try {
            // Hapus semua data artikel (opsional - hati-hati!)
            // $db->query("DELETE FROM artikel");
            
            // Reset auto increment ke 1
            $db->query("ALTER TABLE artikel AUTO_INCREMENT = 1");
            
            // Cek current auto increment value
            $result = $db->query("SHOW TABLE STATUS LIKE 'artikel'")->getRow();
            $autoIncrement = $result->Auto_increment ?? 'Unknown';
            
            echo "<div style='font-family: Arial; padding: 20px; max-width: 600px; margin: 50px auto; border: 1px solid #ddd; border-radius: 10px;'>";
            echo "<h2 style='color: #28a745;'>✅ Auto Increment Reset Berhasil!</h2>";
            echo "<p><strong>Next Auto Increment:</strong> $autoIncrement</p>";
            echo "<p style='color: #666;'>Sekarang artikel baru akan dimulai dari ID: <strong>$autoIncrement</strong></p>";
            
            echo "<div style='margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;'>";
            echo "<h4>📋 Langkah Selanjutnya:</h4>";
            echo "<ol>";
            echo "<li>Kembali ke Vue.js dan coba tambah artikel baru</li>";
            echo "<li>ID akan dimulai dari angka $autoIncrement</li>";
            echo "<li>Artikel akan berurutan: $autoIncrement, " . ($autoIncrement + 1) . ", " . ($autoIncrement + 2) . ", dst...</li>";
            echo "</ol>";
            echo "</div>";
            
            echo "<div style='margin-top: 20px;'>";
            echo "<a href='/lab8_vuejs/index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🚀 Ke Vue.js</a>";
            echo "<a href='/admin/artikel' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📊 Ke Admin</a>";
            echo "</div>";
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div style='font-family: Arial; padding: 20px; max-width: 600px; margin: 50px auto; border: 1px solid #dc3545; border-radius: 10px; background: #f8d7da;'>";
            echo "<h2 style='color: #dc3545;'>❌ Error!</h2>";
            echo "<p>Gagal reset auto increment: " . $e->getMessage() . "</p>";
            echo "</div>";
        }
    }
    
    public function deleteAll()
    {
        $db = \Config\Database::connect();
        
        try {
            // Hapus semua data artikel
            $db->query("DELETE FROM artikel");
            
            // Reset auto increment ke 1
            $db->query("ALTER TABLE artikel AUTO_INCREMENT = 1");
            
            echo "<div style='font-family: Arial; padding: 20px; max-width: 600px; margin: 50px auto; border: 1px solid #dc3545; border-radius: 10px;'>";
            echo "<h2 style='color: #dc3545;'>🗑️ Semua Data Artikel Dihapus!</h2>";
            echo "<p><strong>Status:</strong> Tabel artikel sudah kosong</p>";
            echo "<p><strong>Auto Increment:</strong> Reset ke 1</p>";
            echo "<p style='color: #666;'>Artikel baru akan dimulai dari ID: <strong>1</strong></p>";
            
            echo "<div style='margin-top: 20px;'>";
            echo "<a href='/lab8_vuejs/index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🚀 Ke Vue.js</a>";
            echo "<a href='/admin/artikel' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📊 Ke Admin</a>";
            echo "</div>";
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<div style='font-family: Arial; padding: 20px; max-width: 600px; margin: 50px auto; border: 1px solid #dc3545; border-radius: 10px; background: #f8d7da;'>";
            echo "<h2 style='color: #dc3545;'>❌ Error!</h2>";
            echo "<p>Gagal hapus data: " . $e->getMessage() . "</p>";
            echo "</div>";
        }
    }
}
?>
