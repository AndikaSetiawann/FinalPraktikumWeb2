<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    /**
     * Find the next available ID (fills gaps from deleted records)
     */
    private function getNextAvailableId()
    {
        $db = \Config\Database::connect();

        // Get all existing IDs in order
        $query = $db->query("SELECT id FROM artikel ORDER BY id ASC");
        $existingIds = array_column($query->getResultArray(), 'id');

        // Find the first gap in the sequence
        $expectedId = 1;
        foreach ($existingIds as $id) {
            if ($id != $expectedId) {
                // Found a gap, return the missing ID
                return $expectedId;
            }
            $expectedId++;
        }

        // No gaps found, return the next sequential ID
        return $expectedId;
    }

    // GET /post
    public function index()
    {
        $model = new ArtikelModel();
        $data = $model->orderBy('id', 'DESC')->findAll();

        return $this->respond(['artikel' => $data], 200);
    }

    // POST /post
   // POST /post
    public function create()
    {
        $model = new ArtikelModel();

        // Check if this is actually an UPDATE request disguised as POST
        if ($this->request->getPost('_method') === 'PUT') {
            // Extract ID from URL or form data
            $segments = $this->request->getUri()->getSegments();
            $id = end($segments); // Get last segment as ID
            return $this->update($id);
        }

        // Check if request is multipart/form-data (with file upload)
        if ($this->request->getHeaderLine('Content-Type') &&
            strpos($this->request->getHeaderLine('Content-Type'), 'multipart/form-data') !== false) {

            // Handle form data with file upload
            $judul = $this->request->getPost('judul') ?? '';

            // Get the next available ID
            $nextId = $this->getNextAvailableId();

            $data = [
                'id'     => $nextId,  // Set specific ID
                'judul'  => $judul,
                'isi'    => $this->request->getPost('isi') ?? '',
                'status' => $this->request->getPost('status') ?? 0,
                'id_kategori' => $this->request->getPost('id_kategori') ?? null,
                'slug'   => url_title($judul, '-', true),
            ];

            // Handle file upload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->fail('File harus berupa gambar (JPEG, PNG, GIF)');
                }

                // Validate file size (max 2MB)
                if ($file->getSize() > 2048000) {
                    return $this->fail('Ukuran file maksimal 2MB');
                }

                // Generate unique filename
                $fileName = $file->getRandomName();

                // Move file to public/assets/gambar directory
                if ($file->move(FCPATH . 'assets/gambar', $fileName)) {
                    $data['gambar'] = $fileName;
                } else {
                    return $this->fail('Gagal mengupload gambar');
                }
            }

        } else {
            // Handle JSON data (existing functionality)
            $json = $this->request->getJSON();

            // Get the next available ID
            $nextId = $this->getNextAvailableId();

            $data = [
                'id'     => $nextId,  // Set specific ID
                'judul'  => $json->judul ?? '',
                'isi'    => $json->isi ?? '',
                'status' => $json->status ?? 0,
            ];
        }

        // Insert with specific ID using raw query
        $db = \Config\Database::connect();

        // Build insert query with specific ID
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($values) - 1) . '?';

        $sql = "INSERT INTO artikel (" . implode(',', $fields) . ") VALUES (" . $placeholders . ")";

        if ($db->query($sql, $values)) {
            return $this->respondCreated([
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Data artikel berhasil ditambahkan.'
                ],
                'data' => $data
            ]);
        }

        return $this->fail('Gagal menambahkan artikel.');
    }


    // GET /post/{id}
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data, 200);
        }

        return $this->failNotFound('Data tidak ditemukan.');
    }


    public function update($id = null)
    {
        $model = new ArtikelModel();

        // Check if article exists
        $existingArticle = $model->find($id);
        if (!$existingArticle) {
            return $this->failNotFound('Data tidak ditemukan untuk diubah.');
        }

        // Check if request is multipart/form-data (with file upload)
        if ($this->request->getHeaderLine('Content-Type') &&
            strpos($this->request->getHeaderLine('Content-Type'), 'multipart/form-data') !== false) {

            // Handle form data with file upload
            $judul = $this->request->getPost('judul') ?? '';
            $data = [
                'judul'  => $judul,
                'isi'    => $this->request->getPost('isi') ?? '',
                'status' => $this->request->getPost('status') ?? 0,
                'id_kategori' => $this->request->getPost('id_kategori') ?? null,
                'slug'   => url_title($judul, '-', true),
            ];

            // Handle file upload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->fail('File harus berupa gambar (JPEG, PNG, GIF)');
                }

                // Validate file size (max 2MB)
                if ($file->getSize() > 2048000) {
                    return $this->fail('Ukuran file maksimal 2MB');
                }

                // Delete old image if exists
                if (!empty($existingArticle['gambar']) && file_exists(FCPATH . 'assets/gambar/' . $existingArticle['gambar'])) {
                    unlink(FCPATH . 'assets/gambar/' . $existingArticle['gambar']);
                }

                // Generate unique filename
                $fileName = $file->getRandomName();

                // Move file to public/assets/gambar directory
                if ($file->move(FCPATH . 'assets/gambar', $fileName)) {
                    $data['gambar'] = $fileName;
                } else {
                    return $this->fail('Gagal mengupload gambar');
                }
            }

        } else {
            // Handle JSON data (existing functionality)
            $json = $this->request->getJSON();

            $data = [
                'judul'  => $json->judul ?? '',
                'isi'    => $json->isi ?? '',
                'status' => $json->status ?? 0,
            ];
        }

        $model->update($id, $data);
        return $this->respond([
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.'
            ],
            'data' => $data
        ]);
    }


    // DELETE /post/{id}
    public function delete($id = null)
    {
        $model = new ArtikelModel();

        $article = $model->find($id);
        if ($article) {
            // Convert to array if it's an object
            $articleData = is_array($article) ? $article : $article->toArray();

            // Delete associated image file if exists
            if (!empty($articleData['gambar']) && file_exists(FCPATH . 'assets/gambar/' . $articleData['gambar'])) {
                unlink(FCPATH . 'assets/gambar/' . $articleData['gambar']);
            }

            $model->delete($id);
            return $this->respondDeleted([
                'status'  => 200,
                'error'   => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ]);
        }

        return $this->failNotFound('Data tidak ditemukan untuk dihapus.');
    }
}