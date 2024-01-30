<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\AkademikModel;

class Login extends BaseController
{
    protected $user;
    protected $mahasiswa;
    protected $dosen;
    protected $akademik;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->dosen = new DosenModel();
        $this->akademik = new AkademikModel();
    }

    public function index()
    {
        if (session('id_user')) {
            return redirect()->to('admin');
        } else if (session('id_mahasiswa')) {
            return redirect()->to('mahasiswa');
        } else if (session('id_akademik')) {
            return redirect()->to('akademik');
        } else if (session('id_dosen')) {
            return redirect()->to('dosen');
        }

        return view('login/login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = null;
        $role = '';

        // Cek apakah input merupakan email atau username
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            // Coba temukan user sebagai mahasiswa
            $user = $this->mahasiswa->findByEmail($username);
            if ($user) {
                $role = 'mahasiswa';
            } else {
                // Jika tidak ditemukan, coba temukan sebagai dosen
                $user = $this->dosen->findByEmail($username);
                if ($user) {
                    $role = 'dosen';
                } else {
                    $user = $this->akademik->findByEmail($username);
                    if ($user) {
                        $role = 'akademik';
                    }
                }
            }
        } else {
            // Jika bukan email, anggap sebagai username dan cari sebagai admin
            $user = $this->user->findByUsername($username);
            $role = 'administrator';
        }

        // Pastikan user ditemukan
        if ($user) {
            // Check status user
            if ($user['status'] == 'OFF' && sha1($password) === $user['password']) {
                // Tentukan data sesi berdasarkan peran pengguna
                $sessionData = [
                    'logged_in' => true,
                    'role' => $role
                ];

                // Sesuaikan data sesi dengan peran yang sesuai
                switch ($role) {
                    case 'administrator':
                        $sessionData = array_merge($sessionData, [
                            'id_user' => $user['id_user'],
                            'nama' => $user['nama'],
                            'foto' => $user['foto'],
                            'username' => $user['username'],
                            'password' => $user['password'],
                            'role' => $user['role']
                        ]);
                        break;
                    case 'mahasiswa':
                        $sessionData = array_merge($sessionData, [
                            'id_mahasiswa' => $user['id_mahasiswa'],
                            'foto' => $user['foto'],
                            'npm' => $user['npm'],
                            'nama' => $user['nama'],
                            'sex' => $user['sex'],
                            'tempat_lahir' => $user['tempat_lahir'],
                            'tgl_lahir' => $user['tgl_lahir'],
                            'angkatan' => $user['angkatan'],
                            'email' => $user['email'],
                            'id_kelas' => $user['id_kelas'],
                        ]);
                        break;
                    case 'dosen':
                        $sessionData = array_merge($sessionData, [
                            'id_dosen' => $user['id_dosen'],
                            'foto' => $user['foto'],
                            'nama' => $user['nama'],
                            'nip' => $user['nip'],
                            'email' => $user['email'],
                        ]);
                        break;
                    case 'akademik':
                        $sessionData = array_merge($sessionData, [
                            'id_akademik' => $user['id_akademik'],
                            'foto' => $user['foto'],
                            'nama' => $user['nama']
                        ]);
                        break;
                }

                // Simpan data sesi
                session()->set($sessionData);

                // Update status menjadi 'ON' setelah berhasil login
                switch ($role) {
                    case 'administrator':
                        $this->updateLoginStatus($user['id_user'], 'ON');
                        break;
                    case 'mahasiswa':
                        $this->updateLoginStatus($user['id_mahasiswa'], 'ON');
                        break;
                    case 'dosen':
                        $this->updateLoginStatus($user['id_dosen'], 'ON');
                        break;
                    case 'akademik':
                        $this->updateLoginStatus($user['id_akademik'], 'ON');
                        break;
                }

                // Redirect ke halaman sesuai peran pengguna
                switch ($role) {
                    case 'administrator':
                        return redirect()->to('admin');
                    case 'mahasiswa':
                        return redirect()->to('mahasiswa');
                    case 'dosen':
                        return redirect()->to('dosen');
                    case 'akademik':
                        return redirect()->to('akademik');
                }
            } else {
                // Akun sedang online di perangkat/browser lain atau password tidak sesuai
                $errorMessage = ($user['status'] == 'ON')
                    ? 'Akun Anda sedang online di perangkat/browser lain.'
                    : 'Invalid Login Detail';

                session()->setFlashdata('error', $errorMessage);
                log_message('info', 'Gagal login - ' . $errorMessage . ': ' . $username);
                return redirect()->to('/login');
            }
        } else {
            // Pengguna tidak ditemukan
            session()->setFlashdata('error', 'Invalid Login Detail');
            log_message('error', 'Gagal autentikasi untuk pengguna: ' . $username);
            return redirect()->to('/login');
        }
    }


    public function logout()
    {
        $role = session('role');

        switch ($role) {
            case 'administrator':
                $this->updateLoginStatus(session('id_user'), 'OFF');
                session()->remove('id_user');
                break;
            case 'mahasiswa':
                $this->updateLoginStatus(session('id_mahasiswa'), 'OFF');
                session()->remove('id_mahasiswa');
                break;
            case 'dosen':
                $this->updateLoginStatus(session('id_dosen'), 'OFF');
                session()->remove('id_dosen');
                break;
            case 'akademik':
                $this->updateLoginStatus(session('id_akademik'), 'OFF');
                session()->remove('id_akademik');
                break;
        }
        return redirect()->to('/login');
    }

    private function updateLoginStatus($userId, $status)
    {
        switch (session('role')) {
            case 'administrator':
                $this->user->update(['id_user' => $userId], ['status' => $status]);
                break;
            case 'mahasiswa':
                $this->mahasiswa->update(['id_mahasiswa' => $userId], ['status' => $status]);
                break;
            case 'dosen':
                $this->dosen->update(['id_dosen' => $userId], ['status' => $status]);
                break;
            case 'akademik':
                $this->akademik->update(['id_akademik' => $userId], ['status' => $status]);
                break;
        }
    }
}
