<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        // Get search parameters
        $search = $this->request->getGet('search') ?? '';
        $kategori_id = $this->request->getGet('kategori') ?? '';

        // Build query
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'LEFT')
            ->where('artikel.status', 1); // Only published articles

        // Apply search filter
        if (!empty($search)) {
            $builder->groupStart()
                ->like('artikel.judul', $search)
                ->orLike('artikel.isi', $search)
                ->groupEnd();
        }

        // Apply category filter
        if (!empty($kategori_id)) {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Get results
        $artikel = $builder->orderBy('artikel.created_at', 'DESC')->findAll();

        // Get all categories for filter
        $kategori = $kategoriModel->findAll();

        $data = [
            'title' => $title,
            'artikel' => $artikel,
            'kategori' => $kategori,
            'search' => $search,
            'kategori_id' => $kategori_id
        ];

        return view('artikel/index', $data);
    }

   public function admin_index()
    {
    $title = 'Daftar Artikel (Admin)';
    $model = new ArtikelModel();
    $q = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page = $this->request->getVar('page') ?? 1;
    $builder = $model->table('artikel')

    ->select('artikel.*, kategori.nama_kategori')

    ->join('kategori', 'kategori.id_kategori =

    artikel.id_kategori');
    if ($q != '') {
    $builder->like('artikel.judul', $q);
    }
    if ($kategori_id != '') {
    $builder->where('artikel.id_kategori', $kategori_id);
    }

    $artikel = $builder->paginate(10, 'default', $page);
    $pager = $model->pager;
    $data = [
    'title' => $title,
    'q' => $q,
    'kategori_id' => $kategori_id,
    'artikel' => $artikel,
    'pager' => $pager
    ];
    if ($this->request->isAJAX()) {
    return $this->response->setJSON($data);
    } else {
    $kategoriModel = new KategoriModel();
    $data['kategori'] = $kategoriModel->findAll();
    return view('artikel/admin_index', $data);
    }
    }

    public function add()
    {
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ])) {
            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();
            $data['title'] = "Tambah Artikel";
            return view('artikel/form_add', $data);
        }
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        if ($this->request->getMethod() == 'post') {
            // Debug: Log semua data yang diterima
            $postData = $this->request->getPost();
            log_message('debug', 'Edit artikel POST data: ' . json_encode($postData));

            // Cek apakah data POST ada
            if (empty($postData)) {
                session()->setFlashdata('error', 'Tidak ada data yang dikirim!');
                return redirect()->back()->withInput();
            }

            $rules = [
                'judul' => 'required|min_length[3]',
                'id_kategori' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                try {
                    $updateData = [
                        'judul' => trim($this->request->getPost('judul')),
                        'isi' => $this->request->getPost('isi') ?? '',
                        'id_kategori' => (int)$this->request->getPost('id_kategori'),
                        'slug' => url_title($this->request->getPost('judul'), '-', true)
                    ];

                    log_message('debug', 'Update data: ' . json_encode($updateData));

                    // Cek apakah artikel dengan ID tersebut ada
                    $existingArtikel = $model->find($id);
                    if (!$existingArtikel) {
                        session()->setFlashdata('error', 'Artikel dengan ID ' . $id . ' tidak ditemukan!');
                        return redirect()->to('/admin/artikel');
                    }

                    $result = $model->update($id, $updateData);

                    log_message('debug', 'Update result: ' . ($result ? 'SUCCESS' : 'FAILED'));

                    if ($result !== false) {
                        session()->setFlashdata('success', 'Artikel berhasil diupdate!');
                        return redirect()->to('/admin/artikel');
                    } else {
                        $errors = $model->errors();
                        $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Unknown error';
                        session()->setFlashdata('error', 'Gagal mengupdate artikel: ' . $errorMsg);
                        log_message('error', 'Model errors: ' . json_encode($errors));
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Exception updating artikel: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Error: ' . $e->getMessage());
                }
            } else {
                // Validation failed
                $validationErrors = $this->validator->getErrors();
                session()->setFlashdata('error', 'Validasi gagal: ' . implode(', ', $validationErrors));
                log_message('debug', 'Validation errors: ' . json_encode($validationErrors));
                return redirect()->back()->withInput();
            }
        }

        // Show form (GET request or POST with errors)
        $data['artikel'] = $model->find($id);
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        $data['title'] = "Edit Artikel";
        $data['validation'] = $this->validator;

        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}
