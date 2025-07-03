## 👤 Profil Mahasiswa

| Atribut         | Keterangan            |
| --------------- | --------------------- |
| *Nama*        | Andika Setiawan       |
| *NIM*         | 312310470             |
| *Kelas*       | TI.23.A.5             |
| *Mata Kuliah* | Pemrograman Website 2 |

## 🌐 Link Aplikasi Live

| Aplikasi            | URL                                                                      | Deskripsi                                 |
| ------------------- | ------------------------------------------------------------------------ | ----------------------------------------- |
| *Web Artikel CI4* | [https://setiawanarticle.my.id/](https://setiawanarticle.my.id/)         | Aplikasi web artikel dengan CodeIgniter 4 |
| *VueJS Frontend*  | [https://setiawanarticle.my.id/vue/](https://setiawanarticle.my.id/vue/) | Frontend VueJS untuk konsumsi REST API    |

## 🔗 Daftar Isi

| No  | Praktikum                                            | Link                                                                 |
| --- | ---------------------------------------------------- | -------------------------------------------------------------------- |
| 7   | Praktikum 7: Relasi Tabel dan Query Builder          | [Klik di sini](#praktikum-7-relasi-tabel-dan-query-builder)          |
| 8   | Praktikum 8: AJAX                                    | [Klik di sini](#praktikum-8-ajax)                                    |
| 9   | Praktikum 9: Implementasi AJAX Pagination dan Search | [Klik di sini](#praktikum-9-implementasi-ajax-pagination-dan-search) |
| 10  | Praktikum 10: REST API                               | [Klik di sini](#praktikum-10-rest-api)                               |
| 11  | Praktikum 11: VueJS - Frontend API                   | [Klik di sini](#praktikum-11-vuejs---frontend-api)                   |

# 📌 Tugas Praktikum 7-11

# Praktikum 7: Relasi Tabel dan Query Builder

## Deskripsi

Praktikum ini merupakan kelanjutan dari praktikum sebelumnya yang berfokus pada implementasi relasi antar tabel dalam database menggunakan CodeIgniter 4. Pada praktikum ini, saya mempelajari cara membuat relasi One-to-Many antara tabel kategori dan artikel, serta menggunakan Query Builder untuk melakukan join tabel.

## Tujuan Praktikum

1. Memahami konsep relasi antar tabel dalam database
2. Mengimplementasikan relasi One-to-Many
3. Melakukan query dengan join tabel menggunakan Query Builder
4. Menampilkan data dari tabel yang berelasi

## Langkah-langkah Praktikum

### 1. Persiapan Database

Memastikan MySQL Server berjalan dan membuka database lab_ci4.

### 2. Membuat Tabel Kategori

Membuat tabel baru bernama kategori dengan struktur:

- id_kategori (INT, PRIMARY KEY, AUTO_INCREMENT)
- nama_kategori (VARCHAR 100)
- slug_kategori (VARCHAR 100)

*Query SQL:*

sql
CREATE TABLE kategori (
    id_kategori INT(11) AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    PRIMARY KEY (id_kategori)
);


*Screenshot:*
![alt text](Gambar/image.png)

### 3. Modifikasi Tabel Artikel

Menambahkan foreign key id_kategori pada tabel artikel untuk membuat relasi dengan tabel kategori.

*Query SQL:*

sql
ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);


*Screenshot:*
![alt text](Gambar/image-1.png)

### 4. Membuat Model Kategori

Membuat file KategoriModel.php di folder app/Models/ untuk mengelola data kategori.

*Kode KategoriModel.php:*

php
<?php
namespace App\Models;
use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];
}


*Screenshot:*
![alt text](Gambar/image-2.png)

### 5. Modifikasi Model Artikel

Memodifikasi ArtikelModel.php dengan menambahkan method getArtikelDenganKategori() untuk melakukan join dengan tabel kategori.

*Kode ArtikelModel.php:*

php
<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar', 'id_kategori'];

    public function getArtikelDenganKategori()
    {
        return $this->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->get()
            ->getResultArray();
    }
}


*Screenshot:*
![alt text](Gambar/image-3.png)

### 6. Modifikasi Controller Artikel

Memperbarui Artikel.php controller untuk:

- Menggunakan method join dari model
- Menambahkan filter berdasarkan kategori
- Menangani kategori pada form tambah dan edit artikel

*Kode Controller Artikel.php:*

php
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
        $artikel = $model->getArtikelDenganKategori(); // Use the new method
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();

        // Get search keyword
        $q = $this->request->getVar('q') ?? '';

        // Get category filter
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
        ];

        // Building the query
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        // Apply search filter if keyword is provided
        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        // Apply category filter if category_id is provided
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Apply pagination
        $data['artikel'] = $builder->paginate(10);
        $data['pager'] = $model->pager;

        // Fetch all categories for the filter dropdown
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        // Validation...
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul' => 'required',
            'id_kategori' => 'required|integer' // Ensure id_kategori is required and an integer
        ])) {
            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll(); // Fetch categories for the form
            $data['title'] = "Tambah Artikel";
            return view('artikel/form_add', $data);
        }
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ])) {
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $data['artikel'] = $model->find($id);
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll(); // Fetch categories for the form
            $data['title'] = "Edit Artikel";
            return view('artikel/form_edit', $data);
        }
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
        }
        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}


*Screenshot:*
![alt text](Gambar/image-4.png)

### 7. Modifikasi View

#### a. index.php (Halaman Depan)

Menampilkan daftar artikel dengan nama kategorinya.

*Kode index.php:*

php
<?= $this->include('template/header'); ?>
<?php if ($artikel): foreach ($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
    <p>Kategori: <?= $row['nama_kategori'] ?></p>
    <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>">
    <p><?= substr($row['isi'], 0, 200); ?></p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>
<?= $this->include('template/footer'); ?>


#### b. admin_index.php (Halaman Admin)

Menambahkan:

- Filter berdasarkan kategori
- Kolom kategori pada tabel
- Dropdown untuk memfilter artikel

*Kode admin_index.php:*

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<div class="row mb-3">
    <div class="col-md-6">
        <form method="get" class="form-inline">
            <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari judul artikel" class="form-control mr-2">
            <select name="kategori_id" class="form-control mr-2">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Cari" class="btn btn-primary">
        </form>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($artikel) > 0): ?>
        <?php foreach ($artikel as $row): ?>
        <tr>
            <td><?= $row->id; ?></td>
            <td>
                <b><?= $row->judul; ?></b>
                <p><small><?= substr($row->isi, 0, 50); ?></small></p>
            </td>
            <td><?= $row->nama_kategori; ?></td>
            <td><?= $row->status; ?></td>
            <td>
                <a class="btn btn-sm btn-info" href="<?= base_url('/admin/artikel/edit/' . $row->id); ?>">Ubah</a>
                <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row->id); ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="5">Tidak ada data.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $pager->only(['q', 'kategori_id'])->links(); ?>
