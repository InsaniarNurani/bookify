<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Penulis</h3>

<form action="<?= base_url('penulis/update/' . $penulis['id_penulis']) ?>" method="post">

    Nama Penulis:<br>
    <input type="text" name="nama_penulis"
        value="<?= $penulis['nama_penulis'] ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('penulis') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>