<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Transaksi</h3>

<!-- SEARCH -->
<form method="get" action="">
    <input type="text" name="keyword" placeholder="Cari transaksi...">
    <button type="submit">Cari</button>
</form>

<br>

<a href="<?= base_url('transaksi/create') ?>">+ Tambah Transaksi</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>ID Peminjaman</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($transaksi as $t): ?>
        <tr>
            <td><?= $t['id_transaksi'] ?></td>
            <td><?= $t['id_peminjaman'] ?></td>
            <td><?= $t['jenis'] ?></td>
            <td><?= $t['jumlah'] ?></td>

            <td>
                <?= $t['status'] == 'lunas'
                    ? '<span style="color:green">Lunas</span>'
                    : '<span style="color:red">Belum Bayar</span>' ?>
            </td>

            <td><?= $t['tanggal'] ?></td>

            <td>
                <a href="<?= base_url('transaksi/edit/' . $t['id_transaksi']) ?>">Edit</a>

                <a href="<?= base_url('transaksi/delete/' . $t['id_transaksi']) ?>"
                    onclick="return confirm('Hapus data?')">
                    Hapus
                </a>

                <?php if ($t['status'] == 'belum_bayar'): ?>
                    <a href="<?= base_url('transaksi/bayar/' . $t['id_transaksi']) ?>"
                        style="color:blue;">Bayar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>