<?= $this->include('template/admin_footer'); ?>


*Screenshot:*
![alt text](Gambar/image-5.png)

#### c. form_add.php (Form Tambah Artikel)

Menambahkan dropdown untuk memilih kategori saat menambah artikel baru.

*Kode form_add.php:*

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<form action="" method="post">
    <p>
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" required>
    </p>
    <p>
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" cols="50" rows="10"></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" required>
            <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p><input type="submit" value="Kirim" class="btn btn-large"></p>
</form>
<?= $this->include('template/admin_footer'); ?>


*Screenshot:*
![alt text](Gambar/image-6.png)

#### d. form_edit.php (Form Edit Artikel)

Menambahkan dropdown kategori dengan nilai yang sudah terpilih sesuai data artikel.

*Kode form_edit.php:*

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<form action="" method="post">
    <p>
        <label for="judul">Judul</label>
        <input type="text" name="judul" value="<?= $artikel['judul']; ?>" id="judul" required>
    </p>
    <p>
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" cols="50" rows="10"><?= $artikel['isi']; ?></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" required>
            <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id_kategori']; ?>" <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p><input type="submit" value="Kirim" class="btn btn-large"></p>
</form>
<?= $this->include('template/admin_footer'); ?>


*Screenshot:*
![alt text](Gambar/image-7.png)

### 8. Testing Fungsionalitas

#### a. Menampilkan Artikel dengan Kategori

*Screenshot:*
![alt text](Gambar/image-8.png)

#### b. Menambah Artikel dengan Kategori

*Screenshot:*
![alt text](Gambar/image-10.png)
![alt text](Gambar/image-11.png)

#### c. Filter Artikel Berdasarkan Kategori

*Screenshot:*
![alt text](Gambar/image-9.png)

#### d. Edit Artikel dan Mengubah Kategori

*Screenshot:*
![alt text](Gambar/image-12.png)
![alt text](Gambar/image-13.png)

## Tugas Tambahan

### 1. Modifikasi Detail Artikel

Memodifikasi tampilan detail artikel untuk menampilkan nama kategori.

*Screenshot:*
![alt text](Gambar/image-14.png)

### 2. Daftar Kategori di Halaman Depan (Opsional)

Menambahkan fitur untuk menampilkan daftar kategori di halaman depan.

*Screenshot:*
![alt text](Gambar/image-15.png)

### 3. Artikel Berdasarkan Kategori (Opsional)

Membuat fungsi untuk menampilkan artikel berdasarkan kategori tertentu.

*Screenshot:*
![alt text](Gambar/image-16.png)

## Konsep yang Dipelajari

### 1. Relasi Database

- *One-to-Many Relationship*: Satu kategori dapat memiliki banyak artikel
- *Foreign Key*: Menghubungkan tabel artikel dengan tabel kategori
- *Join Query*: Menggabungkan data dari dua tabel atau lebih

### 2. Query Builder CodeIgniter 4

- *Select dengan Join*: Mengambil data dari multiple tabel
- *Where Clause*: Memfilter data berdasarkan kondisi tertentu
- *Like Query*: Pencarian berdasarkan pattern matching
- *Pagination*: Membagi data menjadi beberapa halaman

### 3. MVC Pattern

- *Model*: Mengelola interaksi dengan database
- *View*: Menampilkan data kepada user
- *Controller*: Mengatur alur logika aplikasi

## Struktur File


app/
├── Controllers/
│   └── Artikel.php
├── Models/
│   ├── ArtikelModel.php
│   └── KategoriModel.php
└── Views/
    └── artikel/
        ├── index.php
        ├── admin_index.php
        ├── form_add.php
        ├── form_edit.php
        └── detail.php


## Kesimpulan

Praktikum ini berhasil mengimplementasikan relasi One-to-Many antara tabel kategori dan artikel. Dengan menggunakan Query Builder CodeIgniter 4, saya dapat melakukan join tabel dengan mudah dan aman. Fitur-fitur yang berhasil diimplementasikan meliputi:

1. ✅ Relasi antar tabel menggunakan foreign key
2. ✅ Join query untuk menampilkan data dari multiple tabel
3. ✅ Filter dan pencarian artikel berdasarkan kategori
4. ✅ Form input yang terintegrasi dengan data kategori
5. ✅ Pagination dengan filter

Praktikum ini memberikan pemahaman yang lebih dalam tentang cara kerja database relational dan penggunaan Query Builder dalam framework CodeIgniter 4.

# Praktikum 8: AJAX

## Deskripsi

Praktikum ini bertujuan untuk mengimplementasikan AJAX pada aplikasi web menggunakan CodeIgniter 4. AJAX digunakan untuk memperbarui data pada halaman tanpa perlu me-reload seluruh halaman.

## Tujuan Praktikum

1.  Memahami konsep AJAX dan cara kerjanya.
2.  Mampu mengimplementasikan AJAX pada aplikasi web dengan CodeIgniter 4.
3.  Melatih kemampuan problem solving dan debugging.

## Langkah-langkah Praktikum

### 1. Persiapan

- Memastikan jQuery sudah diunduh dan disimpan di folder public/assets/js.

### 2. Membuat Controller

- Membuat AjaxController dengan method index, getData, store, dan update.

*Kode AjaxController.php:*

php
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        return view('ajax/index');
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->findAll();

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function store()
    {
        // Proses penyimpanan data (ganti dengan logika penyimpanan data ke database)
        $data = [
            'status' => 'Data berhasil disimpan'
        ];
        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        // Proses update data (ganti dengan logika update data di database)
        $data = [
            'status' => 'Data berhasil diupdate'
        ];
        return $this->response->setJSON($data);
    }
}


