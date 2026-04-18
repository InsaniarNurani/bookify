<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Pengembalian</h3>

<form method="post" action="<?= base_url('pengembalian/store') ?>" method="post">

    <!-- PEMINJAMAN -->
    Peminjaman:<br>
    <select name="id_peminjaman" required style="width:100%">
        <option value="">Pilih Peminjaman</option>
        <?php foreach ($peminjaman as $p): ?>
            <option value="<?= $p['id_peminjaman'] ?>">
                ID: <?= $p['id_peminjaman'] ?> |
                Tgl Pinjam: <?= $p['tanggal_pinjam'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- TANGGAL DIKEMBALIKAN -->
    Tanggal Dikembalikan:<br>
    <input type="date" name="tanggal_dikembalikan" required style="width:100%">
    <br><br>

    <!-- DENDA -->
    Denda:<br>
    <input type="number" name="denda" value="0" step="0.01" style="width:100%">
    <br><br>

    <button type="submit">Simpan Pengembalian</button>

</form>

<?= $this->endSection() ?>