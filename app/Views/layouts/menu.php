   <a href="#">
       <b>bookify</b>App
   </a><br>

   <a href="<?= base_url('/') ?>">
       Dashboard
   </a><br>

   <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
       <a href="<?= base_url('/users') ?>">
           Users
       </a><br>
   <?php endif; ?>
   <?php $idu = session('id'); ?>
   <a href="<?= base_url('users/edit/' . $idu) ?>">
       Setting
   </a><br>

   <?php if (session()->get('role') != 'anggota') : ?>
       <a href="<?= base_url('buku') ?>">Data Buku</a>
       </a><br>
   <?php endif; ?>
   <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
       <a href="<?= base_url('/penulis') ?>">
           Penulis
       </a><br>
   <?php endif; ?>
   <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
       <a href="<?= base_url('/penerbit') ?>">
           Penerbit
       </a><br>
   <?php endif; ?>
   <a href="<?= base_url('peminjaman') ?>">
       Peminjaman
   </a><br>

   <a href="<?= base_url('pengembalian') ?>">
       Pengembalian
   </a><br>
   <?php if (session()->get('role') == 'admin') : ?>
       <a href="<?= base_url('rak') ?>">
           Rak
       </a><br>
   <?php endif; ?>
   <?php if (session()->get('role') == 'admin') : ?>
       <a href="<?= base_url('/backup') ?>">Backup Database</a>
   <?php endif; ?>
   <li>
       <a href="<?= base_url('/logout') ?>">Log Out</a>
   </li>
   <br>
   Masuk sebagai: <b><?= session('nama'); ?> (<?= session('role'); ?>)</b>
   <br>
   <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" height="80" />