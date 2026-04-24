<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Pengembalian</h3>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>ID Peminjaman</th>
        <th>Nama Anggota</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Dikembalikan</th>
        <th>Denda</th>
        <th>Status</th>
        <th>Status Bayar</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengembalian as $p): ?>
        <tr>

            <td><?= $p['id_pengembalian'] ?></td>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['nama_anggota'] ?? '-' ?></td>
            <td><?= $p['tanggal_pinjam'] ?? '-' ?></td>
            <td><?= $p['tanggal_dikembalikan'] ?></td>

            <!-- 💰 DENDA -->
            <td><?= $p['denda'] ?? 0 ?></td>

            <!-- 🔥 STATUS TELAT / TEPAT WAKTU -->
            <td>
                <?php if (($p['denda'] ?? 0) > 0): ?>
                    <span style="color:red; font-weight:bold;">
                        Terlambat
                    </span>
                <?php else: ?>
                    <span style="color:green; font-weight:bold;">
                        Tepat Waktu
                    </span>
                <?php endif; ?>
            </td>

            <!-- 💳 STATUS BAYAR -->
            <td>
                <?php if (($p['status_bayar'] ?? 'belum_bayar') == 'belum_bayar'): ?>
                    <span style="color:red;">Belum Bayar</span>
                <?php else: ?>
                    <span style="color:green;">Lunas</span>
                <?php endif; ?>
            </td>

            <!-- 🔘 AKSI -->
            <td>

                <!-- DETAIL -->
                <a href="<?= base_url('pengembalian/detail/' . $p['id_pengembalian']) ?>">
                    Detail
                </a>

                <!-- EDIT -->
                <a href="<?= base_url('pengembalian/edit/' . $p['id_pengembalian']) ?>">
                    Edit
                </a>

                <!-- HAPUS -->
                <a href="<?= base_url('pengembalian/delete/' . $p['id_pengembalian']) ?>"
                    onclick="return confirm('Hapus data?')">
                    Hapus
                </a>

                <!-- 💳 BAYAR DENDA (HANYA JIKA ADA DENDA & BELUM BAYAR) -->
                <?php if (($p['denda'] ?? 0) > 0 && ($p['status_bayar'] ?? 'belum_bayar') == 'belum_bayar'): ?>
                    <br>
                    <a href="<?= base_url('pengembalian/bayar/' . $p['id_pengembalian']) ?>"
                        style="padding:5px 10px; background:blue; color:white; border-radius:5px; display:inline-block; margin-top:5px;">
                        Bayar Denda
                    </a>
                <?php endif; ?>

            </td>

        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>