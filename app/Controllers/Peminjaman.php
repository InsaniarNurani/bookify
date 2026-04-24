<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\TransaksiModel;

class Peminjaman extends BaseController
{
    protected $peminjaman;
    protected $detail;
    protected $buku;
    protected $anggota;
    protected $transaksi;
    public function __construct()
    {
        $this->peminjaman = new PeminjamanModel();
        $this->detail = new DetailPeminjamanModel();
        $this->buku = new BukuModel();
        $this->anggota = new AnggotaModel();
        $this->transaksi = new TransaksiModel();
    }


    // ================= INDEX =================
    public function index()
    {
        $role = session()->get('role');
        $id = session()->get('id_anggota');

        if ($role == 'anggota') {
            $peminjaman = $this->peminjaman->getByAnggota($id);
        } else {
            $peminjaman = $this->peminjaman->getAll();
        }

        // ambil detail buku
        foreach ($peminjaman as &$p) {
            $p['buku'] = $this->detail->getByPeminjaman($p['id_peminjaman']);
        }

        $data['peminjaman'] = $peminjaman;

        return view('peminjaman/index', $data);
    }
    public function detail($id)
    {
        $peminjaman = $this->peminjaman->find($id);

        if (!$peminjaman) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Peminjaman tidak ditemukan');
        }

        // ambil detail buku
        $peminjaman['buku'] = $this->detail->getByPeminjaman($id);

