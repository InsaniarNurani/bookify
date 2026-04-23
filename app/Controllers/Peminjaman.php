<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\PengembalianModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->bukuModel = new BukuModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $keyword = $this->request->getGet('search');

        $peminjaman = $this->peminjamanModel->getAll(
            $keyword,
            session()->get('id_anggota'),
            session()->get('role')
        );

        // ================= AMBIL BUKU =================
        foreach ($peminjaman as &$p) {
            $p['buku'] = $this->detailModel
                ->select('buku.judul')
                ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
                ->where('detail_peminjaman.id_peminjaman', $p['id_peminjaman'])
                ->findAll();
        }

        return view('peminjaman/index', [
            'peminjaman' => $peminjaman
        ]);
    }

    // ================= CREATE =================
    public function create()
    {
        $data['buku'] = $this->bukuModel->findAll();
        return view('peminjaman/create', $data);
    }

    // ================= STORE =================
    public function store()
    {
        $selectedBuku = $this->request->getPost('buku');

        if (!$selectedBuku || count($selectedBuku) > 2) {
            return redirect()->back()->with('error', 'Pilih maksimal 2 buku');
        }

        $id_anggota = session()->get('id_anggota');

        if (!$id_anggota) {
            return redirect()->back()->with('error', 'Session anggota tidak ditemukan');
        }

        // ================= STATUS =================
        $status = 'dipinjam';
        $status_pengiriman = null;

        if ($this->request->getPost('metode') == 'antar') {
            $status = 'menunggu_konfirmasi';
            $status_pengiriman = 'menunggu_konfirmasi';
        }

        // ================= SIMPAN PEMINJAMAN =================
        $this->peminjamanModel->save([
            'id_anggota' => $id_anggota,
            'id_petugas' => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status' => $status,
            'metode_pengantaran' => $this->request->getPost('metode'),
            'status_pengiriman' => $status_pengiriman
        ]);

        $id = $this->peminjamanModel->insertID();

        // ================= DETAIL + KURANGI STOK =================
        foreach ($selectedBuku as $buku) {

            $this->detailModel->save([
                'id_peminjaman' => $id,
                'id_buku' => $buku,
                'jumlah' => 1
            ]);

            // ambil data buku
            $dataBuku = $this->bukuModel->find($buku);

            if ($dataBuku && $dataBuku['jumlah'] > 0) {
                $this->bukuModel->update($buku, [
                    'jumlah' => $dataBuku['jumlah'] - 1
                ]);
            }
        }

        return redirect()->to('/peminjaman');
    }

    // ================= KONFIRMASI PETUGAS =================
    public function konfirmasi($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengiriman' => 'menunggu_pembayaran',
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect()->back();
    }
    public function edit($id)
    {
        $data['peminjaman'] = $this->peminjamanModel->find($id);

        if (!$data['peminjaman']) {
            return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
        }

        return view('peminjaman/edit', $data);
    }
    // ================= PEMBAYARAN =================
    public function pembayaran($id)
    {
        $data = [
            'peminjaman' => $this->peminjamanModel->find($id),
            'ongkir' => 10000
        ];

        return view('peminjaman/pembayaran', $data);
    }

    public function prosesBayar($id)
    {
        $metode = $this->request->getPost('metode');
        $file = $this->request->getFile('bukti');

        if (!$metode) {
            return redirect()->back()->with('error', 'Pilih metode pembayaran');
        }

        // ================= UPLOAD FILE =================
        $namaFile = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // buat nama random
            $namaFile = $file->getRandomName();

            // simpan ke folder public/uploads/bukti
            $file->move('uploads/bukti', $namaFile);
        }

        // ================= UPDATE DB =================
        $this->peminjamanModel->update($id, [
            'status_pengiriman' => 'diantar',
            'status' => 'diantar',
            'metode_pembayaran' => $metode,
            'bukti_pembayaran' => $namaFile
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Pembayaran berhasil');
    }

    // ================= SELESAI =================
    public function selesai($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengiriman' => 'selesai',
            'status' => 'selesai'
        ]);

        return redirect()->back();
    }
    public function kembalikan($id)

    {
        // ambil data peminjaman
        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ================= SIMPAN KE TABEL PENGEMBALIAN =================
        $pengembalianModel = new \App\Models\PengembalianModel();

        $pengembalianModel->save([
            'id_peminjaman' => $id,
            'tanggal_kembali' => date('Y-m-d')
        ]);

        // ================= AMBIL DETAIL BUKU =================
        $detail = $this->detailModel
            ->where('id_peminjaman', $id)
            ->findAll();

        // ================= TAMBAH STOK =================
        foreach ($detail as $d) {
            $buku = $this->bukuModel->find($d['id_buku']);

            if ($buku) {
                $this->bukuModel->update($d['id_buku'], [
                    'jumlah' => $buku['jumlah'] + $d['jumlah']
                ]);
            }
        }

        // ================= UPDATE STATUS =================
        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dikembalikan');
    }
    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->back();
    }
    public function detail($id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('peminjaman');

        $builder->select('
        peminjaman.*,
        users.nama as nama_anggota
    ');

        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left');
        $builder->join('users', 'users.id = anggota.user_id', 'left');

        $builder->where('peminjaman.id_peminjaman', $id);

        $data['peminjaman'] = $builder->get()->getRowArray();

        if (!$data['peminjaman']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('peminjaman/detail', $data);
    }
    public function perpanjang($id, $hari)
    {
        $data = $this->peminjamanModel->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // 🔥 TAMBAH TANGGAL KEMBALI
        $tanggal_lama = $data['tanggal_kembali'];

        $tanggal_baru = date('Y-m-d', strtotime($tanggal_lama . ' +' . $hari . ' days'));

        // 🔥 UPDATE
        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => $tanggal_baru,
            'status' => 'diperpanjang',
            'lama_perpanjangan' => $hari
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Berhasil diperpanjang');
    }
    public function print()
    {
        $peminjaman = $this->peminjamanModel->getAll();

        foreach ($peminjaman as &$p) {
            $p['buku'] = $this->detailModel
                ->select('buku.judul')
                ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
                ->where('detail_peminjaman.id_peminjaman', $p['id_peminjaman'])
                ->findAll();
        }

        return view('peminjaman/print', [
            'peminjaman' => $peminjaman
        ]);
    }
    public function printDetail($id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('peminjaman');

        $builder->select('
        peminjaman.*,
        u1.username as nama_anggota,
        u2.username as nama_petugas
    ');

        // join anggota → users
        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left');
        $builder->join('users u1', 'u1.id = anggota.user_id', 'left');

        // join petugas → users
        $builder->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');
        $builder->join('users u2', 'u2.id = petugas.user_id', 'left');

        $builder->where('peminjaman.id_peminjaman', $id);

        $data['peminjaman'] = $builder->get()->getRowArray();

        return view('peminjaman/print_detail', $data);
    }
}
