<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div id="printArea">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-receipt me-2"></i>Detail Peminjaman
                </h3>
                <small class="text-muted">
                    Informasi lengkap transaksi peminjaman buku
                </small>
            </div>

            <span class="badge bg-dark px-3 py-2">
                ID #<?= $peminjaman['id_peminjaman'] ?? '-' ?>
            </span>
        </div>

        <!-- INFO CARD -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white fw-semibold">
                <i class="bi bi-person-lines-fill me-2"></i>Informasi Peminjaman
            </div>

            <div class="card-body">
                <div class="row g-4">

                    <!-- KIRI -->
                    <div class="col-md-6">

                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Nama Anggota</small>
                            <div class="fw-semibold mb-3">
                                <?= $peminjaman['nama_anggota'] ?? '-' ?>
                            </div>

                            <small class="text-muted d-block">Tanggal Pinjam</small>
                            <div class="fw-semibold mb-3">
                                <?= $peminjaman['tanggal_pinjam'] ?? '-' ?>
                            </div>

                            <small class="text-muted d-block">Tanggal Kembali</small>
                            <div class="fw-semibold">
                                <?= $peminjaman['tanggal_kembali'] ?? '-' ?>
                            </div>
                        </div>

                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6">

                        <div class="p-3 border rounded h-100">

                            <div class="mb-3">
                                <small class="text-muted d-block">Metode Pengantaran</small>
                                <div class="fw-semibold">
                                    <?= ucfirst($peminjaman['metode_pengantaran'] ?? '-') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Status</small>

                                <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>

                                    <?php if (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_konfirmasi'): ?>
                                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>

                                    <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_pembayaran'): ?>
                                        <span class="badge bg-danger">Menunggu Pembayaran</span>

                                    <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'siap_dikirim'): ?>
                                        <span class="badge bg-primary">Siap Dikirim</span>

                                    <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'diantar'): ?>
                                        <span class="badge bg-success">Sedang Diantar</span>

                                    <?php else: ?>
                                        <span class="badge bg-secondary">-</span>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <span class="badge bg-success">
                                        <?= $peminjaman['status'] ?? '-' ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Ongkir</small>
                                <div class="fw-semibold">
                                    <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>
                                        Rp <?= number_format($peminjaman['ongkir'] ?? 0, 0, ',', '.') ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <small class="text-muted d-block">Total Bayar</small>
                                <div class="fw-semibold">
                                    <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>
                                        Rp <?= number_format($peminjaman['total_bayar'] ?? 0, 0, ',', '.') ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- DENDA -->
                    <div class="col-12">
                        <div class="p-3 rounded border bg-light d-flex justify-content-between align-items-center">

                            <div>
                                <small class="text-muted">Denda</small>
                            </div>

                            <div>
                                <?php if (!empty($peminjaman['denda']) && $peminjaman['denda'] > 0): ?>
                                    <span class="badge bg-danger fs-6">
                                        Rp <?= number_format($peminjaman['denda'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success fs-6">
                                        Tidak ada denda
                                    </span>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- BUKU -->
        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-book me-2"></i>Detail Buku Dipinjam
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light text-center">
                            <tr>
                                <th width="80">Cover</th>
                                <th class="text-start">Judul</th>
                                <th width="120">Jumlah</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($peminjaman['buku'])): ?>
                                <?php foreach ($peminjaman['buku'] as $b): ?>
                                    <tr>

                                        <td class="text-center">
                                            <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?? 'default.png')) ?>"
                                                class="rounded shadow-sm"
                                                style="width:50px; height:70px; object-fit:cover;">
                                        </td>

                                        <td class="fw-semibold">
                                            <?= $b['judul'] ?? '-' ?>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                <?= $b['jumlah'] ?? 1 ?>
                                            </span>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        Tidak ada data buku
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-4 d-flex gap-2 no-print">

        <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>

        <button onclick="window.print()" class="btn btn-success">
            <i class="bi bi-printer me-1"></i>Print
        </button>

    </div>

</div>

<!-- PRINT -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printArea,
        #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<?= $this->endSection() ?>