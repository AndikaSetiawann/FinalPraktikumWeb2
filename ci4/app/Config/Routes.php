<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================
// 🔧 Default Route
// ========================
$routes->get('/', 'Page::home');

// ========================
// 📦 Public Route untuk Artikel
// ========================
$routes->get('artikel', 'Artikel::index'); // <-- ini tambahan agar /artikel bisa diakses publik

// ========================
// 📘 Static Pages
// ========================
$routes->get('about', 'Page::about');
$routes->get('contact', 'Page::contact');
$routes->get('faqs', 'Page::faqs');
$routes->get('tos', 'Page::tos');
$routes->get('oauth-setup', 'Page::oauthSetup');

// Debug route (remove in production)
$routes->get('debug/session', 'Debug::session');

// ========================
// 👤 User Authentication & Dashboard
// ========================
$routes->get('user/login', 'User::login');      // Tampilkan form login
$routes->post('user/login', 'User::login');     // Proses form login
$routes->get('user/register', 'User::register'); // Tampilkan form register
$routes->post('user/register', 'User::register'); // Proses form register
$routes->get('user/verify-email/(:any)', 'User::verifyEmail/$1'); // Email verification
$routes->get('user/logout', 'User::logout');    // Logout
$routes->get('user/dashboard', 'UserDashboard::index');  // User dashboard
$routes->get('user/profile', 'UserDashboard::profile');  // User profile

// ========================
// 🔐 Google OAuth Authentication
// ========================
$routes->get('auth/google', 'GoogleAuth::login');           // Redirect to Google
$routes->get('auth/google/callback', 'GoogleAuth::callback'); // Handle Google callback
$routes->get('auth/logout', 'GoogleAuth::logout');          // Logout (both traditional and OAuth)

// ========================
// 🔐 Admin Routes (with auth filter)
// ========================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// ========================
// 📘 Artikel Public Detail
// ========================
$routes->get('artikel/(:segment)', 'Artikel::view/$1');

// ========================
// ✅ RESTful API untuk Post Controller
// ========================
$routes->resource('post');

// ========================
// ✅ RESTful API untuk Kategori Controller
// ========================
$routes->resource('kategori');

// ========================
// 🔧 Fix Slug untuk Artikel Lama
// ========================
$routes->get('fix-slug', 'FixSlug::index');

// ========================
// 🔧 Add Kategori Data
// ========================
$routes->get('add-kategori', 'AddKategori::index');
$routes->get('add-game-category', 'AddGameCategory::index');
$routes->get('reset-auto-increment', 'ResetAutoIncrement::index');
$routes->get('reset-to-one', 'ResetToOne::index');
$routes->get('delete-all-articles', 'ResetToOne::deleteAll');
$routes->get('reset-options', 'ResetOptions::index');

// ========================
// 🔧 Debug Routes
// ========================
$routes->get('debug-artikel', 'DebugArtikel::index');
$routes->get('debug-logs', 'DebugArtikel::logs');

// ========================
// 🚨 404 Override & Default Settings
// ========================
$routes->set404Override();
$routes->setAutoRoute(false); // Set true jika kamu ingin gunakan auto-routing (tidak disarankan)
