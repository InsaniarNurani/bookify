<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h3 class="mb-3">📚 Data Peminjaman</h3>

    <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary mb-3">
        + Tambah Peminjaman
    </a>

    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>

                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($peminjaman as $p): ?>

                    <?php
                    $status = $p['status'];

                    if ($status == 'dipinjam') {
                        $badge = 'primary';
                    } elseif ($status == 'diproses') {
                        $badge = 'info';
                    } elseif ($status == 'diperpanjang') {
                        $badge = 'warning';
                    } elseif ($status == 'kembali') {
                        $badge = 'success';
                    } elseif ($status == 'terlambat') {
                        $badge = 'danger';
                    } else {
                        $badge = 'secondary';
                    }
                    ?>

                    <tr>

                        <td class="text-center">
                            <?= $p['id_peminjaman'] ?>
                        </td>

                        <td>
                            <?= $p['nama'] ?? '-' ?>
                        </td>

                        <td>
                            <?= $p['tanggal_pinjam'] ?? '-' ?>
                        </td>

                        <td>
                            <?= $p['tanggal_kembali'] ?? '-' ?>
                        </td>

                        <td>
                            <span class="badge bg-<?= $badge ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>



                        <td style="white-space:nowrap;">

                            <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>"
                                class="btn btn-sm btn-info">
                                Detail
                            </a>

                            <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>"
                                class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <a href="<?= base_url('peminjaman/perpanjang/' . $p['id_peminjaman']) ?>"
                                class="btn btn-sm btn-primary"
                                onclick="return confirm('Perpanjang buku ini?')">
                                Perpanjang
                            </a>

                            <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>"
                                class="btn btn-sm btn-success"
                                onclick="return confirm('Kembalikan buku?')">
                                Kembalikan
                            </a>

                            <?php if ($p['status'] == 'diproses'): ?>
                                <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']) ?>"
                                    class="btn btn-sm btn-secondary"
                                    onclick="return confirm('Konfirmasi peminjaman?')">
                                    Konfirmasi
                                </a>
                            <?php endif; ?>

                            <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Hapus data ini?')">
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>