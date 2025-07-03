<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Page extends BaseController
{
    public function home()
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        // Get latest 6 articles for home page
        $artikel = $artikelModel->getArtikelDenganKategori();
        $latestArtikel = array_slice($artikel, 0, 6);

        return view('home', [
            'title'   => 'Home',
            'content' => 'Welcome to our website. We strive to provide valuable information and a seamless experience.',
            'artikel' => $latestArtikel
        ]);
    }

    public function about()
    {
        return view('about', [
            'title'   => 'About Us',
            'content' => 'Learn more about our mission, values, and the people behind our work.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title'   => 'Contact Us',
            'content' => 'Have any questions? Feel free to reach out, and we\'ll be happy to assist you.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title'   => 'FAQs',
            'content' => 'Find answers to common questions and get the support you need.'
        ]);
    }

    public function tos()
    {
        return view('tos', [
            'title'   => 'Terms of Service',
            'content' => 'Please read our terms and conditions carefully to understand how we operate.'
        ]);
    }

    public function oauthSetup()
    {
        return view('admin/oauth_setup', [
            'title' => 'Google OAuth Setup Guide'
        ]);
    }
}
