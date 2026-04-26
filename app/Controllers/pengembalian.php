<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // ======================
    // LIST DATA
    // ======================
    public function index()
    {
        $model = $this->pengembalianModel;

        $data['pengembalian'] = $model
            ->select('pengembalian.*, peminjaman.tanggal_pinjam,
                      anggota.id_anggota, users.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->findAll();

        return view('pengembalian/index', $data);
    }

    // ======================
    // STORE
    // ======================
    public function store()
    {
        $idPeminjaman = $this->request->getPost('id_peminjaman');

        if (!$idPeminjaman) {
            return redirect()->back()->with('error', 'ID peminjaman tidak valid');
        }

        $peminjaman = $this->peminjamanModel->find($idPeminjaman);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        $tanggalDikembalikan = date('Y-m-d');
        $jatuhTempo = $peminjaman['tanggal_kembali'];

        $selisihHari = (strtotime($tanggalDikembalikan) - strtotime($jatuhTempo)) / 86400;

        $denda = 0;
        $statusPengembalian = 'tepat_waktu';
        $statusBayar = null;

        if ($selisihHari > 0) {
            $denda = $selisihHari * 1000;
            $statusPengembalian = 'terlambat';
            $statusBayar = 'belum_bayar';
        }

        $this->pengembalianModel->save([
            'id_peminjaman' => $idPeminjaman,
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $denda,
            'status_pengembalian' => $statusPengembalian,
            'status_bayar' => $statusBayar
        ]);

        return redirect()->to('/pengembalian')->with('success', 'Berhasil dikembalikan');
    }

    // ======================
    // BAYAR
    // ======================
    public function bayar($id)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID tidak valid');
        }

        $data['pengembalian'] = $this->pengembalianModel
            ->select('pengembalian.*, users.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
            ->join('users', 'users.id = peminjaman.id_anggota')
            ->where('pengembalian.id_pengembalian', $id)
            ->first();

        if (!$data['pengembalian']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengembalian tidak ditemukan');
        }

        return view('pengembalian/pembayaran', $data);
    }

    public function prosesBayar($id)
    {
        $metode = $this->request->getPost('metode');
        $file = $this->request->getFile('bukti');

        $bukti = null;

        if ($metode == 'transfer') {
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $bukti = $file->getRandomName();
                $file->move('uploads/bukti', $bukti);
            } else {
                return redirect()->back()->with('error', 'Upload bukti wajib!');
            }
        }

        $this->pengembalianModel->update($id, [
            'status_bayar' => 'lunas',
            'metode_pembayaran' => $metode,
            'bukti_pembayaran' => $bukti
        ]);

        return redirect()->to('/pengembalian')->with('success', 'Pembayaran berhasil');
    }

    // ======================
    // DETAIL (FIX TOTAL AMAN)
    // ======================
    public function detail($id)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID tidak valid');
        }

        $data['pengembalian'] = $this->pengembalianModel
            ->select('
                pengembalian.*,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.metode_pengantaran,
                peminjaman.alamat,
                users.nama as nama_anggota
            ')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
            ->join('users', 'users.id = peminjaman.id_anggota')
            ->where('pengembalian.id_pengembalian', $id)
            ->first();

        if (!$data['pengembalian']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengembalian tidak ditemukan');
        }

        $detailModel = new \App\Models\DetailPeminjamanModel();

        $data['buku'] = $detailModel
            ->select('detail_peminjaman.*, buku.judul, buku.cover')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $data['pengembalian']['id_peminjaman'])
            ->findAll();

        return view('pengembalian/detail', $data);
    }

    // ======================
    // UPDATE
    // ======================
    public function update($id)
    {
        $this->pengembalianModel->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan')
        ]);

        return redirect()->to('/pengembalian');
    }

    // ======================
    // DELETE
    // ======================
    public function delete($id)
    {
        $this->pengembalianModel->delete($id);
        return redirect()->to('/pengembalian');
    }
}
