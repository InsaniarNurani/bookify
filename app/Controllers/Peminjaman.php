<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\PengembalianModel;

class Peminjaman extends BaseController
{
    protected $bukuModel;
    protected $anggotaModel;
    protected $peminjamanModel;
    protected $detailModel;
    protected $pengembalianModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->anggotaModel = new AnggotaModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->pengembalianModel = new PengembalianModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $builder = $this->peminjamanModel
            ->select('peminjaman.*, users.nama as nama_user, anggota.alamat, petugas.nama as nama_petugas')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->join('users as petugas', 'petugas.id = peminjaman.id_petugas', 'left');

        // 🔥 USER hanya lihat data sendiri
        if (session()->get('role') != 'admin') {
            $builder->where('anggota.user_id', session()->get('id'));
        }

        $data['peminjaman'] = $builder->findAll();

        return view('peminjaman/index', $data);
    }

    // ================= CREATE =================
    public function create()
    {
        $keyword = $this->request->getGet('keyword');

        $buku = $this->bukuModel;

        if ($keyword) {
            $buku = $buku->like('judul', $keyword);
        }

        $data = [
            'buku' => $buku->findAll(),
            'anggota' => $this->anggotaModel
                ->select('anggota.id_anggota, anggota.alamat, users.nama')
                ->join('users', 'users.id = anggota.user_id', 'left')
                ->findAll(),
            'keyword' => $keyword
        ];

        return view('peminjaman/create', $data);
    }

    // ================= STORE =================
    public function store()
    {
        $id_anggota = session()->get('id_anggota');

        if (!$id_anggota) {
            return redirect()->to('/login')->with('error', 'Silakan login dulu');
        }

        $data = [
            'id_anggota'     => $id_anggota,
            'id_petugas'     => session()->get('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'metode'         => $this->request->getPost('metode'),
            'alamat'         => $this->request->getPost('alamat'),
            'status'         => 'diproses'
        ];

        $this->peminjamanModel->insert($data);

        return redirect()->to('/peminjaman');
    }
    // ================= EDIT =================
    public function detail($id)
    {
        $data['detail'] = $this->detailModel
            ->select('detail_peminjaman.*, buku.judul, buku.cover, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, peminjaman.status')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->join('peminjaman', 'peminjaman.id_peminjaman = detail_peminjaman.id_peminjaman')
            ->where('detail_peminjaman.id_peminjaman', $id)
            ->findAll();

        return view('peminjaman/detail', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali')
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil diupdate');
    }

    // ================= PERPANJANG =================
    public function perpanjang($id)
    {
        $data = $this->peminjamanModel->find($id);

        if (!$data) {
            return redirect()->back();
        }

        $newDate = date('Y-m-d', strtotime($data['tanggal_kembali'] . ' +7 days'));

        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => $newDate,
            'status' => 'diperpanjang',
            'jumlah_perpanjang' => ($data['jumlah_perpanjang'] ?? 0) + 1
        ]);

        return redirect()->to('/peminjaman');
    }
    // ================= KONFIRMASI =================
    public function konfirmasi($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'diantar'
        ]);

        return redirect()->to('/peminjaman');
    }
    // ================= KEMBALIKAN =================
    public function kembalikan($id)
    {
        $peminjamanModel = new \App\Models\PeminjamanModel();
        $detailModel = new \App\Models\DetailPeminjamanModel();
        $bukuModel = new \App\Models\BukuModel();
        $pengembalianModel = new \App\Models\PengembalianModel();

        // 1. update status peminjaman
        $peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        // 2. ambil semua buku dari detail peminjaman
        $detail = $detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($detail as $d) {

            // 3. ambil data buku
            $buku = $bukuModel->find($d['id_buku']);

            // 4. update stok (TAMBAH STOK)
            $bukuModel->update($d['id_buku'], [
                'tersedia' => $buku['tersedia'] + $d['jumlah']
            ]);
        }

        // 5. simpan ke pengembalian
        $pengembalianModel->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda' => 0
        ]);

        return redirect()->to('/peminjaman');
    }

    public function tambahDetail()
    {
        $id_buku = $this->request->getPost('id_buku');

        $buku = $this->bukuModel->find($id_buku);

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        $keranjang = session()->get('keranjang') ?? [];

        // =====================
        // 🔥 BATAS MAKSIMAL 2 BUKU (WAJIB DI CONTROLLER)
        // =====================
        if (!isset($keranjang[$id_buku]) && count($keranjang) >= 2) {
            return redirect()->back()->with('error', 'Maksimal hanya 2 buku yang boleh dipilih');
        }

        // kalau sudah ada → tambah jumlah
        if (isset($keranjang[$id_buku])) {
            $keranjang[$id_buku]['jumlah'] += 1;
        } else {
            $keranjang[$id_buku] = [
                'id_buku' => $id_buku,
                'judul' => $buku['judul'],
                'cover' => $buku['cover'],
                'jumlah' => 1
            ];
        }

        session()->set('keranjang', $keranjang);

        return redirect()->back();
    }
    public function hapus($id_buku)
    {
        $keranjang = session()->get('keranjang') ?? [];

        if (isset($keranjang[$id_buku])) {
            unset($keranjang[$id_buku]);
            session()->set('keranjang', $keranjang);
        }

        return redirect()->back();
    }



    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman');
    }
}
