<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Peminjaman</h3>

<form method="post" action="<?= base_url('peminjaman/store') ?>" method="post">

    <!-- ANGGOTA -->
    Anggota:<br>
    <select name="id_anggota" required style="width:100%">
        <option value="">Pilih Anggota</option>
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id_anggota'] ?>">
                <?= $a['nama'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- PETUGAS -->
    Petugas:<br>
    <select name="id_petugas" required style="width:100%">
        <option value="">Pilih Petugas</option>
        <?php foreach ($petugas as $p): ?>
            <option value="<?= $p['id_petugas'] ?>">
                <?= $p['nama'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- TANGGAL PINJAM -->
    Tanggal Pinjam:<br>
    <input type="date" name="tanggal_pinjam" required>
    <br><br>

    <!-- BUKU -->
    <h4>Pilih Buku</h4>

    <?php foreach ($buku as $b): ?>
        <div style="margin-bottom:10px;">
            <input type="checkbox" name="id_buku[]" value="<?= $b['id_buku'] ?>">
            <?= $b['judul'] ?>

            &nbsp; Jumlah:
            <input type="number" name="jumlah[]" value="1" style="width:60px;">
        </div>
    <?php endforeach; ?>

    <br>

    <button type="submit">Simpan Peminjaman</button>

</form>

<?= $this->endSection() ?>