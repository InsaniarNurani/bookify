<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Rak</h3>

<form action="<?= base_url('rak/store') ?>" method="post">

    Nama Rak:<br>
    <input type="text" name="nama_rak" required><br><br>

    Lokasi:<br>
    <input type="text" name="lokasi"><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('rak') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>