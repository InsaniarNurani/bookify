<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="printArea">

    <h3>Detail Penarikan</h3>

    <!-- ID PENARIKAN -->
    <p><b>ID Penarikan:</b> <?= $penarikan['id_penarikan'] ?? '-' ?></p>

    <!-- ID / NAMA PEMINJAMAN (kalau sudah join nama) -->
    <p><b>Peminjam:</b> <?= $penarikan['nama_anggota'] ?? $penarikan['id_peminjaman'] ?? '-' ?></p>

    <!-- ALAMAT -->
    <p><b>Alamat Pengambilan:</b> <?= $penarikan['alamat'] ?? '-' ?></p>

    <!-- BIAYA -->
    <p><b>Biaya:</b>
        Rp <?= number_format($penarikan['biaya'] ?? 0, 0, ',', '.') ?>
    </p>

    <!-- STATUS -->
    <p><b>Status:</b>
        <?php if (($penarikan['status'] ?? '') == 'diajukan'): ?>
            <span style="color:orange;">Diajukan</span>

        <?php elseif (($penarikan['status'] ?? '') == 'menunggu_pembayaran'): ?>
            <span style="color:red;">Menunggu Pembayaran</span>

        <?php elseif (($penarikan['status'] ?? '') == 'sudah_bayar'): ?>
            <span style="color:blue;">Sudah Bayar</span>

        <?php elseif (($penarikan['status'] ?? '') == 'diambil'): ?>
            <span style="color:green;">Diambil</span>

        <?php elseif (($penarikan['status'] ?? '') == 'selesai'): ?>
            <span style="color:gray;">Selesai</span>

        <?php else: ?>
            <span>-</span>
        <?php endif; ?>
    </p>

    <!-- TANGGAL -->
    <p><b>Tanggal Ambil:</b> <?= $penarikan['tanggal_ambil'] ?? '-' ?></p>

    <!-- WAKTU -->
    <p><b>Dibuat:</b> <?= $penarikan['created_at'] ?? '-' ?></p>
    <p><b>Update:</b> <?= $penarikan['updated_at'] ?? '-' ?></p>

</div>

<br>

<!-- BUTTON -->
<div class="no-print">

    <a href="<?= base_url('penarikan') ?>"
        style="padding:8px 12px;background:#ccc;text-decoration:none;border-radius:5px;">
        ⬅ Kembali
    </a>

    <button onclick="window.print()"
        style="padding:8px 12px;background:green;color:white;border:none;border-radius:5px;">
        🖨 Print
    </button>

</div>

<!-- PRINT STYLE -->
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
    }
</style>

<?= $this->endSection() ?>