<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;
use CodeIgniter\Controller;

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
        $anggotaModel = new AnggotaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $usersModel->getUsersByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {

                // ================= AMBIL ID ANGGOTA =================
                $idAnggota = null;

                if ($users['role'] == 'anggota') {
                    $anggota = $anggotaModel
                        ->where('user_id', $users['id'])
                        ->first();

                    if ($anggota) {
                        $idAnggota = $anggota['id_anggota'];
                    }
                }

                // ================= SET SESSION =================
                $session->set([
                    'id'          => $users['id'],
                    'id_anggota'  => $idAnggota, // 🔥 INI YANG PENTING
                    'nama'        => $users['nama'],
                    'email'       => $users['email'],
                    'username'    => $users['username'],
                    'role'        => $users['role'],
                    'foto'        => $users['foto'],
                    'logged_in'   => true
                ]);

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('salahpw', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Nama tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
