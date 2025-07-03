<?= $this->include('template/header'); ?>

<h2><?= esc($title); ?></h2>

<form action="" method="post">
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" name="judul" id="judul" value="<?= esc($artikel['judul']); ?>" class="form-control" required>
    </p>

    <p>
        <label for="isi">Isi Artikel</label><br>
        <textarea name="isi" id="isi" class="form-control" placeholder="Tulis konten artikel di sini..."><?= esc($artikel['isi']); ?></textarea>
    </p>
                </div>
            </p>
        </div>
    </div>

    <p>
        <label for="id_kategori">Kategori</label><br>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']); ?>" <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= esc($k['nama_kategori']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <input type="submit" value="Update" class="btn btn-primary">
        <a href="/admin/artikel" class="btn btn-secondary">Kembali</a>
    </p>
</form>

<!-- TinyMCE CDN (Free Version) -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

<script>
// Initialize TinyMCE Rich Text Editor
tinymce.init({
    selector: '#isi',
    height: 400,
    menubar: false,
    plugins: 'lists link code',
    toolbar: 'undo redo | bold italic | bullist numlist | link | code',
    content_style: 'body { font-family:Arial,sans-serif; font-size:14px; }',
    branding: false,
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
</script>

<?= $this->include('template/footer'); ?>
