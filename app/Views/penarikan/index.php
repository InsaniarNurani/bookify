<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Penarikan</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>Alamat</th>
        <th>Biaya</th>
        <th>Status</th>
        <th>Tanggal Ambil</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($penarikan as $p): ?>
        <tr>
            <td><?= $p['id_penarikan'] ?></td>
            <td><?= $p['nama_anggota'] ?></td>
            <td><?= $p['alamat'] ?></td>
            <td><?= $p['biaya'] ?></td>
            <td><?= $p['status'] ?></td>
            <td><?= $p['tanggal_ambil'] ?></td>

            <td>

                <!-- ================= DIAJUKAN ================= -->
                <?php if ($p['status'] == 'diajukan'): ?>

                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('penarikan/konfirmasi/' . $p['id_penarikan']) ?>">
                            ✔ Konfirmasi
                        </a>
                    <?php else: ?>
                        Menunggu Konfirmasi
                    <?php endif; ?>


                    <!-- ================= MENUNGGU PEMBAYARAN ================= -->
                <?php elseif ($p['status'] == 'menunggu_pembayaran'): ?>

                    <?php if (session()->get('role') == 'anggota'): ?>
                        <a href="<?= base_url('penarikan/bayar/' . $p['id_penarikan']) ?>">
                            💳 Bayar
                        </a>
                    <?php else: ?>
                        Menunggu Pembayaran
                    <?php endif; ?>


                    <!-- ================= SUDAH BAYAR ================= -->
                <?php elseif ($p['status'] == 'sudah_bayar'): ?>

                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('penarikan/ambil/' . $p['id_penarikan']) ?>">
                            🚚 Ambil
                        </a>
                    <?php else: ?>
                        Sudah Dibayar
                    <?php endif; ?>


                    <!-- ================= DIAMBIL ================= -->
                <?php elseif ($p['status'] == 'diambil'): ?>

                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('penarikan/selesai/' . $p['id_penarikan']) ?>">
                            ✔ Selesai
                        </a>
                    <?php else: ?>
                        Dalam Proses Pengambilan
                    <?php endif; ?>


                    <!-- ================= SELESAI ================= -->
                <?php elseif ($p['status'] == 'selesai'): ?>
                    ✔ Selesai
                <?php endif; ?>

                |<a href="<?= base_url('penarikan/detail/' . $p['id_penarikan']) ?>">
                    Detail
                </a>
                <a href="<?= base_url('penarikan/delete/' . $p['id_penarikan']) ?>"
                    onclick="return confirm('Hapus data?')">
                    Hapus
                </a>

            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>