*Screenshot:*
![alt text](Gambar/image-17.png)

### 3. Membuat View

- Membuat view ajax/index.php yang menampilkan data artikel dalam tabel dan menggunakan AJAX untuk mengambil data.

*Kode index.php:*

php
<?= $this->include('template/header'); ?>

<h1>Data Artikel</h1>

<table class="table-data" id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        // Function to display a loading message while data is fetched
        function showLoadingMessage() {
            $('#artikelTable  tbody').html('<tr><td  colspan="4">Loading data...</td></tr>');
        }

        // Buat fungsi load data
        function loadData() {
            showLoadingMessage(); // Display loading message initially

            // Lakukan request AJAX ke URL getData
            $.ajax({
                url: "<?= base_url('ajax/getData') ?>",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Tampilkan data yang diterima dari server
                    var tableBody = "";
                    for (var i = 0; i < data.length; i++) {
                        var row = data[i];
                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        // Add a placeholder for the "Status" column (modify as needed)
                        tableBody  += '<td><span  class="status">---</span></td>';
                        tableBody += '<td>';
                        // Replace with your desired actions (e.g., edit, delete)
                        tableBody += '<a href="<?= base_url('artikel/edit/') ?>' + row.id + '" class="btn btn-primary">Edit</a>';
                        tableBody += ' <a href="#" class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    }
                    $('#artikelTable tbody').html(tableBody);
                }
            });
        }

        loadData();

        // Implement actions for buttons (e.g., delete confirmation)
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // Add confirmation dialog or handle deletion logic here

            // hapus data;
            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                $.ajax({
                    url: "<?= base_url('artikel/delete/') ?>" + id,
                    method: "DELETE",
                    success: function(data) {
                        loadData();  // Reload Datatables to reflect changes
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting article: ' + textStatus + errorThrown);
                    }
                });
            }
            console.log('Delete button clicked for ID:', id);
        });
    });
</script>

<?= $this->include('template/footer'); ?>


*Screenshot:*
![alt text](Gambar/image-18.png)

### 4. Menambahkan Route

- Menambahkan route untuk mengakses method di AjaxController.

*Kode Routes.php:*

php
// Route untuk AjaxController
$routes->get('/ajax', 'AjaxController::index');
$routes->get('/ajax/getData', 'AjaxController::getData');
$routes->get('/ajax/delete/(:num)', 'AjaxController::delete/$1');
$routes->post('/ajax/store', 'AjaxController::store');
$routes->post('/ajax/update/(:num)', 'AjaxController::update/$1');


*Screenshot:*
![alt text](Gambar/image-19.png)

## Konsep yang Dipelajari

- AJAX (Asynchronous JavaScript and XML)
- Penggunaan jQuery untuk mempermudah implementasi AJAX
- Pengiriman dan penerimaan data dalam format JSON
- Pembuatan controller dan view untuk menangani request AJAX

## Struktur File


app/
├── Controllers/
│   └── AjaxController.php
└── Views/
    └── ajax/
        └── index.php


# Praktikum 9: Implementasi AJAX Pagination dan Search

## Deskripsi

Praktikum ini bertujuan untuk mengimplementasikan AJAX pada fitur pagination dan search di halaman admin artikel. Dengan menggunakan AJAX, halaman tidak perlu di-reload sepenuhnya ketika melakukan pencarian, filter kategori, atau navigasi pagination, sehingga meningkatkan User Experience (UX) aplikasi web.

## Tujuan Praktikum

1. Mahasiswa mampu memahami konsep dasar AJAX untuk pagination dan search
2. Mahasiswa mampu mengimplementasikan pagination dan search menggunakan AJAX dalam CodeIgniter 4
3. Mahasiswa mampu meningkatkan performa dan User Experience (UX) aplikasi web

## Langkah-langkah Praktikum

### 1. Persiapan

- ✅ MySQL Server sudah berjalan
- ✅ Database lab_ci4 sudah tersedia
- ✅ Tabel artikel dan kategori sudah ada dan terisi data
- ✅ Library jQuery sudah terpasang melalui CDN

### 2. Modifikasi Controller Artikel

Mengubah method admin_index() di Artikel.php untuk mengembalikan data dalam format JSON jika request adalah AJAX.

*Kode Controller yang dimodifikasi:*

php
// Halaman Admin - List Artikel dengan Pagination dan Pencarian
public function admin_index()
{
    $title = 'Daftar Artikel (Admin)';
    $model = new ArtikelModel();
    $q = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page = $this->request->getVar('page') ?? 1;

    $builder = $model->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

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


*Penjelasan kode:*

- $page = $this->request->getVar('page') ?? 1;: Mendapatkan nomor halaman dari request
- $builder->paginate(10, 'default', $page);: Menerapkan pagination dengan 10 item per halaman
- $this->request->isAJAX(): Memeriksa apakah request yang datang adalah AJAX
- Jika AJAX, kembalikan data artikel dan pager dalam format JSON
- Jika bukan AJAX, tampilkan view seperti biasa

*Screenshot:*
![alt text](Gambar/image-20.png)

### 3. Modifikasi View (admin_index.php)

Mengubah view admin_index.php untuk menggunakan jQuery AJAX. Menghapus kode yang menampilkan tabel artikel dan pagination secara langsung, kemudian menambahkan elemen container untuk menampilkan data dari AJAX.

*Kode View yang dimodifikasi:*

php
<?= $this->include('template/admin_header'); ?>
<h2><?= $title; ?></h2>
<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="form-inline">
            <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul artikel" class="form-control mr-2">
            <select name="kategori_id" id="category-filter" class="form-control mr-2">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Cari" class="btn btn-primary">
        </form>
    </div>
</div>
<div id="article-container">
</div>
<div id="pagination-container">
</div>


*Implementasi jQuery AJAX:*

javascript
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    const fetchData = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                renderArticles(data.artikel);
                if (data.pager && data.pager.links) {
                    renderPagination(data.pager, data.q, data.kategori_id);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                articleContainer.html('<div class="alert alert-danger">Error loading data: ' + error + '</div>');
            }
        });
    };

    const renderArticles = (articles) => {
        let html = '<table class="table">';
        html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>';

        if (articles && articles.length > 0) {
            articles.forEach(article => {
                const isi = article.isi || '';
                const isiPreview = isi.length > 50 ? isi.substring(0, 50) + '...' : isi;
                html += `
            <tr>
                <td>${article.id}</td>
                <td>
                    <b>${article.judul}</b>
                    <p><small>${isiPreview}</small></p>
                </td>
                <td>${article.nama_kategori || 'Tidak ada kategori'}</td>
                <td>${article.tanggal || '-'}</td>
                <td>
                    <a class="btn btn-sm btn-info" href="<?= base_url(); ?>/admin/artikel/edit/${article.id}">Ubah</a>
                    <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url(); ?>/admin/artikel/delete/${article.id}">Hapus</a>
                </td>
            </tr>
            `;
            });
        } else {
            html += '<tr><td colspan="5">Tidak ada data.</td></tr>';
        }
        html += '</tbody></table>';
        articleContainer.html(html);
    };

    const renderPagination = (pager, q, kategori_id) => {
        let html = '<nav><ul class="pagination">';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
            html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}" data-url="${url}">${link.title}</a></li>`;
        });
        html += '</ul></nav>';
        paginationContainer.html(html);

        // Add click event for pagination links
        paginationContainer.find('.page-link').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url && url !== '#') {
                fetchData(url);
            }
        });
    };

    searchForm.on('submit', function(e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`<?= base_url(); ?>/admin/artikel?q=${q}&kategori_id=${kategori_id}`);
    });

    categoryFilter.on('change', function() {
        searchForm.trigger('submit');
    });

    // Initial load
    fetchData('<?= base_url(); ?>/admin/artikel');
});
</script>
<?= $this->include('template/admin_footer'); ?>


