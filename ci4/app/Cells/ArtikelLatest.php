<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\ArtikelModel;

class ArtikelLatest extends Cell
{
    protected $category;

    public function render(): string // ← Tambahkan ": string" di sini
    {
        $model = new ArtikelModel();

        // Query builder
        $builder = $model->orderBy('created_at', 'DESC')->limit(5);

        // Filter berdasarkan kategori jika tersedia
        if (!empty($this->category)) {
            $builder->where('category', $this->category);
        }

        // Ambil data artikel
        $artikel = $builder->findAll();

        return view('components/artikel_latest', [
            'artikel'  => $artikel,
            'category' => is_array($this->category) ? implode(', ', $this->category) : $this->category,
        ]);
    }
}
