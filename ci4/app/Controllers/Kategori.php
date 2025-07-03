<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KategoriModel;

class Kategori extends ResourceController
{
    use ResponseTrait;

    // GET /kategori
    public function index()
    {
        $model = new KategoriModel();
        $data = $model->orderBy('id_kategori', 'ASC')->findAll();

        return $this->respond(['kategori' => $data], 200);
    }

    // GET /kategori/{id}
    public function show($id = null)
    {
        $model = new KategoriModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data, 200);
        }

        return $this->failNotFound('Kategori tidak ditemukan.');
    }

    // POST /kategori
    public function create()
    {
        $model = new KategoriModel();
        
        $json = $this->request->getJSON();
        
        $data = [
            'nama_kategori' => $json->nama_kategori ?? '',
            'slug_kategori' => url_title($json->nama_kategori ?? '', '-', true),
        ];

        if ($model->insert($data)) {
            return $this->respondCreated([
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Kategori berhasil ditambahkan.'
                ],
                'data' => $data
            ]);
        }

        return $this->fail('Gagal menambahkan kategori.');
    }

    // PUT /kategori/{id}
    public function update($id = null)
    {
        $model = new KategoriModel();
        
        $json = $this->request->getJSON();
        
        $data = [
            'nama_kategori' => $json->nama_kategori ?? '',
            'slug_kategori' => url_title($json->nama_kategori ?? '', '-', true),
        ];

        if ($model->update($id, $data)) {
            return $this->respond([
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Kategori berhasil diupdate.'
                ],
                'data' => $data
            ]);
        }

        return $this->fail('Gagal mengupdate kategori.');
    }

    // DELETE /kategori/{id}
    public function delete($id = null)
    {
        $model = new KategoriModel();
        
        if ($model->delete($id)) {
            return $this->respondDeleted([
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Kategori berhasil dihapus.'
                ]
            ]);
        }

        return $this->fail('Gagal menghapus kategori.');
    }
}