*Screenshot:*
![alt text](Gambar/image-21.png)

### 4. Testing dan Verifikasi

Untuk memudahkan testing, dibuat route khusus tanpa authentication:

*Route Testing:*

php
// Test route untuk AJAX (tanpa auth untuk testing)
$routes->get('test/artikel', 'Artikel::test_admin_index');


*Method Testing di Controller:*

php
public function test_admin_index()
{
    // Same implementation as admin_index() but returns test view
    // ... (kode sama dengan admin_index)

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    } else {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('artikel/test_admin_index', $data);
    }
}


*Sample Data Seeder:*
Dibuat seeder untuk menambahkan data sample artikel dan kategori:

php
class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Insert sample categories
        $kategoriData = [
            ['nama_kategori' => 'Teknologi', 'slug_kategori' => 'teknologi'],
            ['nama_kategori' => 'Olahraga', 'slug_kategori' => 'olahraga'],
            ['nama_kategori' => 'Pendidikan', 'slug_kategori' => 'pendidikan']
        ];
        $this->db->table('kategori')->insertBatch($kategoriData);

        // Insert sample articles
        $artikelData = [
            [
                'judul' => 'Perkembangan AI di Indonesia',
                'isi' => 'Artificial Intelligence atau kecerdasan buatan semakin berkembang pesat...',
                'slug' => 'perkembangan-ai-di-indonesia',
                'id_kategori' => 1,
                'gambar' => 'ai.jpg',
                'tanggal' => date('Y-m-d H:i:s')
            ],
            // ... data artikel lainnya
        ];
        $this->db->table('artikel')->insertBatch($artikelData);
    }
}


## Fitur yang Berhasil Diimplementasikan

### 1. AJAX Loading

- ✅ Data artikel dimuat secara asinkron tanpa refresh halaman
- ✅ Loading indicator dan error handling

### 2. Live Search

- ✅ Pencarian artikel berdasarkan judul secara real-time
- ✅ Search dilakukan saat user mengetik atau menekan tombol cari

### 3. Filter Kategori

- ✅ Filter artikel berdasarkan kategori dengan dropdown
- ✅ Filter otomatis dijalankan saat kategori dipilih

### 4. Pagination dengan AJAX

- ✅ Navigasi halaman tanpa reload
- ✅ Pagination links yang responsive
- ✅ Mempertahankan parameter search dan filter saat navigasi

### 5. Error Handling

- ✅ Menampilkan pesan error jika request AJAX gagal
- ✅ Console logging untuk debugging

## URL Testing

- *Halaman Test AJAX*: http://localhost:8080/test/artikel
- *Halaman Admin (dengan auth)*: http://localhost:8080/admin/artikel

## Kesimpulan

Praktikum 9 berhasil mengimplementasikan AJAX untuk pagination dan search pada halaman admin artikel. Implementasi ini meningkatkan User Experience (UX) dengan:

1. *Performa yang lebih baik*: Tidak perlu reload seluruh halaman
2. *Interaksi yang lebih smooth*: Real-time search dan filter
3. *Navigasi yang responsif*: Pagination tanpa loading ulang
4. *Error handling yang baik*: Menampilkan pesan error yang informatif

Teknologi yang digunakan:

- *CodeIgniter 4*: Framework PHP untuk backend
- *jQuery 3.6.0*: Library JavaScript untuk AJAX
- *Bootstrap*: Framework CSS untuk styling
- *MySQL*: Database untuk menyimpan data

# Praktikum 10: REST API

## Deskripsi

Praktikum ini bertujuan untuk memahami konsep dasar API dan RESTful, serta mengimplementasikan REST API menggunakan CodeIgniter 4. REST API memungkinkan aplikasi untuk berkomunikasi dengan aplikasi lain melalui HTTP request dengan format data JSON.

## Tujuan Praktikum

1. Mahasiswa mampu memahami konsep dasar API
2. Mahasiswa mampu memahami konsep dasar RESTful
3. Mahasiswa mampu membuat API menggunakan Framework CodeIgniter 4

## Apa itu REST API?

*Representational State Transfer (REST)* adalah salah satu desain arsitektur Application Programming Interface (API). API sendiri merupakan interface yang menjadi perantara yang menghubungkan satu aplikasi dengan aplikasi lainnya.

REST API berisi aturan untuk membuat web service dengan membatasi hak akses client yang mengakses API. REST API bisa diakses atau dihubungkan dengan aplikasi lain, oleh sebab itu pembatasan dilakukan untuk melindungi database/resource yang ada di server.

### Cara Kerja REST API

REST API menggunakan prinsip *REST Server* dan *REST Client*:

