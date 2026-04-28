<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;
use Config\Database;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $session = session();
        $usersModel = new UsersModel();
        $db = Database::connect();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $usersModel->getUsersByUsername($username);

        // USER TIDAK DITEMUKAN
        if (!$users) {
            return redirect()->to('/login')
                ->with('error', 'Username tidak ditemukan');
        }

        // PASSWORD SALAH
        if (!password_verify($password, $users['password'])) {
            return redirect()->to('/login')
                ->with('error', 'Password salah');
        }

        // DATA SESSION DASAR
        $dataSession = [
            'id'        => $users['id'],
            'id_user'   => $users['id'], // tambahan agar bisa dipakai filter anggota
            'nama'      => $users['nama'],
            'email'     => $users['email'],
            'username'  => $users['username'],
            'role'      => $users['role'],
            'foto'      => $users['foto'],
            'logged_in' => true
        ];

        /*
        ==================================================
        KHUSUS ROLE ANGGOTA
        ==================================================
        */
        if ($users['role'] == 'anggota') {

            // cek apakah anggota sudah ada
            $anggota = $db->table('anggota')
                ->where('user_id', $users['id'])
                ->get()
                ->getRowArray();

            // kalau belum ada, buat otomatis
            if (!$anggota) {

                $db->table('anggota')->insert([
                    'user_id' => $users['id']
                ]);

                // ambil ulang data anggota
                $anggota = $db->table('anggota')
                    ->where('user_id', $users['id'])
                    ->get()
                    ->getRowArray();
            }

            // simpan id anggota ke session
            if ($anggota) {
                $dataSession['id_anggota'] = $anggota['id_anggota'];
            }
        }

        /*
        ==================================================
        KHUSUS ROLE PETUGAS
        ==================================================
        */
        if ($users['role'] == 'petugas') {

            $petugas = $db->table('petugas')
                ->where('user_id', $users['id'])
                ->get()
                ->getRowArray();

            if ($petugas) {
                $dataSession['id_petugas'] = $petugas['id_petugas'];
            }
        }

        // SET SESSION
        $session->set($dataSession);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
