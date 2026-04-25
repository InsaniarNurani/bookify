<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Pengembalian</h3>

<hr>

<h4>📌 Data Pengembalian</h4>
<p><b>ID Peminjaman:</b> <?= $pengembalian['id_peminjaman'] ?></p>
<p><b>Tanggal Dikembalikan:</b> <?= $pengembalian['tanggal_dikembalikan'] ?></p>
<p><b>Denda:</b> Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?></p>

<hr>

<h4>📚 Data Peminjaman</h4>
<p><b>Nama Anggota:</b> <?= $pengembalian['nama_anggota'] ?></p>
<p><b>Tanggal Pinjam:</b> <?= $pengembalian['tanggal_pinjam'] ?></p>
<p><b>Tanggal Kembali:</b> <?= $pengembalian['tanggal_kembali'] ?></p>
<p><b>Metode Pengantaran:</b> <?= $pengembalian['metode_pengantaran'] ?></p>
<p><b>Alamat:</b> <?= $pengembalian['alamat'] ?? '-' ?></p>

<hr>

<h4>📖 Detail Buku</h4>

<table border="1" cellpadding="8">
    <tr>
        <th>Judul</th>
        <th>Cover</th>
        <th>Jumlah</th>
    </tr>

    <?php foreach ($buku as $b): ?>
        <tr>
            <td><?= $b['judul'] ?></td>
            <td>
                <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="60">
            </td>
            <td><?= $b['jumlah'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>

<a href="<?= base_url('pengembalian') ?>">⬅ Kembali</a>

<?= $this->endSection() ?>