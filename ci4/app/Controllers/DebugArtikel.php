<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class DebugArtikel extends BaseController
{
    public function index()
    {
        $output = "<h1>Debug Artikel</h1>";
        
        try {
            // Test database connection
            $db = \Config\Database::connect();
            $output .= "<h2>✅ Database Connection: OK</h2>";
            
            // Test artikel model
            $artikelModel = new ArtikelModel();
            $articles = $artikelModel->findAll();
            $output .= "<h2>📄 Total Artikel: " . count($articles) . "</h2>";
            
            // Show artikel data
            if (!empty($articles)) {
                $output .= "<h3>Data Artikel:</h3><ul>";
                foreach ($articles as $artikel) {
                    $output .= "<li>ID: {$artikel['id']} - {$artikel['judul']} (Kategori ID: {$artikel['id_kategori']})</li>";
                }
                $output .= "</ul>";
            }
            
            // Test kategori model
            $kategoriModel = new KategoriModel();
            $categories = $kategoriModel->findAll();
            $output .= "<h2>📂 Total Kategori: " . count($categories) . "</h2>";
            
            // Show kategori data
            if (!empty($categories)) {
                $output .= "<h3>Data Kategori:</h3><ul>";
                foreach ($categories as $kategori) {
                    $output .= "<li>ID: {$kategori['id_kategori']} - {$kategori['nama_kategori']}</li>";
                }
                $output .= "</ul>";
            }
            
            // Test artikel with kategori join
            $artikelWithKategori = $artikelModel->getArtikelDenganKategori();
            $output .= "<h2>🔗 Artikel dengan Kategori: " . count($artikelWithKategori) . "</h2>";
            
            if (!empty($artikelWithKategori)) {
                $output .= "<h3>Data Join:</h3><ul>";
                foreach ($artikelWithKategori as $item) {
                    $output .= "<li>ID: {$item['id']} - {$item['judul']} - Kategori: " . ($item['nama_kategori'] ?? 'NULL') . "</li>";
                }
                $output .= "</ul>";
            }
            
        } catch (\Exception $e) {
            $output .= "<h2>❌ Error: " . $e->getMessage() . "</h2>";
            $output .= "<pre>" . $e->getTraceAsString() . "</pre>";
        }
        
        $output .= "<br><a href='/debug-logs' style='background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>View Logs</a>";
        
        return $output;
    }
    
    public function logs()
    {
        $logFile = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
        
        if (!file_exists($logFile)) {
            return "<h1>Log File Not Found</h1><p>File: {$logFile}</p>";
        }
        
        $logs = file_get_contents($logFile);
        $lines = explode("\n", $logs);
        
        // Get last 100 lines
        $recentLines = array_slice($lines, -100);
        
        $output = "<h1>Recent Logs (Last 100 lines)</h1>";
        $output .= "<div style='background: #f5f5f5; padding: 10px; font-family: monospace; white-space: pre-wrap; max-height: 600px; overflow-y: scroll; border: 1px solid #ddd;'>";
        $output .= htmlspecialchars(implode("\n", $recentLines));
        $output .= "</div>";
        
        $output .= "<br><a href='/debug-logs' style='background: #007bff; color: white; padding: 5px 10px; text-decoration: none; margin-right: 10px;'>Refresh</a>";
        $output .= "<a href='/debug-artikel' style='background: #28a745; color: white; padding: 5px 10px; text-decoration: none;'>Back to Debug</a>";
        
        return $output;
    }
}
