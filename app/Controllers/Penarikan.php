<?php

namespace App\Controllers;

use App\Models\PenarikanModel;

class Penarikan extends BaseController
{
    protected $penarikan;

    public function __construct()
    {
        $this->penarikan = new PenarikanModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->penarikan;

        if ($keyword) {
            $data['penarikan'] = $builder
                ->select('penarikan.*, users.nama as nama_anggota')
                ->join('peminjaman', 'peminjaman.id_peminjaman = penarikan.id_peminjaman')
                ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
                ->join('users', 'users.id = anggota.user_id')
                ->like('users.nama', $keyword)
                ->orLike('penarikan.status', $keyword)
                ->findAll();
        } else {
            $data['penarikan'] = $this->penarikan->getPenarikan();
        }

        return view('penarikan/index', $data);
    }

    public function create($id_peminjaman = null)
    {
        return view('penarikan/create', [
            'id_peminjaman' => $id_peminjaman
        ]);
    }

    public function store()
    {
        $this->penarikan->insert([
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'alamat'        => $this->request->getPost('alamat'),
            'biaya'         => 10000,
            'status'        => 'menunggu'
        ]);

        return redirect()->to('/penarikan');
    }

    public function detail($id)
    {
        return view('penarikan/detail', [
            'penarikan' => $this->penarikan->getDetail($id)
        ]);
    }

    public function edit($id)
    {
        return view('penarikan/edit', [
            'penarikan' => $this->penarikan->find($id)
        ]);
    }

    // ✅ FIXED INI
    public function pembayaran($id = null)
    {
        $data['penarikan'] = $this->penarikan->find($id);

        if (!$data['penarikan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('penarikan/pembayaran', $data);
    }
    public function prosesBayar($id)
    {
        $this->penarikan->update($id, [
            'status' => 'diproses'
        ]);

        return redirect()->to('/penarikan');
    }
    public function update($id)
    {
        $this->penarikan->update($id, [
            'alamat'        => $this->request->getPost('alamat'),
            'biaya'         => $this->request->getPost('biaya'),
            'status'        => $this->request->getPost('status'),
            'tanggal_ambil' => $this->request->getPost('tanggal_ambil'),
        ]);

        return redirect()->to('/penarikan');
    }

    public function delete($id)
    {
        $this->penarikan->delete($id);
        return redirect()->to('/penarikan');
    }
}
