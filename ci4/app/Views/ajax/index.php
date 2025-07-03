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

<!-- Include jQuery -->
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>

<script>
$(document).ready(function () {
    // Tampilkan pesan loading saat data dimuat
    function showLoadingMessage() {
        $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
    }

    // Fungsi untuk mengambil data dari server
    function loadData() {
        showLoadingMessage();

        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function (data) {
                let tableBody = "";

                if (data.length === 0) {
                    tableBody = '<tr><td colspan="4" style="text-align:center;">Tidak ada data.</td></tr>';
                } else {
                    data.forEach(function (row) {
                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        tableBody += '<td><span class="status">' + (row.status ?? '-') + '</span></td>';
                        tableBody += '<td>';
                        tableBody += '<a href="<?= base_url('artikel/edit/') ?>' + row.id + '" class="btn btn-primary">Edit</a> ';
                        tableBody += '<a href="#" class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    });
                }

                $('#artikelTable tbody').html(tableBody);
            },
            error: function () {
                $('#artikelTable tbody').html('<tr><td colspan="4">Gagal mengambil data.</td></tr>');
            }
        });
    }

    // Load data saat halaman siap
    loadData();

    // Handle klik tombol hapus
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('artikel/delete/') ?>" + id,
                method: "DELETE",
                success: function () {
                    loadData(); // Refresh data setelah hapus
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Gagal menghapus artikel: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });
});
</script>

<?= $this->include('template/footer'); ?>