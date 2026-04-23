<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $buku;
    protected $db;

    public function __construct()
    {
        $this->buku = new BukuModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->db->table('buku');
        $builder->select('
            buku.*,
            kategori.nama_kategori,
            penulis.nama_penulis,
            penerbit.nama_penerbit,
            rak.nama_rak,
            rak.lokasi
        ');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword);
        }

        $data['buku'] = $builder->get()->getResultArray();

        return view('buku/index', $data);
    }

    public function create()
    {
        $data['kategori'] = $this->db->table('kategori')->get()->getResultArray();
        $data['penulis'] = $this->db->table('penulis')->get()->getResultArray();
        $data['penerbit'] = $this->db->table('penerbit')->get()->getResultArray();
        $data['rak'] = $this->db->table('rak')->get()->getResultArray();

        return view('buku/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // =========================
        // 1. HANDLE KATEGORI
        // =========================
        $id_kategori = $data['id_kategori'];

        if ($id_kategori == 'new') {
            $this->db->table('kategori')->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ]);

            $id_kategori = $this->db->insertID();
        }
        $id_penulis = $this->request->getPost('id_penulis');

        if ($id_penulis == 'new') {
            $this->db->table('penulis')->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ]);

            $id_penulis = $this->db->insertID();
        }
        $id_penerbit = $this->request->getPost('id_penerbit');

        if ($id_penerbit == 'new') {
            $this->db->table('penerbit')->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru')
            ]);

            $id_penerbit = $this->db->insertID();
        }
        // =========================
        // 2. UPLOAD COVER
        // =========================
        $file = $this->request->getFile('cover');
        $cover = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $cover = $file->getRandomName();
            $file->move('uploads/buku', $cover);
        }

        // =========================
        // 3. INSERT BUKU
        // =========================
        $this->buku->insert([
            'judul'        => $data['judul'],
            'isbn'         => $data['isbn'],
            'id_kategori'  => $id_kategori,
            'id_penulis'   => $id_penulis,
            'id_penerbit'  => $id_penerbit,
            'tahun_terbit' => $data['tahun_terbit'],
            'jumlah'       => $data['jumlah'],
            'tersedia'     => $data['tersedia'],
            'deskripsi'    => $data['deskripsi'],
            'cover'        => $cover
        ]);

        $id_buku = $this->buku->getInsertID();

        // =========================
        // 4. INSERT RAK
        // =========================
        $this->db->table('buku_rak')->insert([
            'id_buku' => $id_buku,
            'id_rak'  => $data['id_rak']
        ]);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
    }
    public function detail($id)
    {
        $builder = $this->db->table('buku');
        $builder->select('
            buku.*,
            kategori.nama_kategori,
            penulis.nama_penulis,
            penerbit.nama_penerbit,
            rak.nama_rak,
            rak.lokasi
        ');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');
        $builder->where('buku.id_buku', $id);

        $data['buku'] = $builder->get()->getRowArray();

        return view('buku/detail', $data);
    }

    public function edit($id)
    {
        $data['buku'] = $this->buku->find($id);
        $data['kategori'] = $this->db->table('kategori')->get()->getResultArray();
        $data['penulis'] = $this->db->table('penulis')->get()->getResultArray();
        $data['penerbit'] = $this->db->table('penerbit')->get()->getResultArray();
        $data['rak'] = $this->db->table('rak')->get()->getResultArray();

        return view('buku/edit', $data);
    }

    public function update($id)
    {

        $rules = [
            'judul' => 'required',
            'cover' => 'max_size[cover,2048]|ext_in[cover,jpg,jpeg,png,pdf]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal');
        }
        $data = $this->request->getPost();

        $file = $this->request->getFile('cover');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // hapus file lama
            $buku = $this->buku->find($id);
            if ($buku['cover'] && file_exists('uploads/buku/' . $buku['cover'])) {
                unlink('uploads/buku/' . $buku['cover']);
            }

            // upload baru
            $namaFile = $file->getRandomName();
            $file->move('uploads/buku/', $namaFile);

            $data['cover'] = $namaFile;
        }

        $this->buku->update($id, $data);

        $this->db->table('buku_rak')
            ->where('id_buku', $id)
            ->update(['id_rak' => $data['id_rak']]);

        return redirect()->to('/buku');
    }

    public function delete($id)
    {
        $buku = $this->buku->find($id);

        if ($buku['cover'] && file_exists('uploads/buku/' . $buku['cover'])) {
            unlink('uploads/buku/' . $buku['cover']);
        }

        $this->buku->delete($id);

        return redirect()->to('/buku');
    }

    public function print()
    {
        $data['buku'] = $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->get()->getResultArray();

        return view('buku/print', $data);
    }

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
        return $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->where('buku.id_buku', $id)
            ->get()->getRowArray();
    }
    private function handleInsertIfText($table, $primaryKey, $idField, $nameField, $input)
    {
        if (is_numeric($input)) {
            return $input; // sudah ID
        }

        // cek apakah sudah ada
        $existing = $this->db->table($table)
            ->where($nameField, $input)
            ->get()
            ->getRowArray();

        if ($existing) {
            return $existing[$idField];
        }

        // insert baru
        $this->db->table($table)->insert([
            $nameField => $input
        ]);

        return $this->db->insertID();
    }
}
