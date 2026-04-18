<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
    protected $db;
    protected $peminjaman;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->peminjaman = new PeminjamanModel();
    }

    // ================= LIST + SEARCH =================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $builder = $this->db->table('peminjaman');

        $builder->select('
            peminjaman.*,
            users.nama as nama_anggota,
            petugas.jabatan
        ');

        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left');
        $builder->join('users', 'users.id = anggota.user_id', 'left');
        $builder->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');

        // SEARCH NAMA ANGGOTA
        if ($keyword) {
            $builder->like('users.nama', $keyword);
        }

        // FILTER STATUS
        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        $data['peminjaman'] = $builder->get()->getResultArray();

        return view('peminjaman/index', $data);
        foreach ($data['peminjaman'] as &$p) {
            if ($p['status'] == 'dipinjam' && date('Y-m-d') > $p['tanggal_kembali']) {
                $this->peminjamanModel->update($p['id_peminjaman'], [
                    'status' => 'terlambat'
                ]);
                $p['status'] = 'terlambat'; // biar langsung berubah di tampilan
            }
        }
    }

    // ================= CREATE FORM =================
    public function create()
    {
        $data['anggota'] = $this->db->table('anggota')
            ->select('anggota.*, users.nama')
            ->join('users', 'users.id = anggota.user_id')
            ->get()->getResultArray();

        $data['petugas'] = $this->db->table('petugas')
            ->select('petugas.*, users.nama')
            ->join('users', 'users.id = petugas.user_id')
            ->get()->getResultArray();

        $data['buku'] = $this->db->table('buku')->get()->getResultArray();

        return view('peminjaman/create', $data);
    }

    // ================= STORE =================
    public function store()
    {
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam');

        // kalau kosong pakai hari ini
        if (!$tanggal_pinjam) {
            $tanggal_pinjam = date('Y-m-d');
        }

        // otomatis +7 hari
        $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' +7 days'));
        // insert peminjaman
        $this->peminjaman->insert([
            'id_anggota'     => $this->request->getPost('id_anggota'),
            'id_petugas'     => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $tanggal_kembali,
            'status'         => 'dipinjam'
        ]);

        $id_peminjaman = $this->peminjaman->getInsertID();

        // detail buku
        $buku   = $this->request->getPost('id_buku');
        $jumlah = $this->request->getPost('jumlah');

        if ($buku) {
            foreach ($buku as $key => $id_buku) {
                $this->db->table('detail_peminjaman')->insert([
                    'id_peminjaman' => $id_peminjaman,
                    'id_buku'       => $id_buku,
                    'jumlah'        => $jumlah[$key] ?? 1
                ]);
            }
        }

        return redirect()->to('/peminjaman');
    }
    public function detail($id)
    {
        $builder = $this->db->table('detail_peminjaman');

        $builder->select('
        detail_peminjaman.*,
        buku.judul,
        buku.isbn,
        peminjaman.tanggal_pinjam,
        peminjaman.tanggal_kembali,
        peminjaman.status,
        users.nama as nama_anggota,
        petugas.jabatan
    ');

        $builder->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left');
        $builder->join('peminjaman', 'peminjaman.id_peminjaman = detail_peminjaman.id_peminjaman', 'left');
        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left');
        $builder->join('users', 'users.id = anggota.user_id', 'left');
        $builder->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');

        $builder->where('detail_peminjaman.id_peminjaman', $id);

        $data['detail'] = $builder->get()->getResultArray();

        // ambil info header peminjaman (biar rapi di view)
        $data['peminjaman'] = $this->db->table('peminjaman')
            ->select('peminjaman.*, users.nama as nama_anggota, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->where('peminjaman.id_peminjaman', $id)
            ->get()
            ->getRowArray();

        return view('peminjaman/detail', $data);
    }
    // ================= EDIT =================
    public function edit($id)
    {
        // DATA PEMINJAMAN
        $data['peminjaman'] = $this->db->table('peminjaman')
            ->select('peminjaman.*, users.nama as nama_anggota, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->where('peminjaman.id_peminjaman', $id)
            ->get()->getRowArray();

        // DETAIL BUKU
        $data['detail'] = $this->db->table('detail_peminjaman')
            ->select('detail_peminjaman.*, buku.judul')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
            ->where('id_peminjaman', $id)
            ->get()->getResultArray();

        // DROPDOWN DATA
        $data['anggota'] = $this->db->table('anggota')
            ->select('anggota.*, users.nama')
            ->join('users', 'users.id = anggota.user_id')
            ->get()->getResultArray();

        $data['petugas'] = $this->db->table('petugas')
            ->select('petugas.*, users.nama')
            ->join('users', 'users.id = petugas.user_id')
            ->get()->getResultArray();

        $data['buku'] = $this->db->table('buku')->get()->getResultArray();

        return view('peminjaman/edit', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->peminjaman->update($id, [
            'id_anggota'     => $this->request->getPost('id_anggota'),
            'id_petugas'     => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'         => $this->request->getPost('status')
        ]);

        return redirect()->to('/peminjaman');
    }
    // ================= 🔥 KEMBALIKAN =================
    public function kembalikan($id)
    {
        $this->peminjaman->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dikembalikan');
    }


    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjaman->delete($id);
        return redirect()->to('/peminjaman');
    }
}