- *REST Server*: Bertindak sebagai penyedia data/resource
- *REST Client*: Membuat HTTP request pada server dengan URI atau global ID
- *Response*: Server memberikan response dengan mengirim kembali HTTP request yang diminta client

Data yang dikirim maupun diterima biasanya berformat *JSON*, sehingga REST API mudah diintegrasikan dengan berbagai platform dengan bahasa pemrograman atau framework yang berbeda.

## Langkah-langkah Praktikum

### 1. Persiapan

- ✅ Text editor (VSCode) sudah siap
- ✅ Folder proyek lab7_php_ci sudah dibuka
- ✅ Postman sudah didownload untuk testing REST API
- ✅ ArtikelModel sudah tersedia dari praktikum sebelumnya

### 2. Membuat REST Controller

Membuat file REST Controller yang berisi fungsi untuk menampilkan, menambah, mengubah dan menghapus data.

**File: app/Controllers/Post.php**

php
<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // all users
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // create
    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
        ];
        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    // single user
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // update
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $id = $this->request->getVar('id');
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
        ];
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }

    // delete
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}


*Penjelasan Method:*

- index() – Menampilkan seluruh data pada database
- create() – Menambahkan data baru ke database
- show() – Menampilkan data spesifik dari database
- update() – Mengubah data pada database
- delete() – Menghapus data dari database

*Screenshot:*
![alt text](Gambar/image-23.png)

### 3. Membuat Routing REST API

Untuk mengakses REST API CodeIgniter, perlu mendefinisikan route terlebih dahulu.

**File: app/Config/Routes.php**

php
// REST API routes
$routes->resource('post');


*Testing Route dengan Command:*

bash
php spark routes


*Hasil Route yang Terbentuk:*


+--------+-------------------------------+------+--------------------------------------------+
| Method | Route                         | Name | Handler                                    |
+--------+-------------------------------+------+--------------------------------------------+
| GET    | post                          | »    | \App\Controllers\Post::index               |
| GET    | post/new                      | »    | \App\Controllers\Post::new                 |
| GET    | post/(.*)/edit                | »    | \App\Controllers\Post::edit/$1             |
| GET    | post/(.*)                     | »    | \App\Controllers\Post::show/$1             |
| POST   | post                          | »    | \App\Controllers\Post::create              |
| PATCH  | post/(.*)                     | »    | \App\Controllers\Post::update/$1           |
| PUT    | post/(.*)                     | »    | \App\Controllers\Post::update/$1           |
| DELETE | post/(.*)                     | »    | \App\Controllers\Post::delete/$1           |
+--------+-------------------------------+------+--------------------------------------------+


Satu baris kode routes akan menghasilkan banyak endpoint untuk operasi CRUD.

### 4. Testing REST API dengan Postman

#### 4.1 Menampilkan Semua Data (GET)

*Method:* GET
*URL:* http://localhost:8080/post
*Deskripsi:* Menampilkan semua data artikel dari database

*Screenshot:*
![alt text](Gambar/image-24.png)

#### 4.2 Menampilkan Data Spesifik (GET)

*Method:* GET
*URL:* http://localhost:8080/post/2
*Deskripsi:* Menampilkan data artikel dengan ID tertentu

*Screenshot:*
![alt text](Gambar/image-25.png)

#### 4.3 Menambahkan Data (POST)

*Method:* POST
*URL:* http://localhost:8080/post
*Body Type:* x-www-form-urlencoded
*Parameters:*

- judul: Judul artikel baru
- isi: Isi artikel baru

*Screenshot:*
![alt text](Gambar/image-26.png)

#### 4.4 Mengubah Data (PUT)

*Method:* PUT
*URL:* http://localhost:8080/post/2
*Body Type:* x-www-form-urlencoded
*Parameters:*

- judul: Judul artikel yang baru
- isi: Isi artikel yang baru

*Screenshot:*
![alt text](Gambar/image-28.png)

#### 4.5 Menghapus Data (DELETE)

*Method:* DELETE
*URL:* http://localhost:8080/post/7
*Deskripsi:* Menghapus data artikel dengan ID tertentu

*Screenshot:*
![alt text](Gambar/image-27.png)

## Endpoint REST API yang Tersedia

| Method | Endpoint     | Fungsi                       | Parameter  |
| ------ | ------------ | ---------------------------- | ---------- |
| GET    | /post      | Menampilkan semua artikel    | -          |
| GET    | /post/{id} | Menampilkan artikel spesifik | id         |
| POST   | /post      | Menambah artikel baru        | judul, isi |
| PUT    | /post/{id} | Mengubah artikel             | judul, isi |
| DELETE | /post/{id} | Menghapus artikel            | id         |

## Fitur REST API yang Berhasil Diimplementasikan

### 1. CRUD Operations

- ✅ *Create*: Menambah data artikel baru
- ✅ *Read*: Menampilkan semua data dan data spesifik
- ✅ *Update*: Mengubah data artikel yang sudah ada
- ✅ *Delete*: Menghapus data artikel

### 2. HTTP Methods

- ✅ *GET*: Untuk mengambil data
- ✅ *POST*: Untuk menambah data baru
- ✅ *PUT*: Untuk mengubah data
- ✅ *DELETE*: Untuk menghapus data

### 3. Response Format

- ✅ *JSON Format*: Semua response dalam format JSON
- ✅ *Status Code*: HTTP status code yang sesuai (200, 201, 404)
- ✅ *Error Handling*: Pesan error yang informatif

### 4. RESTful Principles

- ✅ *Resource-based URLs*: Menggunakan /post sebagai resource
- ✅ *HTTP Methods*: Menggunakan method HTTP yang sesuai
- ✅ *Stateless*: Setiap request berdiri sendiri
- ✅ *JSON Communication*: Format data JSON untuk request/response

## Kesimpulan

Praktikum 10 berhasil mengimplementasikan REST API menggunakan CodeIgniter 4 dengan fitur lengkap CRUD operations. Implementasi ini memungkinkan:

1. *Integrasi Mudah*: API dapat diakses dari berbagai platform dan bahasa pemrograman
2. *Standar RESTful*: Mengikuti prinsip-prinsip REST API yang standar
3. *Format JSON*: Data exchange menggunakan format JSON yang universal
4. *Error Handling*: Penanganan error yang baik dengan status code yang sesuai
5. *Scalable*: Mudah dikembangkan untuk menambah endpoint baru

