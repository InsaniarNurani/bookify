<h2>Tambah Kategori</h2>

<form method="post" action="<?= base_url('kategori/store') ?>">

    Nama Kategori:<br>
    <input type="text" name="nama_kategori" required><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('kategori') ?>">Kembali</a>

</form>