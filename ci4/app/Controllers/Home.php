<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new \App\Models\ArtikelModel();
        $artikel = $model->getArtikelDenganKategori(); // Get latest articles
        $artikel = array_slice($artikel, 0, 3); // Limit to 3 articles

        $data = [
            'title' => 'Beranda',
            'content' => 'Selamat datang di website kami. Kami berkomitmen menyediakan informasi berkualitas dan pengalaman yang menyenangkan.',
            'artikel' => $artikel
        ];

        return view('home', $data);
    }
}
