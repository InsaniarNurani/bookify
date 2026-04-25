<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Peminjaman</h3>

<?php if (session()->get('role') == 'anggota'): ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Tambah</a>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>Buku</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Status</th>
        <th>pengantaran</th>
        <th>Aksi</th>

    </tr>

    <?php foreach ($peminjaman as $p): ?>
        <tr>
            <td><?= $p['id_peminjaman'] ?></td>

            <!-- ✅ NAMA ANGGOTA -->
            <td><?= $p['nama_anggota'] ?></td>

            <!-- ✅ DAFTAR BUKU -->
            <td>
                <?php foreach ($p['buku'] as $b): ?>
                    <div style="margin-bottom:5px;">
                        <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="40">
                        <?= $b['judul'] ?>
                    </div>
                <?php endforeach; ?>
            </td>

            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>

            <td>
                <?php if ($p['status'] == 'dipinjam'): ?>
                    Dipinjam
                <?php elseif ($p['status'] == 'menunggu_bayar'): ?>
                    <a href="#">Menunggu Bayar</a>
                <?php else: ?>
                    <?= $p['status'] ?>
                <?php endif; ?>
            </td>
            <td>

                <?php if (($p['metode_pengantaran'] ?? '') == 'ambil'): ?>
                    <span style="color:purple;">Ambil di Perpustakaan</span>

                <?php else: ?>

                    <!-- 1. MENUNGGU KONFIRMASI -->
                    <?php if ($p['status_pengiriman'] == 'menunggu_konfirmasi'): ?>
                        <span style="color:orange;">Menunggu Konfirmasi</span>

                        <?php if (session()->get('role') == 'petugas'): ?>
                            <br>
                            <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']) ?>"
                                style="background:orange;color:white;padding:5px;border-radius:5px;">
                                ✔ Konfirmasi
                            </a>
                        <?php endif; ?>


                        <!-- 2. MENUNGGU PEMBAYARAN -->
                    <?php elseif ($p['status_pengiriman'] == 'menunggu_pembayaran'): ?>

                        <?php if (session()->get('role') == 'anggota'): ?>
                            <a href="<?= base_url('peminjaman/pembayaran/' . $p['id_peminjaman']) ?>"
                                style="background:blue;color:white;padding:5px;border-radius:5px;">
                                💳 Bayar Ongkir
                            </a>
                        <?php else: ?>
                            <span style="color:blue;">Menunggu Pembayaran</span>
                        <?php endif; ?>


                        <!-- 3. DIANTAR -->
                    <?php elseif ($p['status_pengiriman'] == 'diantar'): ?>
                        <span style="color:green;">🚚 Sedang Diantar</span>

                        <?php if (session()->get('role') == 'petugas'): ?>
                            <br>
                            <a href="<?= base_url('peminjaman/selesai/' . $p['id_peminjaman']) ?>"
                                style="background:green;color:white;padding:5px;border-radius:5px;">
                                ✔ Selesai
                            </a>
                        <?php endif; ?>


                        <!-- 4. SELESAI -->
                    <?php elseif ($p['status_pengiriman'] == 'selesai'): ?>
                        <span style="color:gray;">✔ Selesai</span>

                    <?php else: ?>
                        -
                    <?php endif; ?>

                <?php endif; ?>

            </td>
            <td>
                <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>">
                    Detail
                </a>
            </td>
            <td>
                <?php if (session()->get('role') == 'petugas'): ?>

                    <?php if ($p['status'] == 'dipinjam'): ?>
                        <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>"
                            onclick="return confirm('Yakin ingin mengembalikan buku ini?')"
                            style="padding:5px 8px; background:orange; color:white; border-radius:5px; text-decoration:none;">
                            Kembalikan
                        </a>
                    <?php endif; ?>
                    <?php if ($p['status'] == 'terlambat'): ?>
                        <span style="color:red;">Terlambat</span>
                    <?php elseif ($p['status'] == 'kembali'): ?>
                        <span style="color:green;">Kembali</span>
                    <?php endif; ?>

                <?php endif; ?>

            </td>
            <td>
                <?php if (session()->get('role') == 'anggota'): ?>

                    <?php if ($p['status'] == 'dipinjam'): ?>
                        <br>
                        <a href="<?= base_url('peminjaman/perpanjang/' . $p['id_peminjaman']) ?>"
                            onclick="return confirm('Perpanjang 7 hari?')"
                            style="padding:5px 8px; background:blue; color:white; border-radius:5px; text-decoration:none;">
                            🔁 Perpanjang
                        </a>
                    <?php endif; ?>

                <?php endif; ?>
            </td>
            <td>
                <a href="<?= base_url('penarikan/ajukan/' . $p['id_peminjaman']) ?>"
                    onclick="return confirm('Ajukan penarikan?')">
                    🚚 Ajukan Penarikan
                </a>
            </td>

            <td>
                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>