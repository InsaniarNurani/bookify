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
        $builder = $this->peminjaman->builder();

        $builder->select('
        peminjaman.*,
        users.nama AS nama_anggota,
        pengembalian.denda,
        pengembalian.tanggal_dikembalikan
    ')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left') // 🔥 INI KUNCI NYA
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->where('peminjaman.id_peminjaman', $id);

        $peminjaman = $builder->get()->getRowArray();

        if (!$peminjaman) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Peminjaman tidak ditemukan');
        }

        // ambil detail buku
        $peminjaman['buku'] = $this->detail->getByPeminjaman($id);

        // fallback
        $peminjaman['nama_anggota'] = $peminjaman['nama_anggota'] ?? '-';
        $peminjaman['denda'] = $peminjaman['denda'] ?? 0;

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
        if (session()->get('role') != 'anggota') {
            return redirect()->back()->with('error', 'Hanya anggota yang bisa meminjam');
        }

        $idAnggota = session()->get('id_anggota');

        $tanggalPinjam = date('Y-m-d');
        $tanggalKembali = date('Y-m-d', strtotime('+7 days'));

        $metode = $this->request->getPost('metode_pengantaran');
        $alamat = $this->request->getPost('alamat');

        // 🔥 ONGKIR FIX
        $ongkir = ($metode == 'diantar') ? 10000 : 0;

        $status = 'dipinjam';
        $status_pengiriman = ($metode == 'diantar') ? 'menunggu_konfirmasi' : null;

        $bukuDipilih = $this->request->getPost('id_buku');

        // ❗ validasi
        if (!$bukuDipilih) {
            return redirect()->back()->with('error', 'Pilih minimal 1 buku');
        }

        if (count($bukuDipilih) > 2) {
            return redirect()->back()->with('error', 'Maksimal 2 buku');
        }

        // ✅ CEK STOK
        foreach ($bukuDipilih as $idBuku) {
            $dataBuku = $this->buku->find($idBuku);

            if (!$dataBuku || $dataBuku['tersedia'] <= 0) {
                return redirect()->back()->with('error', 'Stok buku "' . ($dataBuku['judul'] ?? '') . '" habis!');
            }
        }

        // ✅ SIMPAN PEMINJAMAN (HANYA SEKALI)
        $this->peminjaman->insert([
            'id_anggota' => $idAnggota,
            'id_petugas' => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => $status,
            'metode_pengantaran' => $metode,
            'status_pengiriman' => $status_pengiriman,
            'alamat' => $alamat,
            'ongkir' => $ongkir // 🔥 INI YANG PENTING
        ]);

        $idPeminjaman = $this->peminjaman->insertID();

        // ✅ SIMPAN DETAIL + KURANGI STOK
        foreach ($bukuDipilih as $idBuku) {

            $this->detail->insert([
                'id_peminjaman' => $idPeminjaman,
                'id_buku' => $idBuku,
                'jumlah' => 1
            ]);

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
    public function bayar($id)
    {
        $metode = $this->request->getPost('metode');
        $file   = $this->request->getFile('bukti');

        $bukti = null;

        if ($file && $file->isValid()) {
            $bukti = $file->getRandomName();
            $file->move('uploads/bukti', $bukti);
        }

        // ✅ SIMPAN TRANSAKSI
        $this->transaksi->insert([
            'id_peminjaman' => $id,
            'metode_pembayaran' => $metode,
            'bukti_pembayaran' => $bukti,
            'ongkir' => 10000,
            'total_bayar' => 10000,
            'status' => 'lunas'
        ]);

        // 🔥 WAJIB: UPDATE STATUS PENGIRIMAN
        $this->peminjaman->update($id, [
            'status_pengiriman' => 'diantar'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Pembayaran berhasil');
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
    public function perpanjang($id)
    {
        $p = $this->peminjaman->find($id);

        if (!$p) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ❌ kalau sudah diperpanjang jangan ulang
        if ($p['status'] == 'diperpanjang') {
            return redirect()->back()->with('error', 'Sudah diperpanjang');
        }

        $tglBaru = date('Y-m-d', strtotime($p['tanggal_kembali'] . ' +7 days'));

        $this->peminjaman->update($id, [
            'tanggal_kembali' => $tglBaru,
            'status' => 'diperpanjang'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Berhasil diperpanjang');
    }
    // ================= UPDATE STATUS =================
    public function updateStatus($id, $status)
    {
        $this->peminjaman->update($id, [
            'status' => $status
        ]);

        return redirect()->back();
    }
    public function selesai($id)
    {
        // update status transaksi
        $this->transaksi->update($id, [
            'status' => 'selesai'
        ]);

        // update peminjaman juga (opsional)
        $this->peminjaman->update($id, [
            'status_pengiriman' => 'selesai'
        ]);

        return redirect()->back()->with('success', 'Transaksi selesai');
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
