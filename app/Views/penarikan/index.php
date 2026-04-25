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

                <!-- Nama anggota -->
                <td><?= $p['nama_anggota'] ?? '-' ?></td>

                <td><?= $p['alamat'] ?></td>

                <td><?= number_format($p['biaya'], 0, ',', '.') ?></td>

                <td><?= $p['status'] ?></td>

                <td>
                    <?= $p['tanggal_ambil']
                        ? date('d-m-Y H:i', strtotime($p['tanggal_ambil']))
                        : '-' ?>
                </td>

                <td>

                    <!-- 🔐 HANYA PETUGAS BOLEH AKSI -->
                    <?php if (session()->get('role') == 'petugas'): ?>

                        <?php if ($p['status'] == 'menunggu'): ?>
                            <a href="<?= base_url('penarikan/konfirmasi/' . $p['id_penarikan']) ?>">
                                ✔ Konfirmasi
                            </a>
                        <?php endif; ?>

                        <?php if ($p['status'] == 'diproses'): ?>
                            <a href="<?= base_url('penarikan/diambil/' . $p['id_penarikan']) ?>">
                                🚚 Diambil
                            </a>
                        <?php endif; ?>

                        <?php if ($p['status'] == 'diambil'): ?>
                            <a href="<?= base_url('penarikan/selesai/' . $p['id_penarikan']) ?>">
                                📦 Selesai
                            </a>
                        <?php endif; ?>

                        |
                        <a href="<?= base_url('penarikan/edit/' . $p['id_penarikan']) ?>">
                            ✏ Edit
                        </a>

                        |
                        <a href="<?= base_url('penarikan/delete/' . $p['id_penarikan']) ?>"
                            onclick="return confirm('Hapus data?')">
                            🗑 Hapus
                        </a>

                    <?php else: ?>
                        <span style="color:gray;">Tidak ada akses</span>
                    <?php endif; ?>

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