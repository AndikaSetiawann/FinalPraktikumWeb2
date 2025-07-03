<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class UserDashboard extends BaseController
{
    protected $artikelModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * User Dashboard
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to access dashboard.');
            return redirect()->to('/user/login');
        }

        // Check if user has user role (not admin)
        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin/artikel');
        }

        // Get statistics
        $data = [
            'title' => 'User Dashboard',
            'totalArticles' => $this->artikelModel->countAll(),
            'totalCategories' => $this->kategoriModel->countAll(),
            'recentArticles' => $this->artikelModel->where('created_at >=', date('Y-m-d', strtotime('-30 days')))->countAllResults(),
            'latestArticles' => $this->artikelModel
                ->select('artikel.*, kategori.nama_kategori')
                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                ->orderBy('artikel.created_at', 'DESC')
                ->limit(4)
                ->find()
        ];

        return view('user/dashboard', $data);
    }

    /**
     * User Profile (future feature)
     */
    public function profile()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to access profile.');
            return redirect()->to('/user/login');
        }

        $data = [
            'title' => 'User Profile'
        ];

        return view('user/profile', $data);
    }
}
