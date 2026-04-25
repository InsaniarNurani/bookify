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

    // 🔍 READ + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['penarikan'] = $this->penarikan
                ->select('penarikan.*, anggota.nama as nama_anggota')
                ->join('peminjaman', 'peminjaman.id_peminjaman = penarikan.id_peminjaman')
                ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
                ->like('anggota.nama', $keyword)
                ->orLike('penarikan.status', $keyword)
                ->findAll();
        } else {
            $data['penarikan'] = $this->penarikan->getPenarikan();
        }

        return view('penarikan/index', $data);
    }

    // ➕ CREATE FORM
    public function create($id_peminjaman = null)
    {
        $data['id_peminjaman'] = $id_peminjaman;
        return view('penarikan/create', $data);
    }
    public function detail($id)
    {
        $data['penarikan'] = $this->penarikan->getDetail($id);
        return view('penarikan/detail', $data);
    }
    // 💾 INSERT DATA
    public function store()
    {
        $this->penarikan->insert([
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'alamat'        => $this->request->getPost('alamat'),
            'biaya'         => $this->request->getPost('biaya'),
            'status'        => 'menunggu',
            'tanggal_ambil' => $this->request->getPost('tanggal_ambil'),
            'petugas_id'    => $this->request->getPost('petugas_id'),
        ]);

        return redirect()->to('/penarikan');
    }

    // ✏️ EDIT FORM
    public function edit($id)
    {
        $data['penarikan'] = $this->penarikan->find($id);
        return view('penarikan/edit', $data);
    }

    // 🔄 UPDATE DATA
    public function update($id)
    {
        $this->penarikan->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'alamat'        => $this->request->getPost('alamat'),
            'biaya'         => $this->request->getPost('biaya'),
            'status'        => $this->request->getPost('status'),
            'tanggal_ambil' => $this->request->getPost('tanggal_ambil'),
            'petugas_id'    => $this->request->getPost('petugas_id'),
        ]);

        return redirect()->to('/penarikan');
    }
    public function ajukan($id_peminjaman)
    {
        // contoh biaya otomatis (bisa kamu ubah logicnya)
        $biaya = 10000;

        // CEK BIAR TIDAK DOBEL
        $cek = $this->penarikan
            ->where('id_peminjaman', $id_peminjaman)
            ->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Sudah pernah diajukan');
        }

        $this->penarikan->insert([
            'id_peminjaman' => $id_peminjaman,
            'alamat'        => null, // kalau mau ambil dari anggota bisa diisi nanti
            'biaya'         => $biaya,
            'status'        => 'menunggu',
            'tanggal_ambil' => null,
            'petugas_id'    => null
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Penarikan berhasil diajukan');
    }
    public function konfirmasi($id)
    {
        $this->penarikan->update($id, [
            'status' => 'diproses',
            'petugas_id' => session()->get('id')
        ]);

        return redirect()->to('/penarikan');
    }
    public function diambil($id)
    {
        $this->penarikan->update($id, [
            'status' => 'diambil',
            'tanggal_ambil' => date('Y-m-d') // 🔥 otomatis sekarang
        ]);

        return redirect()->to('/penarikan');
    }

    public function selesai($id)
    {
        $this->penarikan->update($id, [
            'status' => 'selesai'
        ]);

        return redirect()->to('/penarikan');
    }
    // ❌ DELETE
    public function delete($id)
    {
        $this->penarikan->delete($id);
        return redirect()->to('/penarikan');
    }
}
