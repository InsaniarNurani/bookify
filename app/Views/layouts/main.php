<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookify</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: "SF Pro", "Helvetica Neue", Arial;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 15px;
            overflow-y: auto;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        /* ✅ TAMBAHAN UNTUK HIDE SIDEBAR */
        .no-sidebar {
            margin-left: 0 !important;
        }

        .topbar {
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                left: -240px;
                transition: 0.3s;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR (SUDAH DIBERI KONDISI) -->
    <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
        <div id="sidebar" class="sidebar">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-book"></i> Bookify
            </h5>

            <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
        </div>
    <?php endif; ?>

    <!-- CONTENT -->
    <div class="content <?= (isset($hideSidebar) && $hideSidebar) ? 'no-sidebar' : '' ?>">

        <!-- TOPBAR -->
        <div class="topbar">

            <!-- Toggle -->
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <!-- Title -->
            <div class="fw-semibold">
                Dashboard
            </div>

            <!-- USER DROPDOWN -->
            <ul class="navbar-nav ms-auto">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">

                        <img src="<?= base_url('uploads/users/' . (session()->get('foto') ?: 'default.png')) ?>"
                            class="rounded-circle me-2"
                            width="30"
                            height="30"
                            style="object-fit: cover;">

                        <?= session()->get('nama') ?? 'User' ?>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('profile') ?>">
                                <img src="<?= base_url('uploads/users/' . (session()->get('foto') ?: 'default.png')) ?>"
                                    class="rounded-circle me-2"
                                    width="25"
                                    height="25"
                                    style="object-fit: cover;">
                                Profil
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                Logout
                            </a>
                        </li>

                    </ul>

                </li>

            </ul>

        </div>

        <!-- MAIN CONTENT -->
        <?= $this->renderSection('content') ?>

    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        $(document).ready(function() {
            $('select').select2({
                width: '100%'
            });
        });
    </script>

</body>

</html>