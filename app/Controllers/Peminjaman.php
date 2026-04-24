<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\AnggotaModel;

class Peminjaman extends BaseController
{
    protected $peminjaman;
    protected $detail;
    protected $buku;
    protected $anggota;

    public function __construct()
    {
        $this->peminjaman = new PeminjamanModel();
        $this->detail = new DetailPeminjamanModel();
        $this->buku = new BukuModel();
        $this->anggota = new AnggotaModel();
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

        // 🔥 CEK STOK DULU
        foreach ($bukuDipilih as $idBuku) {
            $dataBuku = $this->buku->find($idBuku);

            if ($dataBuku['stok'] <= 0) {
                return redirect()->back()->with('error', 'Stok buku "' . $dataBuku['judul'] . '" habis!');
            }
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

    // ✅ PROSES BAYAR
    public function bayar($id)
    {
        $this->peminjaman->update($id, [
            'status_pengiriman' => 'diantar'
        ]);

        return redirect()->to('/peminjaman');
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
        if (session()->get('role') != 'petugas') return redirect()->back();

        $this->peminjaman->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->back();
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