*Teknologi yang digunakan:*

- *CodeIgniter 4*: Framework PHP untuk backend API
- *ResourceController*: Base controller untuk REST API
- *ResponseTrait*: Trait untuk response handling
- *ArtikelModel*: Model untuk database operations
- *Postman*: Tool untuk testing REST API

*Screenshot Testing Lengkap:*
![alt text](Gambar/image-32.png)

## Perbaikan dan Optimasi

### 1. Fix PUT Method Error 500

*Masalah:* Konflik parameter $id di method update()
*Solusi:* Menghapus $id = $this->request->getVar('id'); karena ID sudah diambil dari URL parameter

### 2. Fix Artikel Detail Redirect

*Masalah:* Artikel yang ditambah via API tidak bisa dibuka detail karena tidak ada slug
*Solusi:* Menambahkan auto-generate slug dan tanggal di method create() dan update()

php
// Perbaikan di method create() dan update()
$judul = $this->request->getVar('judul');
$data = [
    'judul' => $judul,
    'isi' => $this->request->getVar('isi'),
    'slug' => url_title($judul, '-', true),  // Auto-generate slug
    'tanggal' => date('Y-m-d H:i:s')         // Auto-generate timestamp
];


### 3. Cara Testing PUT yang Benar

- *Method:* PUT
- *URL:* http://localhost:8080/post/2
- *Body:* x-www-form-urlencoded
- *Parameters:* Hanya judul dan isi (ID diambil dari URL)

Sekarang semua endpoint REST API sudah berfungsi dengan baik! 🚀

# Praktikum 11: VueJS - Frontend API

## Deskripsi

Praktikum ini bertujuan untuk memahami konsep dasar Framework VueJS dan mengimplementasikan frontend untuk mengkonsumsi REST API yang telah dibuat pada Praktikum 10. VueJS digunakan untuk membuat aplikasi web yang interaktif dengan fitur CRUD (Create, Read, Update, Delete) yang terhubung dengan backend API.

## Tujuan Praktikum

1. Mahasiswa mampu memahami konsep dasar API
2. Mahasiswa mampu memahami konsep dasar Framework VueJS
3. Mahasiswa mampu membuat Frontend API menggunakan Framework VueJS 3

## Apa itu VueJS?

VueJS merupakan sebuah framework JavaScript untuk membangun aplikasi web atau tampilan interface website agar lebih interaktif. VueJS dapat digunakan untuk membangun aplikasi berbasis user interface, seperti halaman web, aplikasi mobile, dan aplikasi desktop.

Framework ini juga menawarkan berbagai fitur, seperti reactive data binding, component-based architecture, dan tools untuk membangun aplikasi skalabel. Fitur utamanya adalah rendering dan komposisi elemen, sehingga bila pengguna hendak membuat aplikasi yang lebih kompleks akan membutuhkan routing, state management, template, build-tool, dan lain sebagainya.

Adapun library VueJS berfokus pada view layer sehingga framework ini mudah untuk diimplementasikan dan diintegrasikan dengan library lain. Selain itu, VueJS juga terkenal mudah digunakan karena memiliki sintaksis yang sederhana dan intuitif, memungkinkan pengembang untuk membangun aplikasi web dengan mudah.

## Langkah-langkah Praktikum

### 1. Persiapan

Untuk memulai penggunaan framework VueJS, dapat dilakukan dengan menggunakan npm, atau bisa juga dengan cara manual. Untuk praktikum kali ini kita akan gunakan cara manual menggunakan CDN.

*Library yang diperlukan:*

- *VueJS 3*: <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
- *Axios*: <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

### 2. Struktur Direktori

Membuat project baru dengan struktur file dan directory sebagai berikut:


lab8_vuejs/
│   index.html
└───assets/
    ├───css/
    │   style.css
    └───js/
        app.js


*Screenshot:*

### 3. Membuat File HTML Dasar

**File: index.html**

html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Frontend Vuejs</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <div id="app">
      <h1>Daftar Artikel</h1>
      <button id="btn-tambah" @click="tambah">Tambah Data</button>

      <div class="modal" v-if="showForm">
        <div class="modal-content">
          <span class="close" @click="showForm = false">&times;</span>
          <form id="form-data" @submit.prevent="saveData">
            <h3 id="form-title">{{ formTitle }}</h3>

            <div><input type="text" name="judul" id="judul" v-model="formData.judul" placeholder="Judul" required /></div>

            <div><textarea name="isi" id="isi" rows="10" v-model="formData.isi"></textarea></div>

            <div>
              <select name="status" id="status" v-model="formData.status">
                <option v-for="option in statusOptions" :value="option.value">{{ option.text }}</option>
              </select>
            </div>
            <input type="hidden" id="id" v-model="formData.id" />
            <button type="submit" id="btnSimpan">Simpan</button>
            <button @click="showForm = false">Batal</button>
          </form>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in artikel">
            <td class="center-text">{{ row.id }}</td>
            <td>{{ row.judul }}</td>
            <td>{{ statusText(row.status) }}</td>
            <td class="center-text">
              <a href="#" @click="edit(row)">Edit</a>
              <a href="#" @click="hapus(index, row.id)">Hapus</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <script src="assets/js/app.js"></script>
  </body>
</html>


*Screenshot:*
![alt text](Gambar/image-29.png)

### 4. Membuat File JavaScript (app.js)

**File: assets/js/app.js**

javascript
const { createApp } = Vue;

// tentukan lokasi API REST End Point
const apiUrl = 'http://localhost:8080';

