<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Peminjaman</h3>

<?php if (!empty($detail)): ?>
    <p>
        <b>Tanggal Pinjam:</b> <?= $detail[0]['tanggal_pinjam'] ?> <br>
        <b>Tanggal Kembali:</b> <?= $detail[0]['tanggal_kembali'] ?> <br>
        <b>Status:</b> <?= $detail[0]['status'] ?>
    </p>
<?php endif; ?>

<table border="1" cellpadding="8">

    <tr>
        <th>Cover</th>
        <th>Judul Buku</th>
        <th>Jumlah</th>
    </tr>

    <?php foreach ($detail as $d): ?>
        <tr>
            <td>
                <?php if (!empty($d['cover'])): ?>
                    <img src="<?= base_url('uploads/buku/' . $d['cover']) ?>" width="80">
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td><?= $d['judul'] ?></td>

            <td><?= $d['jumlah'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>

<br>

<!-- ================== KEMBALI ================== -->
<a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
    ← Kembali ke Data Peminjaman
</a>

<?= $this->endSection() ?>