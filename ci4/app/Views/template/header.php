<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title; ?> </title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/gambar/favicon.svg?v=2025'); ?>">
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div id="container">
      <header>
        <div class="header-content">
          <img src="<?= base_url('/assets/logo/logo.svg'); ?>" alt="Logo" class="header-logo">
          <h1>Layout Sederhana</h1>
        </div>
      </header>
      <nav>
        <a href="<?= base_url('/');?>" class="active">Home</a>
        <a href="<?= base_url('/admin/artikel'); ?>">Dashboard Admin</a>
        <a href="<?= base_url('/artikel');?>">Artikel</a>
        <a href="<?= base_url('/about');?>">About</a>
        <a href="<?= base_url('/contact');?>">Contact</a>
        <a href="<?= base_url('/faqs');?>">FAQs</a>
        <a href="<?= base_url('/tos');?>">TOS</a>

        <?php if (session()->get('logged_in')) : ?>
          <a href="<?= base_url('/user/logout'); ?>">Logout</a>
        <?php endif; ?>
      </nav>
      <section id="wrapper">
        <section id="main">
