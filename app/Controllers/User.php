<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        // Cek apakah pengguna sudah login
        if (!session('id_user')) {
            // Jika belum login, alihkan ke halaman login
            return redirect()->to('/login');
        }

        $data = [
            'dataUser' => $this->user->getAllData(),
            'page_title' => "Pengguna"
        ];

        return view('user/user', $data);
    }

    public function add()
    {

        $username = $this->request->getPost('username');
        $password = sha1($this->request->getPost('password'));

        $image = $this->request->getFile('foto');
        $imageName = $username . '.' . $image->getClientExtension();
        $image->move(ROOTPATH . 'public/assets/images/user/', $imageName);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $username,
            'password' => $password,
            'role' => $this->request->getPost('role'),
            'foto' => $imageName,
        ];

        $this->user->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('/user');
    }

    public function update($id)
    {
        // Mendapatkan data pengguna dari database
        $user = $this->user->find($id);

        $data = [
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];

        // Mendapatkan password dari form inputan
        $password = sha1($this->request->getPost('password'));

        // Jika password diubah dalam form, lakukan enkripsi
        if (!empty($password)) {
            $data['password'] = $password;  // Anda mungkin ingin mengenkripsi password di sini
        }

        $foto = $this->request->getFile('foto');

        // Mengecek apakah foto diganti atau tidak
        if ($foto->isValid() && !$foto->hasMoved()) {
            // Jika iya, mengenerate nama baru untuk foto
            $imageName = $foto->getRandomName();
            // Memindahkan foto ke direktori
            $foto->move(ROOTPATH . 'public/assets/images/user/', $imageName);
            // Menghapus foto lama dari database jika ada
            if ($user['foto']) {
                unlink(ROOTPATH . 'public/assets/images/user/' . $user['foto']);
            }
            $data['foto'] = $imageName;
        }

        // pembaruan data
        $this->user->update($id, $data);  // Menggunakan method update dari Model
        return redirect()->to("/user");
    }

    public function delete($id)
    {
        $user = $this->user->find($id);

        //mengecek apakah ada foto?
        if ($user) {
            $imageName = $user['foto'];
            $imagePath = "assets/images/user/" . $imageName;

            // Cek apakah file gambar ada di server
            if (file_exists($imagePath)) {
                // Hapus file gambar
                unlink($imagePath);
            }

            // Hapus data dari database
            $this->user->delete($id);
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Film tidak ditemukan');
        }

        return redirect()->to('/user');
    }
}
