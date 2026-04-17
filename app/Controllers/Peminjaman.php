<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\PetugasModel;

class Peminjaman extends BaseController
{
    protected $peminjaman;
    protected $anggota;
    protected $petugas;

    public function __construct()
    {
        $this->peminjaman = new PeminjamanModel();
        $this->anggota    = new AnggotaModel();
        $this->petugas    = new PetugasModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $builder = $this->peminjaman
            ->select('peminjaman.*, anggota.nis, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');

        // SEARCH
        if ($keyword) {
            $builder->groupStart()
                ->like('anggota.nis', $keyword)
                ->orLike('petugas.jabatan', $keyword)
                ->groupEnd();
        }

        // FILTER STATUS
        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        $data = [
            'peminjaman' => $builder->paginate(10),
            'pager'      => $this->peminjaman->pager
        ];

        return view('peminjaman/index', $data);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('peminjaman/create', [
            'anggota' => $this->anggota->findAll(),
            'petugas' => $this->petugas->findAll()
        ]);
    }

    // ================= STORE =================
    public function store()
    {
        $this->peminjaman->save([
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status') ?? 'dipinjam'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data = [
            'peminjaman' => $this->peminjaman->find($id),
            'anggota'    => $this->anggota->findAll(),
            'petugas'    => $this->petugas->findAll()
        ];

        return view('peminjaman/edit', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->peminjaman->update($id, [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status')
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil diupdate');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjaman->delete($id);

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil dihapus');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $data = $this->peminjaman
            ->select('peminjaman.*, anggota.nis, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        if (!$data) {
            return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
        }

        return view('peminjaman/detail', [
            'peminjaman' => $data
        ]);
    }

    // ================= PRINT =================
    public function print()
    {
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $query = $this->peminjaman
            ->select('peminjaman.*, anggota.nis, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');

        if ($keyword) {
            $query->groupStart()
                ->like('anggota.nis', $keyword)
                ->orLike('petugas.jabatan', $keyword)
                ->groupEnd();
        }

        if ($status) {
            $query->where('peminjaman.status', $status);
        }

        return view('peminjaman/print', [
            'peminjaman' => $query->findAll()
        ]);
    }
}
