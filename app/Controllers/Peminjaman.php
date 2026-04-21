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

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->anggotaModel = new AnggotaModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->findAll();

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
                ->select('anggota.id_anggota, users.nama')
                ->join('users', 'users.id = anggota.user_id', 'left')
                ->findAll(),
            'keyword' => $keyword
        ];

        return view('peminjaman/create', $data);
    }

    // ================= TAMBAH KE KERANJANG =================
    public function tambahDetail()
    {
        $id_buku = $this->request->getPost('id_buku');
        $session = session();

        $buku = $this->bukuModel->find($id_buku);

        // ❗ CEK STOK
        if ($buku['tersedia'] <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis');
        }

        $keranjang = $session->get('keranjang') ?? [];

        $found = false;

        foreach ($keranjang as &$item) {
            if ($item['id_buku'] == $id_buku) {
                $item['jumlah']++;

                if ($item['jumlah'] > $buku['tersedia']) {
                    return redirect()->back()->with('error', 'Stok tidak cukup');
                }

                $found = true;
            }
        }

        if (!$found) {
            $keranjang[] = [
                'id_buku' => $id_buku,
                'judul'   => $buku['judul'],
                'cover'   => $buku['cover'],
                'jumlah'  => 1
            ];
        }

        $session->set('keranjang', $keranjang);

        return redirect()->to('/peminjaman/create');
    }

    // ================= STORE =================
    public function store()
    {
        $keranjang = session()->get('keranjang');

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Belum pilih buku');
        }

        $pinjam = $this->request->getPost('tanggal_pinjam');
        $kembali = $this->request->getPost('tanggal_kembali');

        if ($kembali < $pinjam) {
            return redirect()->back()->with('error', 'Tanggal tidak valid');
        }

        // SIMPAN PEMINJAMAN
        $this->peminjamanModel->insert([
            'id_anggota' => $this->request->getPost('id_anggota'),
            'tanggal_pinjam' => $pinjam,
            'tanggal_kembali' => $kembali,
            'status' => 'dipinjam'
        ]);

        $id = $this->peminjamanModel->insertID();

        foreach ($keranjang as $k) {

            // simpan detail
            $this->detailModel->insert([
                'id_peminjaman' => $id,
                'id_buku' => $k['id_buku'],
                'jumlah' => $k['jumlah']
            ]);

            // ======================
            // KURANGI STOK
            // ======================
            $this->bukuModel->set('tersedia', 'tersedia - ' . $k['jumlah'], false)
                ->where('id_buku', $k['id_buku'])
                ->update();
        }

        session()->remove('keranjang');

        return redirect()->to('/peminjaman');
    }

    // ================= KEMBALIKAN =================
    public function kembalikan($id)
    {
        $pengembalianModel = new PengembalianModel();

        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ambil detail buku
        $detail = $this->detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($detail as $d) {

            // ======================
            // BALIKKAN STOK
            // ======================
            $this->bukuModel->set('tersedia', 'tersedia + ' . $d['jumlah'], false)
                ->where('id_buku', $d['id_buku'])
                ->update();
        }

        // update peminjaman
        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        // simpan pengembalian
        $pengembalianModel->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda' => 0
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman');
    }

    // ================= DETAIL =================
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

    // ================= PERPANJANG =================
    public function perpanjang($id)
    {
        $data = $this->peminjamanModel->find($id);

        $newDate = date('Y-m-d', strtotime($data['tanggal_kembali'] . ' +7 days'));

        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => $newDate
        ]);

        return redirect()->to('/peminjaman');
    }
}
