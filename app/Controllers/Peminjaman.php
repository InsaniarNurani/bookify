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

        foreach ($peminjaman as &$p) {
            $p['buku'] = $this->detail->getByPeminjaman($p['id_peminjaman']);
        }

        return view('peminjaman/index', [
            'peminjaman' => $peminjaman
        ]);
    }
    public function selesai($id)
    {
        $this->peminjaman->update($id, [
            'status_pengiriman' => 'selesai'
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Pengiriman selesai');
    }
    // ================= DETAIL =================
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
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->where('peminjaman.id_peminjaman', $id);

        $peminjaman = $builder->get()->getRowArray();

        if (!$peminjaman) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Peminjaman tidak ditemukan');
        }

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

        return view('peminjaman/create', [
            'buku' => $this->buku->findAll()
        ]);
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
        $bukuDipilih = $this->request->getPost('id_buku');

        // VALIDASI BUKU
        if (!$bukuDipilih) {
            return redirect()->back()->with('error', 'Pilih minimal 1 buku');
        }

        if (count($bukuDipilih) > 2) {
            return redirect()->back()->with('error', 'Maksimal 2 buku');
        }

        // ALAMAT FIX (TIDAK DUPLIKAT)
        $alamat = ($metode == 'diantar')
            ? $this->request->getPost('alamat')
            : '-';

        if ($metode == 'diantar' && empty($alamat)) {
            return redirect()->back()->with('error', 'Alamat wajib diisi untuk pengantaran');
        }

        $ongkir = ($metode == 'diantar') ? 10000 : 0;

        // CEK STOK
        foreach ($bukuDipilih as $idBuku) {
            $b = $this->buku->find($idBuku);

            if (!$b || $b['tersedia'] <= 0) {
                return redirect()->back()
                    ->with('error', 'Stok buku "' . ($b['judul'] ?? '') . '" habis');
            }
        }

        // SIMPAN PEMINJAMAN
        $this->peminjaman->insert([
            'id_anggota' => $idAnggota,
            'id_petugas' => null,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 'dipinjam',
            'metode_pengantaran' => $metode,
            'status_pengiriman' => ($metode == 'diantar') ? 'menunggu_konfirmasi' : null,
            'alamat' => $alamat,
            'ongkir' => $ongkir
        ]);

        $idPeminjaman = $this->peminjaman->insertID();

        // DETAIL + STOK
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

        return redirect()->to('/peminjaman')
            ->with('success', 'Peminjaman berhasil');
    }
    public function perpanjang($id)
    {
        $p = $this->peminjaman->find($id);

        if (!$p) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

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
    // ================= KEMBALIKAN (INI FIX UTAMA) =================
    public function kembalikan($id)
    {
        $peminjaman = $this->peminjaman->find($id);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $db = \Config\Database::connect();

        $tanggalKembali = date('Y-m-d');
        $jatuhTempo     = $peminjaman['tanggal_kembali'];

        $status = 'kembali';
        $denda  = 0;

        if (strtotime($tanggalKembali) > strtotime($jatuhTempo)) {
            $selisihHari = (strtotime($tanggalKembali) - strtotime($jatuhTempo)) / 86400;
            $denda = $selisihHari * 1000;
            $status = 'terlambat';
        }

        // simpan pengembalian
        $db->table('pengembalian')->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => $tanggalKembali,
            'denda' => $denda
        ]);

        // update status peminjaman
        $this->peminjaman->update($id, [
            'status' => $status
        ]);

        // kembalikan stok buku
        $detail = $this->detail->where('id_peminjaman', $id)->findAll();

        foreach ($detail as $d) {
            $this->buku->set('tersedia', 'tersedia+1', false)
                ->where('id_buku', $d['id_buku'])
                ->update();
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

    public function konfirmasi($id)
    {
        if (session()->get('role') != 'petugas') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $this->peminjaman->update($id, [
            'status_pengiriman' => 'menunggu_pembayaran'
        ]);

        return redirect()->back()->with('success', 'Berhasil dikonfirmasi');
    }

    public function pembayaran($id)
    {
        $data['pinjam'] = $this->peminjaman->find($id);

        return view('peminjaman/pembayaran', $data);
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

        $this->transaksi->insert([
            'id_peminjaman' => $id,
            'metode_pembayaran' => $metode,
            'bukti_pembayaran' => $bukti,
            'ongkir' => 10000,
            'total_bayar' => 10000,
            'status' => 'lunas'
        ]);

        $this->peminjaman->update($id, [
            'status_pengiriman' => 'diantar'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Pembayaran berhasil');
    }

    // ================= AJUKAN PENARIKAN =================
    public function ajukan($id)
    {
        $db = \Config\Database::connect();

        $peminjaman = $db->table('peminjaman')
            ->where('id_peminjaman', $id)
            ->get()
            ->getRowArray();

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        $data = [
            'id_peminjaman' => $id,
            'alamat'        => $peminjaman['alamat'] ?? '-',
            'biaya'         => 0,
            'status'        => 'diajukan',
            'tanggal_ambil' => null,
            'petugas_id'    => null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $insert = $db->table('tb_penarikan')->insert($data);

        // 🔥 DEBUG WAJIB
        if (!$insert) {
            dd($db->error()); // ini akan kasih tahu error asli
        }

        return redirect()->to('/penarikan')
            ->with('success', 'Penarikan berhasil diajukan');
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
        $bukuModel = new BukuModel();

        return view('peminjaman/search', [
            'buku' => $bukuModel->search(
                $this->request->getGet('keyword'),
                $this->request->getGet('kategori')
            )
        ]);
    }
}
