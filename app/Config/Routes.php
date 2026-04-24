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
$routes->group('users', function ($routes) use ($intRole, $allRole) {
    $routes->get('/', 'Users::index', $intRole);
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1', $allRole);
    $routes->post('update/(:num)', 'Users::update/$1', $allRole);
    $routes->get('delete/(:num)', 'Users::delete/$1', $allRole);
    $routes->get('detail/(:num)', 'Users::detail/$1', $allRole);
    $routes->get('print', 'Users::print', $allRole);
    $routes->get('wa/(:num)', 'Users::wa/$1', $allRole);
});

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

// --- Modul: Peminjaman ---
$routes->group('peminjaman', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Peminjaman::index');
    $routes->get('create', 'Peminjaman::create');
    $routes->post('store', 'Peminjaman::store');
    $routes->get('delete/(:num)', 'Peminjaman::delete/$1');
    $routes->get('detail/(:num)', 'Peminjaman::detail/$1');
    $routes->get('print', 'Peminjaman::print');

    // Status Flow
    $routes->get('konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1');
    $routes->get('bayar/(:num)', 'Peminjaman::bayar/$1');
    $routes->get('antar/(:num)', 'Peminjaman::antar/$1');
    $routes->get('selesai/(:num)', 'Peminjaman::selesai/$1');
    $routes->get('pembayaran/(:num)', 'Peminjaman::pembayaran/$1');
    $routes->post('prosesBayar/(:num)', 'Peminjaman::prosesBayar/$1');
    $routes->get('kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
    $routes->get('perpanjang/(:num)/(:num)', 'Peminjaman::perpanjang/$1/$2');
    $routes->get('printDetail/(:num)', 'Peminjaman::printDetail/$1');
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
