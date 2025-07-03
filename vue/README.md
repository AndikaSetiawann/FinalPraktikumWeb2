# Lab8 Vue.js Frontend

Frontend Vue.js yang terpisah dari CodeIgniter 4 backend dengan sinkronisasi melalui REST API.

## Struktur Proyek

```
lab8_vuejs/                 # Frontend Vue.js (terpisah)
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js          # Vue.js application
├── index.html              # Main HTML file
└── README.md

ci4/                        # Backend CodeIgniter 4
├── app/
│   ├── Controllers/
│   │   └── Post.php        # REST API Controller
│   ├── Models/
│   │   └── ArtikelModel.php
│   └── Config/
│       ├── Cors.php        # CORS configuration
│       └── Filters.php     # Filter configuration
└── ...
```

## Setup & Konfigurasi

### 1. Backend (CodeIgniter 4)
- **URL**: `http://localhost/ci4/public`
- **API Endpoint**: `http://localhost/ci4/public/post`
- **Database**: MySQL database `sukses`

### 2. Frontend (Vue.js)
- **URL**: `http://localhost/lab8_vuejs`
- **Framework**: Vue.js 3 (CDN)
- **HTTP Client**: Axios

## API Endpoints

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/post` | Get all articles |
| POST | `/post` | Create new article |
| GET | `/post/{id}` | Get specific article |
| PUT | `/post/{id}` | Update article |
| DELETE | `/post/{id}` | Delete article |

## Sinkronisasi Data

Frontend Vue.js berkomunikasi dengan backend CodeIgniter 4 melalui REST API:

1. **Load Data**: Vue.js memanggil `GET /post` untuk mengambil data artikel
2. **Create**: Vue.js mengirim `POST /post` untuk membuat artikel baru
3. **Update**: Vue.js mengirim `PUT /post/{id}` untuk update artikel
4. **Delete**: Vue.js mengirim `DELETE /post/{id}` untuk hapus artikel

## CORS Configuration

Backend sudah dikonfigurasi untuk menerima request dari frontend:
- Allowed Origins: `localhost`, `127.0.0.1`
- Allowed Methods: `GET`, `POST`, `PUT`, `DELETE`, `OPTIONS`
- Allowed Headers: `Content-Type`, `Authorization`, `X-Requested-With`

## Cara Menjalankan

1. **Start XAMPP** (Apache + MySQL)
2. **Backend**: Akses `http://localhost/ci4/public`
3. **Frontend**: Akses `http://localhost/lab8_vuejs`

## Fitur

- ✅ CRUD Operations (Create, Read, Update, Delete)
- ✅ Real-time synchronization dengan database
- ✅ Modal form untuk input data
- ✅ Status artikel (Draft/Publish)
- ✅ Error handling dan user feedback
- ✅ Responsive design

## Teknologi

- **Frontend**: Vue.js 3, Axios, HTML5, CSS3
- **Backend**: CodeIgniter 4, PHP, MySQL
- **Server**: Apache (XAMPP)
