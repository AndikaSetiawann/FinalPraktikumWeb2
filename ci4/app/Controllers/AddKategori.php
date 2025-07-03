<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class AddKategori extends BaseController
{
    public function index()
    {
        $model = new KategoriModel();
        
        // Data kategori yang akan ditambahkan
        $kategoriData = [
            ['nama_kategori' => 'Teknologi', 'slug_kategori' => 'teknologi'],
            ['nama_kategori' => 'Bisnis', 'slug_kategori' => 'bisnis'],
            ['nama_kategori' => 'Lifestyle', 'slug_kategori' => 'lifestyle'],
            ['nama_kategori' => 'Pendidikan', 'slug_kategori' => 'pendidikan'],
            ['nama_kategori' => 'Olahraga', 'slug_kategori' => 'olahraga'],
            ['nama_kategori' => 'Kesehatan', 'slug_kategori' => 'kesehatan'],
            ['nama_kategori' => 'Travel', 'slug_kategori' => 'travel'],
            ['nama_kategori' => 'Kuliner', 'slug_kategori' => 'kuliner'],
            ['nama_kategori' => 'Entertainment', 'slug_kategori' => 'entertainment'],
            ['nama_kategori' => 'Politik', 'slug_kategori' => 'politik'],
        ];
        
        $added = 0;
        $skipped = 0;
        
        foreach ($kategoriData as $kategori) {
            // Cek apakah kategori sudah ada
            $existing = $model->where('nama_kategori', $kategori['nama_kategori'])->first();
            
            if (!$existing) {
                $model->insert($kategori);
                $added++;
                echo "✅ Added: {$kategori['nama_kategori']}<br>";
            } else {
                $skipped++;
                echo "⏭️ Skipped (already exists): {$kategori['nama_kategori']}<br>";
            }
        }
        
        echo "<br><strong>Summary:</strong><br>";
        echo "✅ Added: {$added} categories<br>";
        echo "⏭️ Skipped: {$skipped} categories<br>";
        echo "<br><a href='/kategori' target='_blank'>View Categories API</a>";
        echo "<br><a href='http://localhost/lab8_vuejs/index.html' target='_blank'>Test Vue.js Frontend</a>";
    }
}
