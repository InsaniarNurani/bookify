<div class="nav flex-column">

    <!-- LOGO -->
    <div class="mb-4 text-center">
        <h5 class="fw-bold">
            <i class="bi bi-book me-1"></i> Bookify
        </h5>
        <small class="text-muted">Library System</small>
    </div>

    <!-- MENU -->
    <a href="<?= base_url('/') ?>"
        class="nav-link <?= uri_string() == '' ? 'active fw-bold text-primary' : 'text-dark' ?>">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
        <a href="<?= base_url('users') ?>"
            class="nav-link <?= uri_string() == 'users' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-people me-2"></i> Users
        </a>
    <?php endif; ?>

    <?php if (session()->get('role') != 'admin') : ?>
        <a href="<?= base_url('kategori') ?>"
            class="nav-link <?= uri_string() == 'kategori' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-tags me-2"></i> Kategori
        </a>
    <?php endif; ?>

    <?php if (session()->get('role') != 'anggota') : ?>
        <a href="<?= base_url('buku') ?>"
            class="nav-link <?= uri_string() == 'buku' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-journal-bookmark me-2"></i> Buku
        </a>
    <?php endif; ?>

    <?php if (session()->get('role') == 'admin') : ?>
        <a href="<?= base_url('penulis') ?>"
            class="nav-link <?= uri_string() == 'penulis' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-pencil me-2"></i> Penulis
        </a>

        <a href="<?= base_url('penerbit') ?>"
            class="nav-link <?= uri_string() == 'penerbit' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-building me-2"></i> Penerbit
        </a>
    <?php endif; ?>

    <a href="<?= base_url('peminjaman') ?>"
        class="nav-link <?= uri_string() == 'peminjaman' ? 'active fw-bold text-primary' : 'text-dark' ?>">
        <i class="bi bi-journal-plus me-2"></i> Peminjaman
    </a>

    <a href="<?= base_url('pengembalian') ?>"
        class="nav-link <?= uri_string() == 'pengembalian' ? 'active fw-bold text-primary' : 'text-dark' ?>">
        <i class="bi bi-arrow-return-left me-2"></i> Pengembalian
    </a>

    <a href="<?= base_url('transaksi') ?>"
        class="nav-link <?= uri_string() == 'transaksi' ? 'active fw-bold text-primary' : 'text-dark' ?>">
        <i class="bi bi-cash-stack me-2"></i> Transaksi
    </a>

    <a href="<?= base_url('penarikan') ?>"
        class="nav-link <?= uri_string() == 'penarikan' ? 'active fw-bold text-primary' : 'text-dark' ?>">
        <i class="bi bi-truck me-2"></i> Penarikan
    </a>

    <?php if (session()->get('role') == 'admin') : ?>
        <a href="<?= base_url('rak') ?>"
            class="nav-link <?= uri_string() == 'rak' ? 'active fw-bold text-primary' : 'text-dark' ?>">
            <i class="bi bi-grid me-2"></i> Rak
        </a>

        <a href="<?= base_url('backup') ?>"
            class="nav-link text-dark">
            <i class="bi bi-database me-2"></i> Backup
        </a>
    <?php endif; ?>

    <hr>

    <!-- USER INFO -->
    <div class="text-center mb-3">
        <?php if (!empty(session()->get('foto'))): ?>
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>"
                class="rounded-circle mb-2"
                style="width:70px;height:70px;object-fit:cover;">
        <?php else: ?>
            <i class="bi bi-person-circle fs-1 text-muted"></i>
        <?php endif; ?>

        <div class="fw-semibold">
            <?= session('nama'); ?>
        </div>

        <small class="text-muted">
            <?= session('role'); ?>
        </small>
    </div>

    <!-- LOGOUT -->
    <a href="<?= base_url('logout') ?>"
        class="nav-link text-danger">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>

</div>