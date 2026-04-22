<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Peminjaman</h3>

<?php if (session()->get('role') == 'anggota') : ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Tambah Peminjaman</a>
<?php endif; ?>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Anggota</th>
        <th>Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status Peminjaman</th>
        <th>Pengantaran</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($peminjaman as $p): ?>
        <tr>

            <!-- ANGGOTA -->
            <td><?= $p['user_id'] ?? '-' ?></td>

            <!-- BUKU -->
            <td>
                <?php if (!empty($p['buku'])): ?>
                    <?php foreach ($p['buku'] as $b): ?>
                        <?= $b['judul'] ?><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- TANGGAL -->
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>

            <!-- STATUS PEMINJAMAN -->
            <td>
                <?php if ($p['status'] == 'menunggu_konfirmasi'): ?>
                    <span style="color:orange;">Menunggu Konfirmasi</span>

                <?php elseif ($p['status'] == 'menunggu_pembayaran'): ?>
                    <span style="color:blue;">Menunggu Pembayaran</span>

                <?php elseif ($p['status'] == 'diantar'): ?>
                    <span style="color:blue;">Sedang Diantar</span>

                <?php elseif ($p['status'] == 'selesai'): ?>
                    <span style="color:green;">Selesai</span>
                <?php elseif ($p['status'] == 'kembali'): ?>
                    <span style="color:purple;">Sudah Dikembalikan</span>


                <?php else: ?>
                    <span>Dipinjam</span>
                <?php endif; ?>

            </td>

            <!-- 🔥 PENGANTARAN (INI YANG KAMU TANYA) -->
            <td>
                <?php if ($p['status_pengiriman'] == 'menunggu_konfirmasi'): ?>
                    <span style="color:orange;">Menunggu Konfirmasi</span>

                    <!-- 👮 PETUGAS SAJA -->
                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']) ?>">
                            Konfirmasi
                        </a>
                    <?php endif; ?>

                <?php elseif ($p['status_pengiriman'] == 'menunggu_pembayaran'): ?>

                    <!-- 👤 HANYA ANGGOTA -->
                    <?php if (session()->get('role') == 'anggota'): ?>
                        <a href="<?= base_url('peminjaman/pembayaran/' . $p['id_peminjaman']) ?>">
                            Bayar Ongkir
                        </a>
                    <?php else: ?>
                        <span>Menunggu Pembayaran</span>
                    <?php endif; ?>

                <?php elseif ($p['status_pengiriman'] == 'diantar'): ?>
                    <span style="color:blue;">Sedang Diantar</span>

                    <!-- 👮 PETUGAS -->
                    <?php if (session()->get('role') == 'petugas'): ?>
                        <a href="<?= base_url('peminjaman/selesai/' . $p['id_peminjaman']) ?>">
                            Tandai Selesai
                        </a>

                    <?php endif; ?>

                <?php elseif ($p['status_pengiriman'] == 'selesai'): ?>
                    <span style="color:green;">Selesai</span>

                <?php else: ?>
                    <span>-</span>
                <?php endif; ?>
            </td>
            <!-- AKSI -->
            <td>
                <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>">Detail</a>
                <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>">Edit</a>
                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>">Hapus</a>
                <?php if (session()->get('role') == 'petugas'): ?>

                    <?php if (strtolower(trim($p['status'])) == 'dipinjam'): ?>
                        <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>"
                            style="color:white; background:green; padding:5px 10px; border-radius:5px; text-decoration:none;"
                            onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                            🔄 Kembalikan
                        </a>
                    <?php else: ?>
                        <span style="color:green;">Sudah Dikembalikan</span>
                    <?php endif; ?>

                <?php endif; ?>


                <a href="#" onclick="perpanjang(<?= $p['id_peminjaman'] ?>)">Perpanjang</a>
            </td>

        </tr>
    <?php endforeach; ?>

</table>

<!-- ================= SCRIPT ================= -->

<script>
    function perpanjang(id) {
        let hari = prompt("Masukkan jumlah hari perpanjangan:");

        if (hari) {
            window.location.href = "<?= base_url('peminjaman/perpanjang/') ?>" + id + "/" + hari;
        }
    }

    function bayar(id) {
        let metode = prompt("Pilih pembayaran: cash / dana / transfer bank");

        if (metode) {
            alert("Pembayaran berhasil via " + metode);

            window.location.href = "<?= base_url('peminjaman/bayar/') ?>" + id;
        }
    }
</script>

<?= $this->endSection() ?>