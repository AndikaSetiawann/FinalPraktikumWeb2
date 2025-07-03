<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class FixSlug extends BaseController
{
    public function index()
    {
        $model = new ArtikelModel();
        
        // Get all articles without slug or with empty slug
        $articles = $model->where('slug IS NULL OR slug = ""')->findAll();
        
        $updated = 0;
        foreach ($articles as $article) {
            if (!empty($article['judul'])) {
                $slug = url_title($article['judul'], '-', true);
                $model->update($article['id'], ['slug' => $slug]);
                $updated++;
                echo "Updated article ID {$article['id']}: '{$article['judul']}' -> slug: '{$slug}'<br>";
            }
        }
        
        echo "<br><strong>Total updated: {$updated} articles</strong>";
        echo "<br><a href='/artikel'>View Articles</a>";
    }
}
