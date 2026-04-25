<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Transaksi</h3>





<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>metode pembayaran</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($transaksi as $t): ?>
        <tr>
            <td><?= $t['id_transaksi'] ?></td>

            <td><?= $t['nama_anggota'] ?? '-' ?></td>
            <td><?= $t['metode_pembayaran'] ?></td>

            <td>
                <?= $t['status'] == 'lunas'
                    ? '<span style="color:green">Lunas</span>'
                    : '<span style="color:red">Belum Bayar</span>' ?>
            </td>

            <td><?= $t['tanggal'] ?></td>

            <td>
                <a href="<?= base_url('transaksi/detail/' . $t['id_transaksi']) ?>"
                    style="color:blue;">Detail</a> |

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