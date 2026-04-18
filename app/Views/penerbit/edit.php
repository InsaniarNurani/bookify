<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Penerbit</h3>

<form action="<?= base_url('penerbit/update/' . $penerbit['id_penerbit']) ?>" method="post">

    Nama Penerbit:<br>
    <input type="text" name="nama_penerbit"
        value="<?= $penerbit['nama_penerbit'] ?>" required><br><br>

    Alamat:<br>
    <textarea name="alamat"><?= $penerbit['alamat'] ?></textarea><br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('penerbit') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>