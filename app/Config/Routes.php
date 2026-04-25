<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Variabel Filter ---
$authFilter = ['filter' => 'auth'];
$intRole    = ['filter' => 'role:admin,petugas'];
$allRole    = ['filter' => 'role:admin,petugas,anggota'];

// --- Auth ---
$routes->get('login', 'Auth::login');
$routes->post('proses-login', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// --- Halaman Utama ---
$routes->get('/', 'Home::index', $authFilter);
$routes->get('dashboard', 'Home::index', $authFilter);

// --- Modul: Users ---
$routes->get('/users', 'Users::index', $intRole); // menampilkan data user hanya untuk admin dan petugas
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole); // form edit user
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); // aksi update user
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); // aksi hapus user
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); // aksi detail user
$routes->get('users/print', 'Users::print', $allRole); // aksi print data user
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); // aksi kirim ke whatsapp


// --- Modul: Buku ---
$routes->group('buku', function ($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('create', 'Buku::create');
    $routes->post('store', 'Buku::store');
    $routes->get('detail/(:num)', 'Buku::detail/$1');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');
    $routes->get('delete/(:num)', 'Buku::delete/$1');
    $routes->get('print', 'Buku::print');
    $routes->get('wa/(:num)', 'Buku::wa/$1');
});


// --- Modul Lainnya ---
$routes->group('kategori', function ($routes) {
    $routes->get('/', 'Kategori::index');
    $routes->get('create', 'Kategori::create');
    $routes->post('store', 'Kategori::store');
    $routes->get('edit/(:num)', 'Kategori::edit/$1');
    $routes->post('update/(:num)', 'Kategori::update/$1');
    $routes->get('delete/(:num)', 'Kategori::delete/$1');
});

$routes->group('penulis', function ($routes) {
    $routes->get('/', 'Penulis::index');
    $routes->get('create', 'Penulis::create');
    $routes->post('store', 'Penulis::store');
    $routes->get('edit/(:num)', 'Penulis::edit/$1');
    $routes->post('update/(:num)', 'Penulis::update/$1');
    $routes->get('delete/(:num)', 'Penulis::delete/$1');
});

$routes->group('penerbit', function ($routes) {
    $routes->get('/', 'Penerbit::index');
    $routes->get('create', 'Penerbit::create');
    $routes->post('store', 'Penerbit::store');
    $routes->get('edit/(:num)', 'Penerbit::edit/$1');
    $routes->post('update/(:num)', 'Penerbit::update/$1');
    $routes->get('delete/(:num)', 'Penerbit::delete/$1');
});

$routes->group('rak', function ($routes) {
    $routes->get('/', 'Rak::index');
    $routes->get('create', 'Rak::create');
    $routes->post('store', 'Rak::store');
    $routes->get('edit/(:num)', 'Rak::edit/$1');
    $routes->post('update/(:num)', 'Rak::update/$1');
    $routes->get('delete/(:num)', 'Rak::delete/$1');
});

$routes->group('pengembalian', function ($routes) {
    $routes->get('/', 'Pengembalian::index');
    $routes->get('create', 'Pengembalian::create');
    $routes->post('store', 'Pengembalian::store');
    $routes->get('detail/(:num)', 'Pengembalian::detail/$1');
    $routes->get('edit/(:num)', 'Pengembalian::edit/$1');
    $routes->post('update/(:num)', 'Pengembalian::update/$1');
    $routes->get('delete/(:num)', 'Pengembalian::delete/$1');
});

$routes->group('anggota', function ($routes) {
    $routes->get('/', 'Anggota::index');
    $routes->get('create', 'Anggota::create');
    $routes->post('store', 'Anggota::store');
    $routes->get('edit/(:num)', 'Anggota::edit/$1');
    $routes->post('update/(:num)', 'Anggota::update/$1');
    $routes->get('delete/(:num)', 'Anggota::delete/$1');
});

// --- Backup & Restore ---
$routes->get('backup', 'Backup::index');
$routes->get('restore', 'Restore::index');
$routes->post('restore/auth', 'Restore::auth');
$routes->get('restore/form', 'Restore::form');
$routes->post('restore/process', 'Restore::process');


$routes->group('peminjaman', ['filter' => 'auth'], function ($routes) {

    // ================= INDEX =================
    $routes->get('/', 'Peminjaman::index');
    $routes->get('index', 'Peminjaman::index');

    // ================= CREATE =================
    $routes->get('create', 'Peminjaman::create');
    $routes->post('store', 'Peminjaman::store');

    // ================= DELETE =================
    $routes->get('delete/(:num)', 'Peminjaman::delete/$1');

    // ================= SEARCH =================
    $routes->get('search', 'Peminjaman::search');

    // ================= STATUS UPDATE =================
    $routes->get('status/(:num)/(:any)', 'Peminjaman::updateStatus/$1/$2');
});


$routes->get('/peminjaman/konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');

$routes->get('/peminjaman/pembayaran/(:num)', 'Peminjaman::pembayaran/$1');
$routes->post('/peminjaman/bayar/(:num)', 'Peminjaman::bayar/$1');

$routes->get('/peminjaman/selesai/(:num)', 'Peminjaman::selesai/$1');
$routes->get('/peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
$routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1');
$routes->get('peminjaman/perpanjang/(:num)', 'Peminjaman::perpanjang/$1');

$routes->group('transaksi', function ($routes) {

    // =====================
    // INDEX
    // =====================
    $routes->get('/', 'Transaksi::index');

    // =====================
    // CREATE
    // =====================
    $routes->get('create', 'Transaksi::create');
    $routes->post('store', 'Transaksi::store');

    // =====================
    // DETAIL
    // =====================
    $routes->get('detail/(:num)', 'Transaksi::detail/$1');

    // =====================
    // DELETE
    // =====================
    $routes->get('delete/(:num)', 'Transaksi::delete/$1');

    // =====================
    // BAYAR
    // =====================
    $routes->get('bayar/(:num)', 'Transaksi::bayar/$1');
});
$routes->get('pengembalian/bayar/(:num)', 'Pengembalian::bayar/$1');
$routes->post('pengembalian/prosesBayar/(:num)', 'Pengembalian::prosesBayar/$1');

$routes->get('penarikan', 'Penarikan::index');
$routes->get('penarikan/create', 'Penarikan::create');
$routes->post('penarikan/store', 'Penarikan::store');

$routes->get('penarikan/edit/(:num)', 'Penarikan::edit/$1');
$routes->post('penarikan/update/(:num)', 'Penarikan::update/$1');

$routes->get('penarikan/delete/(:num)', 'Penarikan::delete/$1');


$routes->get('penarikan/create/(:num)', 'Penarikan::create/$1');
$routes->post('penarikan/store', 'Penarikan::store');
$routes->get('penarikan/ajukan/(:num)', 'Penarikan::ajukan/$1');
$routes->get('penarikan/konfirmasi/(:num)', 'Penarikan::konfirmasi/$1');
$routes->get('penarikan/diambil/(:num)', 'Penarikan::diambil/$1');
$routes->get('penarikan/selesai/(:num)', 'Penarikan::selesai/$1');
$routes->get('penarikan/detail/(:num)', 'Penarikan::detail/$1');