createApp({
  data() {
    return {
      artikel: '',
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      },
      showForm: false,
      formTitle: 'Tambah Data',
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 },
      ],
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      axios
        .get(apiUrl + '/post')
        .then((response) => {
          this.artikel = response.data.artikel;
        })
        .catch((error) => console.log(error));
    },
    tambah() {
      this.showForm = true;
      this.formTitle = 'Tambah Data';
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      };
    },
    hapus(index, id) {
      if (confirm('Yakin menghapus data?')) {
        axios
          .delete(apiUrl + '/post/' + id)
          .then((response) => {
            this.artikel.splice(index, 1);
          })
          .catch((error) => console.log(error));
      }
    },
    edit(data) {
      this.showForm = true;
      this.formTitle = 'Ubah Data';
      this.formData = {
        id: data.id,
        judul: data.judul,
        isi: data.isi,
        status: data.status,
      };
      console.log(data);
      console.log(this.formData);
    },
    saveData() {
      if (this.formData.id) {
        axios
          .put(apiUrl + '/post/' + this.formData.id, this.formData)
          .then((response) => {
            this.loadData();
          })
          .catch((error) => console.log(error));
        console.log('Update item:', this.formData);
      } else {
        axios
          .post(apiUrl + '/post', this.formData)
          .then((response) => {
            this.loadData();
          })
          .catch((error) => console.log(error));
        console.log('Tambah item:', this.formData);
      }
      // Reset form data
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      };
      this.showForm = false;
    },
    statusText(status) {
      if (!status) return '';
      return status == 1 ? 'Publish' : 'Draft';
    },
  },
}).mount('#app');


*Screenshot:*
![alt text](Gambar/image-30.png)

### 5. Membuat File CSS (style.css)

**File: assets/css/style.css**

css
#app {
  margin: 0 auto;
  width: 900px;
}

table {
  min-width: 700px;
  width: 100%;
}

th {
  padding: 10px;
  background: #5778ff !important;
  color: #ffffff;
}

tr td {
  border-bottom: 1px solid #eff1ff;
}

tr:nth-child(odd) {
  background-color: #eff1ff;
}

td {
  padding: 10px;
}

.center-text {
  text-align: center;
}

td a {
  margin: 5px;
}

#form-data {
  width: 600px;
}

form input {
  width: 100%;
  margin-bottom: 5px;
  padding: 5px;
  box-sizing: border-box;
}

form select {
  margin-bottom: 5px;
  padding: 5px;
  box-sizing: border-box;
}

form textarea {
  width: 100%;
  margin-bottom: 5px;
  padding: 5px;
  box-sizing: border-box;
}

form div {
  margin-bottom: 5px;
  position: relative;
}

form button {
  padding: 10px 20px;
  margin-top: 10px;
  margin-bottom: 10px;
  margin-right: 10px;
  cursor: pointer;
}

#btn-tambah {
  margin-bottom: 15px;
  padding: 10px 20px;
  cursor: pointer;
  background-color: #3152d6;
  color: #ffffff;
  border: 1px solid #3152d6;
}

#btnSimpan {
  background-color: #3152d6;
  color: #ffffff;
  border: 1px solid #3152d6;
}

.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 600px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}


*Screenshot:*
![alt text](Gambar/image-31.png)

### 6. Testing Aplikasi VueJS

#### 6.1 Menampilkan Data Artikel

Aplikasi akan secara otomatis memuat data artikel dari REST API saat halaman dibuka.

*URL Testing:* http://localhost/Lab11Web-master/lab8_vuejs/index.html

*Screenshot:*
![alt text](Gambar/image-32.png)

#### 6.2 Menambah Data Artikel

1. Klik tombol "Tambah Data"
2. Isi form dengan data artikel baru
3. Klik "Simpan"

*Screenshot:*
![alt text](Gambar/image-33.png)

#### 6.3 Mengedit Data Artikel

1. Klik link "Edit" pada artikel yang ingin diubah
2. Form akan terbuka dengan data yang sudah terisi
3. Ubah data sesuai kebutuhan
4. Klik "Simpan"

*Screenshot:*
![alt text](Gambar/image-34.png)

#### 6.4 Menghapus Data Artikel

1. Klik link "Hapus" pada artikel yang ingin dihapus
2. Konfirmasi penghapusan
3. Data akan terhapus dari tabel

*Screenshot:*
![alt text](Gambar/image-35.png)

## Fitur yang Berhasil Diimplementasikan

### 1. CRUD Operations dengan VueJS

- ✅ *Create*: Menambah artikel baru melalui form modal
- ✅ *Read*: Menampilkan daftar artikel dari REST API
- ✅ *Update*: Mengedit artikel yang sudah ada
- ✅ *Delete*: Menghapus artikel dengan konfirmasi

### 2. Reactive Data Binding

- ✅ *Two-way Data Binding*: Form input terhubung dengan data VueJS
- ✅ *Dynamic Content*: Tabel artikel diperbarui secara otomatis
- ✅ *Conditional Rendering*: Modal form muncul/hilang berdasarkan kondisi

### 3. Event Handling

- ✅ *Click Events*: Tombol tambah, edit, hapus, dan simpan
- ✅ *Form Submission*: Prevent default dan custom handling
- ✅ *Modal Control*: Buka/tutup modal form

### 4. API Integration

- ✅ *Axios HTTP Client*: Untuk komunikasi dengan REST API
- ✅ *GET Request*: Mengambil data artikel
- ✅ *POST Request*: Menambah artikel baru
- ✅ *PUT Request*: Mengubah artikel yang ada
- ✅ *DELETE Request*: Menghapus artikel

### 5. User Interface

- ✅ *Responsive Design*: Tampilan yang menarik dan user-friendly
- ✅ *Modal Dialog*: Form input dalam modal popup
- ✅ *Status Display*: Menampilkan status artikel (Draft/Publish)
- ✅ *Loading States*: Handling loading dan error states

## Konsep VueJS yang Dipelajari

### 1. Vue Instance dan Mounting

javascript
const { createApp } = Vue;
createApp({
  // Vue instance configuration
}).mount('#app');


### 2. Data Properties

javascript
data() {
    return {
        artikel: '',
        formData: { /* form data object */ },
        showForm: false
    }
}


### 3. Methods

javascript
methods: {
    loadData() { /* method implementation */ },
    tambah() { /* method implementation */ },
    // ... other methods
}


### 4. Lifecycle Hooks

javascript
mounted() {
    this.loadData() // Called when component is mounted
}


### 5. Template Directives

- v-for: Looping data dalam template
- v-if: Conditional rendering
- v-model: Two-way data binding
- @click: Event handling
- @submit.prevent: Form submission handling

## Struktur File Akhir


lab8_vuejs/
│   index.html                 # Main HTML file
└───assets/
    ├───css/
    │   └───style.css         # Styling untuk aplikasi
    └───js/
        └───app.js            # VueJS application logic


