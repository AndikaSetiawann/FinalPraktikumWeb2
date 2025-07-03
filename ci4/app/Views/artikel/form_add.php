<?= $this->include('template/header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post">
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" name="judul" id="judul" class="form-control" required>
    </p>

    <p>
        <label for="isi">Isi Artikel</label><br>
        <textarea name="isi" id="isi" class="form-control" placeholder="Tulis konten artikel di sini..."></textarea>
    </p>

    <p>
        <label for="id_kategori">Kategori</label><br>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= esc($k['id_kategori']); ?>"><?= esc($k['nama_kategori']); ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <input type="submit" value="Kirim" class="btn btn-primary">
        <a href="/admin/artikel" class="btn btn-secondary">Kembali</a>
    </p>
</form>

<!-- Simple Rich Text Editor -->
<style>
.editor-toolbar {
    border: 1px solid #ddd;
    border-bottom: none;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}
.editor-btn {
    background: #fff;
    border: 1px solid #ddd;
    padding: 6px 12px;
    margin-right: 4px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}
.editor-btn:hover {
    background: #e9ecef;
}
.editor-btn.active {
    background: #007bff;
    color: white;
}
#isi {
    border-radius: 0 0 8px 8px !important;
    border-top: none !important;
    min-height: 300px;
}
</style>

<script>
// Simple Rich Text Editor
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('isi');

    // Create toolbar
    const toolbar = document.createElement('div');
    toolbar.className = 'editor-toolbar';
    toolbar.innerHTML = `
        <button type="button" class="editor-btn" onclick="formatText('bold')"><b>B</b></button>
        <button type="button" class="editor-btn" onclick="formatText('italic')"><i>I</i></button>
        <button type="button" class="editor-btn" onclick="formatText('underline')"><u>U</u></button>
        <button type="button" class="editor-btn" onclick="insertList()">• List</button>
        <button type="button" class="editor-btn" onclick="insertLink()">🔗 Link</button>
    `;

    // Insert toolbar before textarea
    textarea.parentNode.insertBefore(toolbar, textarea);

    // Make textarea contenteditable div
    const editor = document.createElement('div');
    editor.contentEditable = true;
    editor.id = 'editor';
    editor.style.cssText = `
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 8px 8px;
        padding: 12px;
        min-height: 300px;
        background: white;
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.5;
    `;

    // Replace textarea with editor
    textarea.style.display = 'none';
    textarea.parentNode.insertBefore(editor, textarea.nextSibling);

    // Sync content
    editor.addEventListener('input', function() {
        textarea.value = editor.innerHTML;
    });

    // Load existing content
    if (textarea.value) {
        editor.innerHTML = textarea.value;
    }
});

function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('editor').focus();
}

function insertList() {
    document.execCommand('insertUnorderedList', false, null);
    document.getElementById('editor').focus();
}

function insertLink() {
    const url = prompt('Enter URL:');
    if (url) {
        document.execCommand('createLink', false, url);
    }
    document.getElementById('editor').focus();
}
</script>

<?= $this->include('template/footer'); ?>
