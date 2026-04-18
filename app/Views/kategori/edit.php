<h2>Edit Kategori</h2>

<form method="post" action="<?= base_url('kategori/update/' . $kategori['id_kategori']) ?>">

    Nama Kategori:<br>
    <input type="text" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('kategori') ?>">Kembali</a>

</form>