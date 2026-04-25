<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Penarikan</h2>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari nama / status">
    <button type="submit">Cari</button>
</form>

<br>

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

    <?php if (!empty($penarikan)): ?>
        <?php foreach ($penarikan as $p): ?>
            <tr>
                <td><?= $p['id_penarikan'] ?></td>

                <!-- 🔥 INI SUDAH NAMA ANGGOTA -->
                <td><?= $p['nama_anggota'] ?></td>

                <td><?= $p['alamat'] ?></td>
                <td><?= number_format($p['biaya'], 0, ',', '.') ?></td>
                <td><?= $p['status'] ?></td>

                <td>
                    <?= $p['tanggal_ambil'] ? date('d-m-Y H:i', strtotime($p['tanggal_ambil'])) : '-' ?>
                </td>

                <td>
                <td>

                <td>

                    <!-- =========================
         1. KONFIRMASI (PETUGAS)
         status: menunggu
    ========================== -->
                    <?php if (session()->get('role') == 'petugas' && $p['status'] == 'menunggu'): ?>
                        <a href="<?= base_url('penarikan/konfirmasi/' . $p['id_penarikan']) ?>"
                            style="padding:4px 8px;background:orange;color:white;border-radius:5px;text-decoration:none;">
                            ✔ Konfirmasi
                        </a>
                    <?php endif; ?>


                    <!-- =========================
         2. PEMBAYARAN (ANGGOTA)
         status: menunggu_pembayaran
    ========================== -->
                    <?php if (session()->get('role') == 'anggota' && $p['status'] == 'menunggu_pembayaran'): ?>
                        <a href="<?= base_url('penarikan/pembayaran/' . $p['id_penarikan']) ?>"
                            style="padding:4px 8px;background:blue;color:white;border-radius:5px;text-decoration:none;">
                            💳 Bayar
                        </a>
                    <?php endif; ?>


                    <!-- =========================
         3. DIPROSES -> DIAMBIL (PETUGAS)
         status: diproses
    ========================== -->
                    <?php if (session()->get('role') == 'petugas' && $p['status'] == 'diproses'): ?>
                        <a href="<?= base_url('penarikan/diambil/' . $p['id_penarikan']) ?>"
                            style="padding:4px 8px;background:green;color:white;border-radius:5px;text-decoration:none;">
                            🚚 Diambil
                        </a>
                    <?php endif; ?>


                    <!-- =========================
         4. SELESAI (PETUGAS)
         status: diambil
    ========================== -->
                    <?php if (session()->get('role') == 'petugas' && $p['status'] == 'diambil'): ?>
                        <a href="<?= base_url('penarikan/selesai/' . $p['id_penarikan']) ?>"
                            style="padding:4px 8px;background:gray;color:white;border-radius:5px;text-decoration:none;">
                            📦 Selesai
                        </a>
                    <?php endif; ?>

                    <!-- DETAIL (PETUGAS SAJA) -->
                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('penarikan/detail/' . $p['id_penarikan']) ?>"
                            style="padding:4px 8px;background:#555;color:white;border-radius:5px;text-decoration:none;">
                            🔍 Detail
                        </a>
                    <?php endif; ?>


                    <!-- HAPUS (PETUGAS SAJA) -->
                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('penarikan/delete/' . $p['id_penarikan']) ?>"
                            onclick="return confirm('Yakin ingin hapus data ini?')"
                            style="padding:4px 8px;background:red;color:white;border-radius:5px;text-decoration:none;">
                            🗑 Hapus
                        </a>
                    <?php endif; ?>
                    <!-- =========================
         INFO STATUS TAMBAHAN
    ========================== -->
                    <?php if ($p['status'] == 'selesai'): ?>
                        <span style="color:green;font-weight:bold;">✔ Selesai</span>
                    <?php endif; ?>

                </td>

                </td>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">Data kosong</td>
        </tr>
    <?php endif; ?>
</table>

<?= $this->endSection() ?>