## Improvisasi dan Pengembangan Lanjutan

### 1. Peningkatan UI/UX Halaman VueJS

#### 1.1 Desain Modern dan Responsive

- *Bootstrap Integration*: Menambahkan Bootstrap 5 untuk tampilan yang lebih modern dan responsive
- *Card Layout*: Mengubah tampilan tabel menjadi card layout yang lebih menarik
- *Color Scheme*: Implementasi color scheme yang konsisten dan eye-catching
- *Icons*: Menambahkan Font Awesome icons untuk tombol dan aksi

*Screenshot Improvisasi UI:*
![alt text](Gambar/2/image.png)

### 2. Halaman Home untuk Artikel Berita

#### 2.1 Landing Page Design

Membuat halaman home yang menarik untuk menampilkan artikel berita dengan fitur:

- *Hero Section*: Banner utama dengan artikel featured
- *Article Grid*: Layout grid untuk menampilkan artikel terbaru
- *Category Filter*: Filter artikel berdasarkan kategori
- *Search Bar*: Pencarian artikel di halaman depan

**File: home.html**

html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Berita - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="assets/css/home-style.css" />
  </head>
  <body>
    <div id="app">
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
          <a class="navbar-brand" href="#"><i class="fas fa-newspaper"></i> Portal Berita</a>
          <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.html"><i class="fas fa-cog"></i> Admin</a>
          </div>
        </div>
      </nav>

      <!-- Hero Section -->
      <section class="hero-section" v-if="featuredArticle">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h1 class="display-4 fw-bold text-white">{{ featuredArticle.judul }}</h1>
              <p class="lead text-white-50">{{ truncateText(featuredArticle.isi, 150) }}</p>
              <button class="btn btn-light btn-lg" @click="readMore(featuredArticle)"><i class="fas fa-book-open"></i> Baca Selengkapnya</button>
            </div>
          </div>
        </div>
      </section>

      <!-- Search and Filter Section -->
      <section class="py-4 bg-light">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <div class="input-group">
                <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari artikel..." @input="searchArticles" />
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            <div class="col-md-4">
              <select class="form-select" v-model="selectedStatus" @change="filterArticles">
                <option value="">Semua Status</option>
                <option value="1">Published</option>
                <option value="0">Draft</option>
              </select>
            </div>
          </div>
        </div>
      </section>

      <!-- Articles Grid -->
      <section class="py-5">
        <div class="container">
          <h2 class="text-center mb-5">Artikel Terbaru</h2>
          <div class="row" v-if="filteredArticles.length > 0">
            <div class="col-lg-4 col-md-6 mb-4" v-for="article in paginatedArticles" :key="article.id">
              <div class="card h-100 shadow-sm article-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge" :class="article.status == 1 ? 'bg-success' : 'bg-secondary'"> {{ statusText(article.status) }} </span>
                    <small class="text-muted"> <i class="fas fa-calendar"></i> {{ formatDate(article.created_at) }} </small>
                  </div>
                  <h5 class="card-title">{{ article.judul }}</h5>
                  <p class="card-text text-muted">{{ truncateText(article.isi, 100) }}</p>
                  <button class="btn btn-primary btn-sm" @click="readMore(article)"><i class="fas fa-eye"></i> Baca Selengkapnya</button>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Tidak ada artikel ditemukan</h4>
          </div>

          <!-- Pagination -->
          <nav v-if="totalPages > 1" class="mt-4">
            <ul class="pagination justify-content-center">
              <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link" @click="changePage(currentPage - 1)">
                  <i class="fas fa-chevron-left"></i>
                </button>
              </li>
              <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
                <button class="page-link" @click="changePage(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <button class="page-link" @click="changePage(currentPage + 1)">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </section>

      <!-- Article Detail Modal -->
      <div class="modal fade" id="articleModal" tabindex="-1" v-if="selectedArticle">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ selectedArticle.judul }}</h5>
              <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <span class="badge" :class="selectedArticle.status == 1 ? 'bg-success' : 'bg-secondary'"> {{ statusText(selectedArticle.status) }} </span>
                <small class="text-muted ms-2"> <i class="fas fa-calendar"></i> {{ formatDate(selectedArticle.created_at) }} </small>
              </div>
              <div class="article-content">{{ selectedArticle.isi }}</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeModal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="assets/js/home-app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>


*Screenshot Halaman Home:*
![alt text](Gambar/2/image-1.png)
![alt text](Gambar/2/image-2.png)
![alt text](Gambar/2/image-3.png)
![alt text](Gambar/2/image-4.png)

#### 2.2 JavaScript untuk Halaman Home

**File: assets/js/home-app.js**

```javascript
const { createApp } = Vue;

const apiUrl = 'http://localhost:8080';

createApp({
  data() {
    return {
      artikel: [],
      filteredArticles: [],
      featuredArticle: null,
      selectedArticle: null,
      searchQuery: '',
      selectedStatus: '',
      currentPage: 1,
      itemsPerPage: 6,
      showModal: false,
    };
  },
  computed: {
    paginatedArticles() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredArticles.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredArticles.length / this.itemsPerPage);
    },
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      axios
        .get(apiUrl + '/post')
        .then((response) => {
          this.artikel = response.data.artikel;
          this.filteredArticles = this.artikel.filter((a) => a.status == 1); // Only published
          this.featuredArticle = this.filteredArticles[0] || null;
        })
        .catch((error) => console.log(error));
    },
    searchArticles() {
      this.filterArticles();
    },
    filterArticles() {
      let filtered = this.artikel;

      // Filter by search query
      if (this.searchQuery) {
        filtered = filtered.filter((article) => article.judul.toLowerCase().includes(this.searchQuery.toLowerCase()) || article.isi.toLowerCase().includes(this.searchQuery.toLowerCase()));
      }

      // Filter by status
      if (this.selectedStatus !== '') {
        filtered = filtered.filter((article) => article.status == this.selectedStatus);
      } else {
        filtered = filtered.filter((article) => article.status == 1); // Default to published only
      }

      this.filteredArticles = filtered;
      this.currentPage = 1; // Reset to first page
    },
    readMore(article) {
      this.selectedArticle = article;
      this.showModal = true;
      // Show Bootstrap modal
      const modal = new bootstrap.Modal(document.getElementById('art
