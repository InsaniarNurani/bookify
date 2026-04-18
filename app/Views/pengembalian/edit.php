<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4>Edit Pengembalian</h4>

<form action="<?= base_url('pengembalian/update/' . $pengembalian['id_pengembalian']) ?>" method="post">

    <!-- PEMINJAMAN -->
    <label>Peminjaman</label><br>
    <select name="id_peminjaman" required style="width:100%">
        <?php foreach ($peminjaman as $p): ?>
            <option value="<?= $p['id_peminjaman'] ?>"
                <?= $p['id_peminjaman'] == $pengembalian['id_peminjaman'] ? 'selected' : '' ?>>

                ID: <?= $p['id_peminjaman'] ?>
                | <?= $p['tanggal_pinjam'] ?? '' ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- TANGGAL DIKEMBALIKAN -->
    <label>Tanggal Dikembalikan</label><br>
    <input type="date" name="tanggal_dikembalikan"
        value="<?= $pengembalian['tanggal_dikembalikan'] ?>" required style="width:100%">
    <br><br>

    <!-- DENDA -->
    <label>Denda</label><br>
    <input type="number" name="denda"
        value="<?= $pengembalian['denda'] ?>" step="0.01" style="width:100%">
    <br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('pengembalian') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>