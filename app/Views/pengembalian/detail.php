<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Pengembalian</h3>

<table border="1">
    <?php if (($from ?? '') == 'peminjaman'): ?>
        <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-secondary">
            ← Kembali ke Peminjaman
        </a>
    <?php else: ?>
        <a href="<?= base_url('buku') ?>" class="btn btn-secondary">
            ← Kembali
        </a>
    <?php endif; ?>

    <tr>
        <td>Peminjaman</td>
        <td><?= $pengembalian['id_peminjaman'] ?></td>
    </tr>
    <tr>
        <td>Tanggal Dikembalikan</td>
        <td><?= $pengembalian['tanggal_dikembalikan'] ?></td>
    </tr>
    <tr>
        <td>Denda</td>
        <td><?= $pengembalian['denda'] ?></td>
    </tr>
</table>

<a href="<?= base_url('pengembalian') ?>">Kembali</a>
<?= $this->endSection() ?>