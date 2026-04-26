<?php

namespace App\Controllers;

use App\Models\PenarikanModel;

class Penarikan extends BaseController
{
    protected $penarikanModel;

    public function __construct()
    {
        $this->penarikanModel = new PenarikanModel();
    }

    // ================= LIST + SEARCH =================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->penarikanModel
            ->select('tb_penarikan.*, users.nama AS nama_anggota, peminjaman.alamat AS alamat_pengiriman')
            ->join('peminjaman', 'peminjaman.id_peminjaman = tb_penarikan.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left');

        if ($keyword) {
            $builder->groupStart()
                ->like('tb_penarikan.id_penarikan', $keyword)
                ->orLike('users.nama', $keyword)
                ->orLike('tb_penarikan.status', $keyword)
                ->groupEnd();
        }

        return view('penarikan/index', [
            'penarikan' => $builder->findAll()
        ]);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('penarikan/create');
    }

    // ================= STORE =================
    public function store()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');

        $this->penarikanModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'alamat'        => $this->request->getPost('alamat'), // FIX
            'biaya'         => 0,
            'status'        => 'diajukan',
            'tanggal_ambil' => null,
            'petugas_id'    => null
        ]);

        return redirect()->to('/penarikan')->with('success', 'Penarikan berhasil dibuat');
    }

    // ================= AJUKAN =================
    public function ajukan($id)
    {
        $cek = $this->penarikanModel->where('id_peminjaman', $id)->first();

        if ($cek) {
            return redirect()->to('/penarikan')->with('error', 'Sudah diajukan');
        }

        $this->penarikanModel->insert([
            'id_peminjaman' => $id,
            'alamat'        => '-', // sementara
            'biaya'         => 0,
            'status'        => 'diajukan'
        ]);

        return redirect()->to('/penarikan')->with('success', 'Berhasil diajukan');
    }

    // ================= KONFIRMASI =================
    public function konfirmasi($id)
    {
        $this->penarikanModel->update($id, [
            'status' => 'menunggu_pembayaran',
            'biaya'  => 10000
        ]);

        return redirect()->to('/penarikan');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $data = $this->penarikanModel
            ->select('tb_penarikan.*, users.nama AS nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = tb_penarikan.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->find($id);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('penarikan/detail', [
            'penarikan' => $data
        ]);
    }

    // ================= BAYAR =================
    public function bayar($id)
    {
        return view('penarikan/bayar', [
            'penarikan' => $this->penarikanModel->find($id)
        ]);
    }

    public function prosesBayar($id)
    {
        $this->penarikanModel->update($id, [
            'status' => 'sudah_bayar'
        ]);

        return redirect()->to('/penarikan');
    }

    // ================= AMBIL =================
    public function ambil($id)
    {
        $this->penarikanModel->update($id, [
            'status' => 'diambil',
            'tanggal_ambil' => date('Y-m-d')
        ]);

        return redirect()->to('/penarikan');
    }

    // ================= SELESAI =================
    public function selesai($id)
    {
        $this->penarikanModel->update($id, [
            'status' => 'selesai'
        ]);

        return redirect()->to('/penarikan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data = $this->penarikanModel->find($id);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('penarikan/edit', ['penarikan' => $data]);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->penarikanModel->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'alamat'        => $this->request->getPost('alamat'),
            'biaya'         => $this->request->getPost('biaya'),
            'status'        => $this->request->getPost('status'),
            'tanggal_ambil' => $this->request->getPost('tanggal_ambil'),
            'petugas_id'    => $this->request->getPost('petugas_id'),
        ]);

        return redirect()->to('/penarikan');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->penarikanModel->delete($id);

        return redirect()->to('/penarikan');
    }
}
