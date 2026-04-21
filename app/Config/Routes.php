<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$petugas     = ['filter' => 'role:petugas'];
$anggota     = ['filter' => 'role:anggota'];
$intRole   = ['filter' => 'role:admin, petugas,'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];


// Login
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// Halaman utama
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);

$routes->get('/users/create', 'Users::create'); // form tambah user
$routes->post('/users/store', 'Users::store'); // aksi simpan user

$routes->get('/users', 'Users::index', $intRole); // menampilkan data user hanya untuk admin dan petugas
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole); // form edit user
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); // aksi update user
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); // aksi hapus user
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); // aksi detail user
$routes->get('users/print', 'Users::print', $allRole); // aksi print data user
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); // aksi kirim ke whatsapp

// ================= BUKU =================
// tampil 
$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');
$routes->get('/peminjaman', 'Peminjaman::index'); // list data

$routes->get('/peminjaman/create', 'Peminjaman::create'); // form tambah
$routes->post('/peminjaman/store', 'Peminjaman::store'); // simpan data

$routes->get('/peminjaman/edit/(:num)', 'Peminjaman::edit/$1'); // form edit
$routes->post('/peminjaman/update/(:num)', 'Peminjaman::update/$1'); // update data

$routes->get('/peminjaman/delete/(:num)', 'Peminjaman::delete/$1'); // hapus data

$routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1'); // detail peminjaman

$routes->get('/peminjaman/print', 'Peminjaman::print'); // print data

$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');


$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

$routes->get('penulis', 'Penulis::index');
$routes->get('penulis/create', 'Penulis::create');
$routes->post('penulis/store', 'Penulis::store');

$routes->get('penulis/edit/(:num)', 'Penulis::edit/$1');
$routes->post('penulis/update/(:num)', 'Penulis::update/$1');

$routes->get('penulis/delete/(:num)', 'Penulis::delete/$1');

$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');

// ================= PENERBIT =================
$routes->get('/penerbit', 'Penerbit::index');
$routes->get('/penerbit/create', 'Penerbit::create');
$routes->post('/penerbit/store', 'Penerbit::store');

$routes->get('/penerbit/edit/(:num)', 'Penerbit::edit/$1');
$routes->post('/penerbit/update/(:num)', 'Penerbit::update/$1');

$routes->get('/penerbit/delete/(:num)', 'Penerbit::delete/$1');

$routes->group('rak', function ($routes) {

    $routes->get('/', 'Rak::index');
    $routes->get('create', 'Rak::create');
    $routes->post('store', 'Rak::store');

    $routes->get('edit/(:num)', 'Rak::edit/$1');
    $routes->post('update/(:num)', 'Rak::update/$1');

    $routes->get('delete/(:num)', 'Rak::delete/$1');
});


$routes->get('/pengembalian', 'Pengembalian::index');
$routes->get('/pengembalian/create', 'Pengembalian::create');
$routes->post('/pengembalian/store', 'Pengembalian::store');
$routes->get('/pengembalian/detail/(:num)', 'Pengembalian::detail/$1');
$routes->get('/pengembalian/edit/(:num)', 'Pengembalian::edit/$1');
$routes->post('/pengembalian/update/(:num)', 'Pengembalian::update/$1');
$routes->get('/pengembalian/delete/(:num)', 'Pengembalian::delete/$1');

$routes->get('anggota', 'Anggota::index');
$routes->get('anggota/create', 'Anggota::create');
$routes->post('anggota/store', 'Anggota::store');
$routes->get('anggota/edit/(:num)', 'Anggota::edit/$1');
$routes->post('anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('anggota/delete/(:num)', 'Anggota::delete/$1');


$routes->get('/peminjaman/create', 'Peminjaman::create');
$routes->post('/peminjaman/store', 'Peminjaman::store');
$routes->post('/peminjaman/tambahDetail', 'Peminjaman::tambahDetail');
$routes->post('/peminjaman/updateJumlah', 'Peminjaman::updateJumlah');
$routes->get('/peminjaman/hapus/(:num)', 'Peminjaman::hapus/$1');
$routes->get('peminjaman/perpanjang/(:num)', 'Peminjaman::perpanjang/$1');
$routes->get('peminjaman/edit/(:num)', 'Peminjaman::edit/$1');
$routes->post('peminjaman/update/(:num)', 'Peminjaman::update/$1');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