        return view('peminjaman/detail', [
            'peminjaman' => $peminjaman
        ]);
    }
    // ================= CREATE =================
    public function create()
    {
        if (session()->get('role') != 'anggota') {
            return redirect()->to('/peminjaman')->with('error', 'Akses ditolak');
        }

        $data['buku'] = $this->buku->findAll();

        return view('peminjaman/create', $data);
    }
    public function store()
    {
        // 🔐 hanya anggota
        if (session()->get('role') != 'anggota') {
            return redirect()->back()->with('error', 'Hanya anggota yang bisa meminjam');
        }

        $idAnggota = session()->get('id_anggota');

        $tanggalPinjam = date('Y-m-d');
        $tanggalKembali = date('Y-m-d', strtotime('+7 days'));

        // 🔥 ambil metode & alamat
        $metode = $this->request->getPost('metode_pengantaran');
        $alamat = $this->request->getPost('alamat');

        // 🔥 default status
        $status = 'dipinjam';
        $status_pengiriman = null;

        // 🔥 kalau diantar
        if ($metode == 'diantar') {
            $status_pengiriman = 'menunggu_konfirmasi';
        }

        // 🔥 simpan peminjaman
        $this->peminjaman->insert([
            'id_anggota' => $idAnggota,
            'id_petugas' => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => $status,
            'metode_pengantaran' => $metode,
            'status_pengiriman' => $status_pengiriman,
            'alamat' => $alamat
        ]);

        $idPeminjaman = $this->peminjaman->insertID();

        $buku = $this->request->getPost('id_buku');

        // ❗ validasi
        if (!$buku) {
            return redirect()->back()->with('error', 'Pilih minimal 1 buku');
        }

        if (count($buku) > 2) {
            return redirect()->back()->with('error', 'Maksimal 2 buku');
        }

        foreach ($buku as $id) {
            $this->detail->insert([
                'id_peminjaman' => $idPeminjaman,
                'id_buku' => $id,
                'jumlah' => 1
            ]);
        }
        $bukuDipilih = $this->request->getPost('id_buku');

        // ❗ validasi kosong
        if (!$bukuDipilih) {
            return redirect()->back()->with('error', 'Pilih minimal 1 buku');
        }

        // ❗ maksimal 2
        if (count($bukuDipilih) > 2) {
            return redirect()->back()->with('error', 'Maksimal 2 buku');
        }

        $bukuDipilih = $this->request->getPost('id_buku');

        // ✅ CEK STOK DULU
        foreach ($bukuDipilih as $idBuku) {
            $dataBuku = $this->buku->find($idBuku);

            if (!$dataBuku || $dataBuku['tersedia'] <= 0) {
                return redirect()->back()->with('error', 'Stok buku "' . ($dataBuku['judul'] ?? '') . '" habis!');
            }
        }

        // ✅ SIMPAN PEMINJAMAN
        $this->peminjaman->insert([
            'id_anggota' => $idAnggota,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 'dipinjam',
            'metode_pengantaran' => $metode,
            'status_pengiriman' => $status_pengiriman,
            'alamat' => $alamat
        ]);

        $idPeminjaman = $this->peminjaman->insertID();

        // ✅ SIMPAN DETAIL + KURANGI STOK
        foreach ($bukuDipilih as $idBuku) {

            // simpan detail
            $this->detail->insert([
                'id_peminjaman' => $idPeminjaman,
                'id_buku' => $idBuku,
                'jumlah' => 1
            ]);

            // 🔥 KURANGI STOK
            $this->buku->set('tersedia', 'tersedia-1', false)
                ->where('id_buku', $idBuku)
                ->update();
        }
        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil');
    }
    // ✅ KONFIRMASI (petugas)
    public function konfirmasi($id)
    {
        if (session()->get('role') != 'petugas') return redirect()->back();

        $this->peminjaman->update($id, [
            'status_pengiriman' => 'menunggu_pembayaran'
        ]);

        return redirect()->back();
    }

    // ✅ HALAMAN PEMBAYARAN
    public function pembayaran($id)
    {
        return view('peminjaman/pembayaran', ['id' => $id]);
    }
    public function formBayar($id)
    {
        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksi = $transaksiModel->find($id);

        // contoh hitung ongkir
        $ongkir = 10000;

        // contoh total (sesuaikan field kamu)
        $total = $transaksi['total_harga'] + $ongkir;

        return view('peminjaman/pembayaran', [
            'id'     => $id,
            'ongkir' => $ongkir,
            'total'  => $total
        ]);
    }
    // ✅ PROSES BAYAR
    public function bayar($id)
    {
        $metode = $this->request->getPost('metode');
        $file   = $this->request->getFile('bukti');

        $transaksiModel = new \App\Models\TransaksiModel();

        // default
        $bukti = null;
        $status = null;

        // =========================
        // 1. COD
        // =========================
        if ($metode == 'cod') {

            $status = 'cod_diproses';
        }

        // =========================
        // 2. TRANSFER / DANA
        // =========================
        elseif (in_array($metode, ['transfer', 'dana'])) {

            // WAJIB bukti
            if (!$file || !$file->isValid()) {
                return redirect()->back()->with('error', 'Bukti pembayaran wajib diupload!');
            }

            $newName = $file->getRandomName();
            $file->move('uploads/bukti', $newName);

            $bukti = $newName;
            $status = 'menunggu_verifikasi';
        }

        // =========================
        // UPDATE DATABASE
        // =========================
        $transaksiModel->update($id, [
            'metode_pembayaran' => $metode,
            'bukti_pembayaran'  => $bukti,
            'status'            => $status
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Pembayaran berhasil diproses');
    }
    // ✅ SELESAI (petugas)
    public function selesai($id)
    {
        if (session()->get('role') != 'petugas') return redirect()->back();

        $this->peminjaman->update($id, [
            'status_pengiriman' => 'selesai'
        ]);

        return redirect()->back();
    }

    // ✅ KEMBALIKAN
    public function kembalikan($id)
    {
        // 🔐 hanya petugas
        if (session()->get('role') != 'petugas') {
            return redirect()->back();
        }

        // 🔍 ambil data peminjaman
        $peminjaman = $this->peminjaman->find($id);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // 🔌 koneksi database (FIX CI4)
        $db = \Config\Database::connect();

        $tanggalKembali = date('Y-m-d');
        $jatuhTempo = $peminjaman['tanggal_kembali'];

        // 🔥 default status
        $status = 'kembali';
        $totalDenda = 0;

        // 🔥 cek keterlambatan
        if (strtotime($tanggalKembali) > strtotime($jatuhTempo)) {

            $selisihHari = (strtotime($tanggalKembali) - strtotime($jatuhTempo)) / 86400;

            $totalDenda = 0;
            $status = 'kembali';

            if ($selisihHari > 0) {
                $totalDenda = $selisihHari * 1000;
                $status = 'terlambat';
            }
            // simpan pengembalian
            $db->table('pengembalian')->insert([
                'id_peminjaman' => $id,
                'tanggal_dikembalikan' => $tanggalKembali,
                'denda' => $totalDenda
            ]);

            $idPengembalian = $db->insertID();

            // simpan denda
            $db->table('denda')->insert([
                'id_pengembalian' => $idPengembalian,
                'jumlah_denda' => $totalDenda,
                'status' => 'belum_bayar'
            ]);
        }
        // =========================
        // 1. INSERT PENGEMBALIAN
        // =========================
        $db->table('pengembalian')->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => $tanggalKembali,
            'denda' => $totalDenda
        ]);

        $idPengembalian = $db->insertID();

        // =========================
        // 2. INSERT DENDA (jika ada)
        // =========================
        if ($totalDenda > 0) {
            $db->table('denda')->insert([
                'id_pengembalian' => $idPengembalian,
                'jumlah_denda' => $totalDenda,
                'status' => 'belum_bayar'
            ]);
        }

        // =========================
        // 3. UPDATE PEMINJAMAN
        // =========================
        $this->peminjaman->update($id, [
            'status' => $status
        ]);

        // =========================
        // 4. KEMBALIKAN STOK BUKU
        // =========================
        $detail = $this->detail->where('id_peminjaman', $id)->findAll();

        foreach ($detail as $d) {
            $this->buku->set('tersedia', 'tersedia+1', false)
                ->where('id_buku', $d['id_buku'])
                ->update();
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= UPDATE STATUS =================
    public function updateStatus($id, $status)
    {
        $this->peminjaman->update($id, [
            'status' => $status
        ]);

        return redirect()->back();
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjaman->delete($id);
        return redirect()->to('/peminjaman');
    }

    // ================= SEARCH =================
    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $bukuModel = new BukuModel();

        $data['buku'] = $bukuModel->search($keyword, $kategori);

        return view('peminjaman/search', $data);
    }
}
