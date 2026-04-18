<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PenerbitModel;
use App\Models\RakModel;
use App\Models\BukuRakModel;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $db;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->db = \Config\Database::connect();
    }

    // ================= INDEX (LIST + SEARCH + PAGINATION) =================
    public function index()
    {
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword);
        }

        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        $data = [
            'buku'     => $builder->paginate(10),
            'pager'    => $this->bukuModel->pager,
            'kategori' => (new KategoriModel())->findAll()
        ];

        return view('buku/index', $data);
    }

    // ================= CREATE FORM =================
    public function create()
    {
        $data = [
            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
        ];

        return view('buku/create', $data);
    }

    // ================= STORE =================
    public function store()
    {
        $file = $this->request->getFile('cover');
        $cover = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $cover = $file->getRandomName();
            $file->move('uploads/buku', $cover);
        }

        $jumlah = (int) $this->request->getPost('jumlah');

        $data = [
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_penulis'   => $this->request->getPost('id_penulis'),
            'id_penerbit'  => $this->request->getPost('id_penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah'       => $jumlah,
            'tersedia'     => $jumlah,
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $cover
        ];

        // simpan buku
        $this->bukuModel->insert($data);
        $id_buku = $this->bukuModel->getInsertID();

        // simpan rak
        $id_rak = $this->request->getPost('id_rak');

        if (!empty($id_rak)) {
            $this->db->table('buku_rak')->insert([
                'id_buku' => $id_buku,
                'id_rak'  => $id_rak
            ]);
        }

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $data['buku'] = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
            ->where('buku.id_buku', $id)
            ->first();

        return view('buku/detail', $data);
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data = [
            'buku' => $this->bukuModel
                ->select('buku.*, buku_rak.id_rak')
                ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
                ->where('buku.id_buku', $id)
                ->first(),

            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
        ];

        return view('buku/edit', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $file = $this->request->getFile('cover');
        $cover = $this->request->getPost('old_cover');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $cover = $file->getRandomName();
            $file->move('uploads/buku', $cover);
        }

        $this->bukuModel->update($id, [
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_penulis'   => $this->request->getPost('id_penulis'),
            'id_penerbit'  => $this->request->getPost('id_penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah'       => $this->request->getPost('jumlah'),
            'tersedia'     => $this->request->getPost('tersedia'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $cover
        ]);

        // update rak
        $this->db->table('buku_rak')
            ->where('id_buku', $id)
            ->update(['id_rak' => $this->request->getPost('id_rak')]);

        return redirect()->to('/buku')->with('success', 'Data berhasil diupdate');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku')->with('success', 'Data berhasil dihapus');
    }

    // ================= PRINT =================
    public function print()
    {
        $data['buku'] = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->findAll();

        return view('buku/print', $data);
    }

    // ================= WHATSAPP =================
    public function wa($id)
    {
        $buku = $this->detailData($id);

        $pesan = "DATA BUKU\n\n";
        foreach ($buku as $key => $value) {
            $pesan .= strtoupper($key) . ": " . $value . "\n";
        }

        return redirect()->to("https://wa.me/6285175017991?text=" . urlencode($pesan));
    }

    private function detailData($id)
    {
        return $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->where('buku.id_buku', $id)
            ->first();
    }
}
