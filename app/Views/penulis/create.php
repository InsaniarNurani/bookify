<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Penulis</h3>

<form action="<?= base_url('penulis/store') ?>" method="post">

    Nama Penulis:<br>
    <input type="text" name="nama_penulis" required><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('penulis') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>