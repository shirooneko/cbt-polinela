<?php

namespace App\Controllers;

use Config\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MatkulModel;
use App\Models\SesiModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamResultModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use Bluerhinos\phpMQTT;
use App\Models\ProdiModel;
use App\Models\ThnAjaranModel;
use App\Models\AkademikModel;
use Ifsnop\Mysqldump as IMysqldump;

class Admin extends BaseController
{
    protected $dosen;
    protected $kelas;
    protected $mahasiswa;
    protected $matkul;
    protected $sesi;
    protected $exam;
    protected $examQuestion;
    protected $examResult;
    protected $user;
    protected $jurusan;
    protected $prodi;
    protected $thnAjaran;
    protected $akademik;

    public function __construct()
    {
        $this->dosen = new DosenModel();
        $this->kelas = new KelasModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->matkul = new MatkulModel();
        $this->sesi = new SesiModel();
        $this->exam = new ExamModel();
        $this->examQuestion = new QuestionModel();
        $this->examResult = new ExamResultModel();
        $this->user = new UserModel();
        $this->jurusan = new JurusanModel();
        $this->prodi = new ProdiModel();
        $this->thnAjaran = new ThnAjaranModel();
        $this->akademik = new AkademikModel();
    }

    public function index()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'page_title' => "Dashboard",
            'jumlMahasiswa' => $this->mahasiswa->countMahasiswa(),
            'jumlDosen' => $this->dosen->countDosen(),
            'jumlAdmin' => $this->user->countAdmin(),
            'jumlAkademik' => $this->akademik->countAkademik(),
            'totalExam' => $this->exam->countExams(),
            'adminOnline' => $this->user->countStatusOn(),
            'dosenOnline' => $this->dosen->countStatusOn(),
            'mahasiswaOnline' => $this->mahasiswa->countStatusOn(),
            'akademikOnline' => $this->akademik->countStatusOn(),
            'pendingExams' => $this->exam->countExamsByStatus('pending'),
            'publishedExams' => $this->exam->countExamsByStatus('publish'),
            'expiredExams' => $this->exam->countExamsByStatus('expired'),

        ];
        return view('admin/dashboard', $data);
    }

    public function getChartDataSex()
    {
        $dataMahasiswa = $this->mahasiswa->getAllData();

        $totalMahasiswa = count($dataMahasiswa);
        $totalLakiLaki = array_reduce($dataMahasiswa, function ($carry, $mahasiswa) {
            return $carry + ($mahasiswa['sex'] === 'Laki-laki' ? 1 : 0);
        }, 0);
        $totalPerempuan = $totalMahasiswa - $totalLakiLaki;

        $chartData = [
            ['sex' => 'Laki-laki', 'percentage' => round(($totalLakiLaki / $totalMahasiswa) * 100, 2)],
            ['sex' => 'Perempuan', 'percentage' => round(($totalPerempuan / $totalMahasiswa) * 100, 2)],
        ];

        return $this->response->setJSON($chartData);
    }

    public function getChartDataProdi()
    {
        $dataMahasiswa = $this->mahasiswa->getAllData();
        $dataProdi = $this->prodi->getAllData(); // Asumsikan Anda memiliki metode ini untuk mendapatkan semua data prodi

        // Menghitung jumlah mahasiswa per prodi
        $prodiCounts = [];
        foreach ($dataProdi as $prodi) {
            $prodiCounts[$prodi['id_prodi']] = [
                'nama_prodi' => $prodi['nama_prodi'],
                'jumlah' => 0
            ];
        }

        foreach ($dataMahasiswa as $mahasiswa) {
            if (isset($prodiCounts[$mahasiswa['id_prodi']])) {
                $prodiCounts[$mahasiswa['id_prodi']]['jumlah']++;
            }
        }

        $totalMahasiswa = count($dataMahasiswa);
        $chartData = [];
        foreach ($prodiCounts as $idProdi => $prodi) {
            if ($totalMahasiswa > 0) {
                $chartData[] = [
                    'prodi' => $prodi['nama_prodi'],
                    'percentage' => round(($prodi['jumlah'] / $totalMahasiswa) * 100, 2)
                ];
            }
        }

        return $this->response->setJSON($chartData);
    }


    //***************************//
    // bagian manage dosen start//
    //*************************//

    public function myProfile($id)
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        return view('admin/my-profile', [
            'page_title' => 'Profile',
            'dataUser' => $this->user->getDataById($id),
        ]);
    }


    public function dosen()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'page_title' => "Dosen",
            'errors' => session('errors'),
            'dataDosen' => $this->dosen->getAllData(),
        ];

        return view('admin/dosen', $data);
    }

    public function dosenAdd()
    {
        $validation =  \Config\Services::validation();

        // Aturan validasi untuk setiap field
        $validation->setRules(
            [
                'nip' => 'required',
                'nama' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required',
                'foto' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]'
            ],
            [   // Custom messages
                'nip' => [
                    'required' => 'NIP wajib diisi.'
                ],
                'nama' => [
                    'required' => 'Nama wajib diisi.'
                ],
                'email' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Email tidak valid.'
                ],
                'password' => [
                    'required' => 'Password wajib diisi.'
                ],
                'foto' => [
                    'uploaded' => 'Foto wajib diupload.',
                    'is_image' => 'File yang diupload harus berupa gambar.',
                    'max_size' => 'Ukuran foto tidak boleh lebih dari 2MB.'
                ]
            ]
        );

        // Jika validasi gagal
        if ($validation->withRequest($this->request)->run() === false) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Jika validasi berhasil, lanjutkan proses seperti biasa
        $nip = $this->request->getPost('nip');
        $password = sha1($this->request->getPost('password'));

        $image = $this->request->getFile('foto');
        $imageName = $nip . '.' . $image->getClientExtension();
        if (!$image->hasMoved()) {
            $image->move(FCPATH . '/assets/images/dosen/', $imageName);
        }

        $data = [
            'nip' => $nip,
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => $password,
            'foto' => $imageName,
            'role' => 'dosen',
            'status' => 'OFF'
        ];

        $this->dosen->save($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan.');
        return redirect()->to('admin/dosen');
    }


    public function dosenUpdate($id)
    {
        $dosen = $this->dosen->find($id);

        $data = [
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        $passwordInput = $this->request->getPost('password');
        if (!empty($passwordInput)) {
            $data['password'] = sha1($passwordInput);
        }

        // Menghandle update foto
        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $imageName = $foto->getRandomName();
            $foto->move(FCPATH . 'assets/images/dosen/', $imageName);
            if ($dosen['foto']) {
                unlink(FCPATH . 'assets/images/dosen/' . $dosen['foto']);
            }
            $data['foto'] = $imageName;
        }

        $this->dosen->update($id, $data);
        session()->setFlashdata('success', 'Data dosen berhasil diperbarui.');
        return redirect()->to("admin/dosen");
    }

    public function dosenDelete($id)
    {
        try {
            $dosen = $this->dosen->find($id);
            if ($dosen) {
                $this->dosen->delete($id);
                $imageName = $dosen['foto'];
                $imagePath = "assets/images/dosen/" . $imageName;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                session()->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                session()->setFlashdata('error', 'dosen tidak ditemukan');
            }
            return redirect()->to('admin/dosen');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $error = $e->getMessage();
            if (strpos($error, '1451') !== false) {
                session()->setFlashdata('error', 'Tidak dapat menghapus atau memperbarui kelas karena masih ada siswa yang terdaftar dalam kelas tersebut.');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan: Data sedang digunakan');
            }
            return redirect()->to('admin/dosen');
        }
    }

    //**************************//
    // bagian manage dosen end //
    //************************//


    //********************************//
    // bagian manage mahasiswa start //
    //******************************//

    public function mahasiswa()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataKelas' => $this->kelas->getAllData(),
            'dataJurusan' => $this->jurusan->getAllData(),
            'dataProdi' => $this->prodi->getAllData(),
            'dataMahasiswa' => $this->mahasiswa->getAllDataJoin(),
            'page_title' =>  "Mahasiswa"
        ];

        return view('admin/mahasiswa', $data);
    }

    public function getMahasiswaData($id)
    {
        try {
            $mahasiswa = $this->mahasiswa->find($id);
            $dataKelas = $this->kelas->findAll();
            $dataJurusan = $this->jurusan->getAllData();
            $dataProdi = $this->prodi->getAllData();

            return view('admin/mahasiswa_update_modal', ['mahasiswa' => $mahasiswa, 'dataKelas' => $dataKelas, 'dataJurusan' => $dataJurusan, 'dataProdi' => $dataProdi]);
        } catch (\Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }



    public function searchMahasiswa()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $searchValue = $this->request->getVar('search')['value'];
        $orderColumn = $this->request->getVar('order')[0]['column'];
        $orderDir = $this->request->getVar('order')[0]['dir'];
        $kelasId = $this->request->getVar('kelas');
        $keyword = $this->request->getVar('keyword');

        $debugData = [
            'kelasId' => $kelasId,
            'keyword' => $keyword,
            'searchValue' => $searchValue,
            'start' => $start,
            'length' => $length,
            'orderColumn' => $orderColumn,
            'orderDir' => $orderDir,
        ];


        $isValidKelasId = !empty($kelasId) && $kelasId !== 'Pilih Kelas';

        if ($isValidKelasId && !empty($keyword)) {
            // Pencarian berdasarkan kelas dan nama atau NPM
            $data = is_numeric($keyword) ?
                $this->mahasiswa->searchMahasiswaByKelasAndNpm($kelasId, $keyword) :
                $this->mahasiswa->searchMahasiswaByKelasAndName($kelasId, $keyword);

            $recordsTotal = $recordsFiltered = count($data);
        } elseif ($isValidKelasId) {
            // Pencarian berdasarkan kelas saja
            $data = $this->mahasiswa->getMahasiswaByKelas($kelasId, $start, $length, $searchValue, $orderColumn, $orderDir);
            $recordsTotal = $this->mahasiswa->countAllKelas($kelasId);
            $recordsFiltered = $this->mahasiswa->countFiltered($kelasId, $searchValue);
        } elseif (!empty($keyword)) {
            // Pencarian berdasarkan nama atau NPM tanpa memperhatikan kelas
            $data = is_numeric($keyword) ?
                $this->mahasiswa->searchMahasiswaByNpm($keyword) :
                $this->mahasiswa->searchMahasiswaByName($keyword);

            $recordsTotal = $recordsFiltered = count($data);
        } else {
            // Ketika tidak ada kelas atau keyword, jangan kembalikan data apapun
            $data = [];
            $recordsTotal = 0;
            $recordsFiltered = 0;
        }

        $response = [
            'draw' => intval($this->request->getVar('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'debug' => $debugData
        ];

        return $this->response->setJSON($response);
    }


    public function mahasiswaAdd()
    {
        $npm = $this->request->getPost('npm');
        $password = sha1($this->request->getPost('password'));

        $image = $this->request->getFile('foto');
        $imageName = $npm . '.' . $image->getClientExtension();
        $image->move(FCPATH . '/assets/images/mahasiswa/', $imageName);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'npm' => $npm,
            'password' => $password,
            'email' => $this->request->getPost('email'),
            'sex' => $this->request->getPost('sex'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'angkatan' => $this->request->getPost('angkatan'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'foto' => $imageName,
            'role' => 'mahasiswa',
            'status' => 'OFF',
        ];

        $this->mahasiswa->save($data);

        $mqtt_broker = "192.168.43.156"; // Alamat broker MQTT
        $mqtt_port = 1883;
        $mqtt_topic = "dataInputMahasiswa"; // Topik MQTT
        $mqtt_client_id = "Client_Id"; // ID klien untuk koneksi ini

        $mqtt = new phpMQTT($mqtt_broker, $mqtt_port, $mqtt_client_id);

        // Coba terhubung ke broker MQTT
        if ($mqtt->connect()) {
            // Siapkan data untuk dikirim
            $mqtt_data = json_encode($data);

            // Kirim data mahasiswa ke broker MQTT
            $mqtt->publish($mqtt_topic, $mqtt_data, 0);

            // Tutup koneksi MQTT
            $mqtt->close();

            // Set flashdata untuk sukses dan redirect
            session()->setFlashdata('success', 'Data berhasil disimpan.');
        } else {
            // Set flashdata untuk error dan redirect
            session()->setFlashdata('error', 'Gagal terhubung ke broker MQTT.');
        }

        // Redirect ke halaman mahasiswa
        return redirect()->to('admin/mahasiswa');
    }

    public function mahasiswaUpdate($id)
    {
        $mahasiswa = $this->mahasiswa->find($id);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'npm' => $this->request->getPost('npm'),
            'email' => $this->request->getPost('email'),
            'sex' => $this->request->getPost('sex'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'angkatan' => $this->request->getPost('angkatan'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
        ];

        $passwordInput = $this->request->getPost('password');

        if (!empty($passwordInput)) {
            $data['password'] = sha1($passwordInput);
        }

        $foto = $this->request->getFile('foto');

        if ($foto->isValid() && !$foto->hasMoved()) {
            $imageName = $foto->getRandomName();
            $foto->move(FCPATH . '/assets/images/mahasiswa/', $imageName);

            if ($mahasiswa['foto'] && $mahasiswa['foto'] !== 'profile.png') {
                unlink(FCPATH . '/assets/images/mahasiswa/' . $mahasiswa['foto']);
            }

            $data['foto'] = $imageName;
        }

        $this->mahasiswa->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to("admin/mahasiswa");
    }

    public function mahasiswaDelete($id)
    {
        try {
            $mahasiswa = $this->mahasiswa->find($id);
            if ($mahasiswa) {
                $this->mahasiswa->delete($id);
                $imageName = $mahasiswa['foto'];
                $imagePath = "../public_html/assets/images/mahasiswa/" . $imageName;

                // Hanya menghapus file jika nama gambar bukan 'profile.png'
                if (file_exists($imagePath) && $imageName != 'profile.png') {
                    unlink($imagePath);
                }

                session()->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                session()->setFlashdata('error', 'Mahasiswa tidak ditemukan');
            }
            return redirect()->to('admin/mahasiswa');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $error = $e->getMessage();
            if (strpos($error, '1451') !== false) {
                session()->setFlashdata('error', 'Tidak dapat menghapus atau memperbarui kelas karena masih ada siswa yang terdaftar dalam kelas tersebut.');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan: Data sedang digunakan');
            }
            return redirect()->to('admin/mahasiswa');
        }
    }

    public function import()
    {
        $file = $this->request->getFile('fileToUpload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file->getTempName());
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);

            $spreadsheet = $reader->load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $db = \Config\Database::connect();
            $db->transBegin();

            foreach ($rows as $index => $row) {
                // Validasi bahwa baris memiliki data yang tidak kosong
                if ($index === 0 || empty(array_filter($row))) {
                    continue; // Abaikan baris kosong atau judul
                }

                $formattedDate = $row[4];

                $kelas = $this->kelas->getIdByName($row[9]);
                if (!$kelas) {
                    $db->transRollback();
                    session()->setFlashdata('error', "Kelas dengan nama '{$row[9]}' tidak ditemukan pada baris ke-{$index}");
                    return redirect()->back();
                }

                $jurusan = $this->jurusan->getIdByName($row[6]);
                if (!$jurusan) {
                    $db->transRollback();
                    session()->setFlashdata('error', "Jurusan dengan nama '{$row[6]}' tidak ditemukan pada baris ke-{$index}");
                    return redirect()->back();
                }

                $prodi = $this->prodi->getIdByName($row[7]);
                if (!$prodi) {
                    $db->transRollback();
                    session()->setFlashdata('error', "Program Studi dengan nama '{$row[7]}' tidak ditemukan pada baris ke-{$index}");
                    return redirect()->back();
                }

                $mahasiswaData = [
                    'npm'          => $row[0],
                    'nama'         => $row[1],
                    'sex'          => $row[2],
                    'tempat_lahir' => $row[3],
                    'tgl_lahir'    => $formattedDate,
                    'angkatan'     => $row[5],
                    'id_jurusan'   => $jurusan['id_jurusan'],
                    'id_prodi'     => $prodi['id_prodi'],
                    'email'        => $row[8],
                    'id_kelas'     => $kelas['id_kelas'],
                    'password'     => sha1($row[10]),
                    'foto'         => 'profile.png',
                ];

                if (!$this->mahasiswa->insert($mahasiswaData)) {
                    $db->transRollback();
                    session()->setFlashdata('error', "Gagal menyimpan data mahasiswa pada baris ke-{$index}.");
                    return redirect()->back();
                }
            }

            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                session()->setFlashdata('error', 'Import data mahasiswa gagal.');
                return redirect()->back();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Import data mahasiswa berhasil.');
                return redirect()->to('/admin/mahasiswa');
            }
        } else {
            session()->setFlashdata('error', 'File tidak valid atau terjadi kesalahan saat upload.');
            return redirect()->back();
        }
    }


    //******************************//
    // bagian manage mahasiswa end //
    //****************************//

    //**********************************//
    // bagian manage mata kuliah start //
    //********************************//

    public function matkul()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }


        $data = [
            'dataDosen' => $this->dosen->getAllData(),
            'dataMatkul' => $this->matkul->getAllDataJoin(),
            'page_title' => "Mata Kuliah"
        ];
        return view('admin/matkul', $data);
    }

    public function matkuladd()
    {

        $data = [
            'kode_matkul' => $this->request->getPost('kode_matkul'),
            'nama' => $this->request->getPost('nama'),
            'semester' => $this->request->getPost('semester'),
            'thn_ajaran' => $this->request->getPost('thn_ajaran'),
            'id_dosen' => $this->request->getPost('id_dosen')
        ];

        $this->matkul->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/matkul');
    }

    public function matkulUpdate($id)
    {

        $data = [
            'kode_matkul' => $this->request->getPost('kode_matkul'),
            'nama' => $this->request->getPost('nama'),
            'semester' => $this->request->getPost('semester'),
            'thn_ajaran' => $this->request->getPost('thn_ajaran'),
            'id_dosen' => $this->request->getPost('id_dosen')
        ];

        $this->matkul->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to('admin/matkul');
    }

    public function matkulDelete($id)
    {
        $this->matkul->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('admin/matkul');
    }

    //********************************//
    // bagian manage mata kuliah end //
    //******************************//

    //****************************//
    // bagian manage kelas start //
    //**************************//

    public function kelas()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataKelas' => $this->kelas->getAllData(),
            'dataProdi' => $this->prodi->getAllData(),
            'page_title' =>  "Kelas"
        ];
        return view('admin/kelas', $data);
    }

    public function kelasAdd()
    {

        $data = [
            'nama' => $this->request->getPost('nama'),
            'semester' => $this->request->getPost('semester'),
            'id_prodi' => $this->request->getPost('id_prodi')
        ];

        $this->kelas->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/kelas');
    }

    public function kelasUpdate($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'semester' => $this->request->getPost('semester'),
            'id_prodi' => $this->request->getPost('id_prodi')
        ];

        $this->kelas->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to("admin/kelas");
    }

    public function kelasDelete($id)
    {
        $this->kelas->delete($id);
        return redirect()->to('admin/kelas');
    }

    //****************************//
    // bagian manage kelas end //
    //**************************//

    //***************************//
    // bagian manage sesi start //
    //*************************//

    public function sesi()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataSesi' => $this->sesi->getAllData(),
            'page_title' => "Sesi"
        ];

        return view('admin/sesi', $data);
    }

    public function sesiAdd()
    {

        $data = [
            'nama_sesi' => $this->request->getPost('nama_sesi'),
        ];

        $this->sesi->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/sesi');
    }

    public function sesiUpdate($id)
    {

        $data = [
            'nama_sesi' => $this->request->getPost('nama_sesi'),
        ];

        $this->sesi->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate');
        return redirect()->to("admin/sesi");
    }

    public function sesiDelete($id)
    {
        $this->sesi->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('admin/sesi');
    }

    //*************************//
    // bagian manage sesi end //
    //***********************//

    //***************************//
    // bagian manage exam start //
    //*************************//

    public function exam()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataMatkul' => $this->matkul->getAllData(),
            'dataKelas' => $this->kelas->getAllData(),
            'dataSesi' => $this->sesi->getAllData(),
            'dataExamPending' => $this->exam->getAllDataJoin('pending'),
            'dataExamPublish' => $this->exam->getAllDataJoin('publish'),
            'dataExamExpired' => $this->exam->getAllDataJoin('expired'),
            'dataExam' => $this->exam->getAllDataJoin(),
            'exam_count' => $this->exam->countExamsByStatus(),
            'page_title' => "Exam"
        ];

        return view('admin/exam', $data);
    }

    public function examAdd()
    {
        $data = [
            'nama_exam' => $this->request->getPost('nama_exam'),
            'id_matkul' => $this->request->getPost('id_matkul'),
            'id_sesi' => $this->request->getPost('id_sesi'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'tgl_exam' => $this->request->getPost('tgl_exam'),
            'status' => 'pending',
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time')
        ];

        // Simpan data ke database
        $this->exam->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/exam');
    }


    public function examUpdate($id)
    {
        $data = [
            'nama_exam' => $this->request->getPost('nama_exam'),
            'id_matkul' => $this->request->getPost('id_matkul'),
            'id_sesi' => $this->request->getPost('id_sesi'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'tgl_exam' => $this->request->getPost('tgl_exam'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time')
        ];

        $this->exam->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to('admin/exam');
    }


    public function examDelete($id)
    {
        try {
            $exam = $this->exam->find($id);
            if ($exam) {
                $this->exam->delete($id);
                session()->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                session()->setFlashdata('error', 'Ujian tidak ditemukan');
            }
            return redirect()->to('admin/exam');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $error = $e->getMessage();
            if (strpos($error, '1451') !== false) {
                session()->setFlashdata('error', 'Tidak dapat menghapus ujian karena masih ada soal atau peserta yang terkait dengan ujian ini.');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan: Data sedang digunakan');
            }
            return redirect()->to('admin/exam');
        }
    }

    public function publish($id)
    {
        $exam = $this->exam->find($id);
        if (!$exam) {
            session()->setFlashdata('error', 'Ujian tidak ditemukan.');
            return redirect()->to('/admin/exam');
        }

        $data = ['status' => 'publish'];
        $this->exam->update($id, $data);

        session()->setFlashdata('success', 'Ujian berhasil dipublish.');
        return redirect()->to('/admin/exam');
    }

    public function examViewResult($id)
    {
        $id_kelas = $this->exam->find($id)['id_kelas'];
        $results = $this->examResult->getResultsByClassAndExam($id, $id_kelas);

        $data = [
            'dataExam' => $this->examQuestion->getExamDataById($id),
            'results' => $results,
            'page_title' => $this->exam->find($id)['nama_exam']
        ];
        return view('admin/examViewResult', $data);
    }


    //*************************//
    // bagian manage exam end //
    //***********************//

    //************************************//
    // bagian manage exam question start //
    //**********************************//

    public function question($id)
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'totalPoints' => $this->examQuestion->calculateTotalPoints($id),
            'dataExamQuestion' => $this->examQuestion->getQuestionsByExamIdAdmin($id),
            'dataExam' => $this->examQuestion->getExamDataById($id),
            'page_title' => $this->exam->find($id)['nama_exam'],
            'id' => $id,
        ];

        return view('admin/examAddQuestion', $data);
    }

    public function questionAdd($id)
    {
        $soal = $this->request->getPost('soal');
        $jawaban_benar = $this->request->getPost('jawaban_benar');
        $nilai = $this->request->getPost('nilai');

        if (empty($jawaban_benar)) {
            session()->setFlashdata('error', 'Harap pilih jawaban yang benar.');
            return redirect()->back()->withInput();
        }

        // Mengambil nomor urutan soal terakhir untuk id_exam yang sesuai
        $lastQuestion = $this->examQuestion->where('id_exam', $id)->orderBy('nomor_soal', 'DESC')->first();

        // Inisialisasi nomor_soal dengan 1 jika tidak ada pertanyaan sebelumnya
        $nomor_soal = 1;

        // Jika ada pertanyaan sebelumnya, tambahkan 1 ke nomor_soal
        if ($lastQuestion) {
            $nomor_soal = $lastQuestion['nomor_soal'] + 1;
        }

        // Menangani gambar soal jika diunggah
        $gambar_soal = $this->request->getFile('gambar_soal');
        $gambar_soalPath = null;  // nilai awal diatur ke null
        if ($gambar_soal->isValid() && !$gambar_soal->hasMoved()) {
            $newName = $gambar_soal->getRandomName();
            $gambar_soal->move(FCPATH . '/assets/images/exam/soal', $newName);
            $gambar_soalPath = $newName;
        }

        // Menangani gambar pilihan jika diunggah
        $gambar_pilihan = [];
        foreach (['A', 'B', 'C', 'D'] as $pilihan) {
            $file = $this->request->getFile('gambar_pilihan_' . strtolower($pilihan));
            $gambar_pilihan[$pilihan] = null;  // nilai awal diatur ke null
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . '/assets/images/exam/pilihan', $newName);
                $gambar_pilihan[$pilihan] = $newName;
            }
        }

        $pilihan_string = json_encode([
            'A' => $this->request->getPost('pilihan_a'),
            'B' => $this->request->getPost('pilihan_b'),
            'C' => $this->request->getPost('pilihan_c'),
            'D' => $this->request->getPost('pilihan_d'),
        ]);

        $gambar_pilihan_string = json_encode($gambar_pilihan);

        $data = [
            'id_exam' => $id,
            'soal' => $soal,
            'gambar_soal' => $gambar_soalPath,
            'pilihan' => $pilihan_string,
            'gambar_pilihan' => $gambar_pilihan_string,
            'correct_answer' => $jawaban_benar,
            'nilai' => $nilai,
            'nomor_soal' => $nomor_soal
        ];

        $this->examQuestion->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/question/' . $id);
    }

    public function questionUpdate($id_question)
    {
        helper(['form', 'url']);

        $soal = $this->request->getPost('soal');
        $jawaban_benar = $this->request->getPost('jawaban_benar');
        $nilai = $this->request->getPost('nilai');

        $pilihan = [];
        $gambar_pilihan = [];
        foreach (['A', 'B', 'C', 'D'] as $huruf) {
            $pilihan[$huruf] = $this->request->getPost('pilihan_' . strtolower($huruf));

            // Memeriksa apakah file gambar pilihan diunggah
            $fileGambarPilihan = $this->request->getFile('gambar_pilihan_' . strtolower($huruf));
            if ($fileGambarPilihan->isValid() && !$fileGambarPilihan->hasMoved()) {
                $namaGambarPilihan = $fileGambarPilihan->getRandomName();
                $fileGambarPilihan->move(FCPATH . '/assets/images/exam/pilihan', $namaGambarPilihan);
                $gambar_pilihan[$huruf] = $namaGambarPilihan;
            } else {
                // Jika tidak ada file gambar baru, gunakan gambar lama atau tambahkan gambar jika tidak ada gambar sebelumnya
                $questionData = $this->examQuestion->find($id_question);
                $gambar_pilihan_lama = json_decode($questionData['gambar_pilihan'], true);
                $gambar_pilihan[$huruf] = $gambar_pilihan_lama[$huruf] ?? null;
            }
        }

        $pilihan_string = json_encode($pilihan);
        $gambar_pilihan_string = json_encode($gambar_pilihan);

        // Memeriksa apakah file gambar soal diunggah
        $fileGambarSoal = $this->request->getFile('gambar_soal');
        $gambar_soal = null;
        if ($fileGambarSoal->isValid() && !$fileGambarSoal->hasMoved()) {
            $namaGambarSoal = $fileGambarSoal->getRandomName();
            $fileGambarSoal->move(FCPATH . '/assets/images/exam/soal', $namaGambarSoal);
            $gambar_soal = $namaGambarSoal;
        } else {
            // Jika tidak ada file gambar baru, gunakan gambar lama atau tambahkan gambar jika tidak ada gambar sebelumnya
            $questionData = $this->examQuestion->find($id_question);
            $gambar_soal_lama = $questionData['gambar_soal'];
            $gambar_soal = $gambar_soal_lama ? $gambar_soal_lama : null;
        }

        $data = [
            'soal' => $soal,
            'pilihan' => $pilihan_string,
            'gambar_pilihan' => $gambar_pilihan_string,
            'gambar_soal' => $gambar_soal,
            'correct_answer' => $jawaban_benar,
            'nilai' => $nilai
        ];

        $this->examQuestion->update($id_question, $data);

        $questionData = $this->examQuestion->find($id_question);
        $id_exam = $questionData['id_exam'];

        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('admin/question/' . $id_exam);
    }

    public function questionDelete($id)
    {
        $questionData = $this->examQuestion->find($id);
        $id_exam = $questionData['id_exam'];

        // Hapus gambar soal jika ada
        if ($questionData['gambar_soal']) {
            $gambarSoalPath = FCPATH . 'assets/images/exam/soal/' . $questionData['gambar_soal'];
            if (is_file($gambarSoalPath)) {
                unlink($gambarSoalPath);
            }
        }

        // Hapus gambar pilihan jika ada
        $gambar_pilihan = json_decode($questionData['gambar_pilihan'], true);

        if (is_array($gambar_pilihan)) {
            foreach ($gambar_pilihan as $gambar) {
                if ($gambar) {
                    $gambarPilihanPath = FCPATH . 'assets/images/exam/pilihan/' . $gambar;
                    if (is_file($gambarPilihanPath)) {
                        unlink($gambarPilihanPath);
                    }
                }
            }
        }

        // Hapus data pertanyaan dari database
        $this->examQuestion->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('admin/question/' . $id_exam);
    }


    //**********************************//
    // bagian manage exam question end //
    //********************************//

    //*********************//
    // bagian manage user //
    //*******************//

    public function user()
    {

        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataUser' => $this->user->getAllData(),
            'page_title' => "Pengguna"
        ];

        return view('admin/profile', $data);
    }

    public function userAdd()
    {
        $password = sha1($this->request->getPost('password'));

        $image = $this->request->getFile('foto');
        $imageName = $image->getRandomName();
        $image->move(FCPATH . '/assets/images/user/', $imageName);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'foto' => $imageName,
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'role' => 'administrator',
        ];

        $this->user->save($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan.');
        return redirect()->to('admin/user');
    }

    public function userUpdate($id)
    {
        $user = $this->user->find($id);
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role') ?? 'administrator',
        ];

        $passwordInput = $this->request->getPost('password');
        if ($passwordInput) {
            $data['password'] = sha1($passwordInput);
        }

        $image = $this->request->getFile('foto');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . '/assets/images/user/', $imageName);
            // Hapus foto lama, tanpa cek file sebelumnya
            if ($user['foto']) {
                @unlink(FCPATH . '/assets/images/user/' . $user['foto']);
            }
            $data['foto'] = $imageName;
        }

        $this->user->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');

        return redirect()->back();
    }

    public function userDelete($id)
    {
        $user = $this->user->find($id);

        if ($user['foto']) {
            $file_path = FCPATH . '/assets/images/user/' . $user['foto'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $this->user->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('admin/user');
    }

    public function updateFoto()
    {
        $idUser = $this->request->getPost('id_user');
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoBaru = $foto->getRandomName();
            $foto->move(FCPATH . 'assets/images/user/', $fotoBaru);

            $userInfo = $this->user->find($idUser);

            $oldImagePath = FCPATH . '/assets/images/user/' . $userInfo['foto'];
            if ($userInfo['foto'] && is_file($oldImagePath) && $userInfo['foto'] !== 'profile.png') {
                unlink($oldImagePath);
            }

            $updateData = ['foto' => $fotoBaru];
            $this->user->update($idUser, $updateData);
            session()->setFlashdata('success', 'Foto berhasil diupdate.');
        } else {
            session()->setFlashdata('error', 'Tidak ada foto yang diupload atau terjadi kesalahan.');
        }

        return redirect()->back();
    }

    //****************************//
    // bagian manage jurusan start //
    //**************************//

    public function jurusan()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataJurusan' => $this->jurusan->getAllData(),
            'page_title' =>  "Jurusan"
        ];
        return view('admin/jurusan', $data);
    }

    public function jurusanAdd()
    {

        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        ];

        $this->jurusan->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/jurusan');
    }

    public function jurusanUpdate($id)
    {
        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        ];

        $this->jurusan->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to("admin/jurusan");
    }

    public function jurusanDelete($id)
    {
        $this->jurusan->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('admin/jurusan');
    }

    //****************************//
    // bagian manage jurusan end //
    //**************************//

    //****************************//
    // bagian manage prodi start //
    //**************************//

    public function prodi()
    {
        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataProdi' => $this->prodi->getAllData(),
            'dataJurusan' => $this->jurusan->getAllData(),
            'page_title' =>  "Program Studi"
        ];
        return view('admin/prodi', $data);
    }

    public function prodiAdd()
    {

        $data = [
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
        ];

        $this->prodi->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('admin/prodi');
    }

    public function prodiUpdate($id)
    {
        $data = [
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
        ];

        $this->prodi->update($id, $data);

        session()->setFlashdata('success', 'Data berhasil diupdate.');
        
        return redirect()->to("admin/prodi");
    }

    public function prodiDelete($id)
    {
        $this->prodi->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('admin/prodi');
    }

    //****************************//
    // bagian manage jurusan end //
    //**************************//

    //*********************//
    // bagian manage user //
    //*******************//

    public function userAkademik()
    {

        if (!session('id_user')) {
            return redirect()->to('/login');
        }

        $data = [
            'dataAkademik' => $this->akademik->getAllData(),
            'page_title' => "Akademik"
        ];

        return view('admin/akademik', $data);
    }

    public function userAkademikAdd()
    {
        $password = sha1($this->request->getPost('password'));

        $image = $this->request->getFile('foto');
        $imageName = $image->getRandomName();
        $image->move(FCPATH . '/assets/images/akademik/', $imageName);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'foto' => $imageName,
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'role' => 'akademik',
            'status' => 'OFF'
        ];

        $this->akademik->save($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan.');
        return redirect()->to('admin/userAkademik');
    }

    public function userAkademikUpdate($id)
    {
        $user = $this->user->find($id);
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role') ?? 'administrator',
        ];

        $passwordInput = $this->request->getPost('password');
        if ($passwordInput) {
            $data['password'] = sha1($passwordInput);
        }

        $image = $this->request->getFile('foto');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . '/assets/images/user/', $imageName);
            // Hapus foto lama, tanpa cek file sebelumnya
            if ($user['foto']) {
                @unlink(FCPATH . '/assets/images/akademik/' . $user['foto']);
            }
            $data['foto'] = $imageName;
        }

        $this->akademik->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');

        return redirect()->back();
    }

    public function userAkademikDelete($id)
    {
        $akademik = $this->akademik->find($id);

        if ($akademik['foto']) {
            $file_path = FCPATH . '/assets/images/akademik/' . $akademik['foto'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $this->akademik->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('admin/userAkademik');
    }

    public function exportQuestions($id)
    {
        // Cek apakah user telah login dan memiliki akses yang sesuai
        // Tambahkan kode sesuai kebutuhan untuk autentikasi dan otorisasi

        // Cek keberadaan ID ujian
        $namaUjian = $this->exam->find($id)['nama_exam'];
        if (!$namaUjian) {
            return $this->response->setJSON(['error' => 'Tidak ada ujian yang ditemukan dengan ID ini.']);
        }

        // Ambil data pertanyaan dari model atau database
        $questions = $this->examQuestion->getQuestionsByExamId($id);
        if (!$questions) {
            return $this->response->setJSON(['error' => 'Tidak ada data pertanyaan yang ditemukan untuk ujian ini.']);
        }

        try {
            // Inisialisasi spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header
            $sheet->setCellValue('A1', 'Soal');
            $sheet->setCellValue('B1', 'Pilihan A');
            $sheet->setCellValue('C1', 'Pilihan B');
            $sheet->setCellValue('D1', 'Pilihan C');
            $sheet->setCellValue('E1', 'Pilihan D');
            $sheet->setCellValue('F1', 'Jawaban yang benar');
            $sheet->setCellValue('G1', 'Nilai');
            $sheet->setCellValue('H1', 'Nomor Soal');

            // Set data pertanyaan
            $row = 2;
            foreach ($questions as $question) {
                $pilihanArray = json_decode($question['pilihan'], true);

                $sheet->setCellValue('A' . $row, $question['soal']);
                $sheet->setCellValue('B' . $row, $pilihanArray['A'] ?? '');
                $sheet->setCellValue('C' . $row, $pilihanArray['B'] ?? '');
                $sheet->setCellValue('D' . $row, $pilihanArray['C'] ?? '');
                $sheet->setCellValue('E' . $row, $pilihanArray['D'] ?? '');
                $sheet->setCellValue('F' . $row, $question['correct_answer']);
                $sheet->setCellValue('G' . $row, $question['nilai']);
                $sheet->setCellValue('H' . $row, $question['nomor_soal']);

                $row++;
            }

            ob_start();
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $fileData = ob_get_clean();

            // Menyusun nama file
            $namaFile = 'questions_export_' . $namaUjian . '.xlsx';

            // Mengirim respons HTTP dengan file yang akan diunduh
            return $this->response
                ->download($namaFile, $fileData, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Terjadi kesalahan saat mengekspor data: ' . $e->getMessage()]);
        }
    }

    public function importQuestion($id)
    {
        // Validasi form upload
        $validation = \Config\Services::validation();
        $validation->setRule('fileToUpload', 'Uploaded file', 'uploaded[fileToUpload]|max_size[fileToUpload,1024]|ext_in[fileToUpload,xlsx,xls]');

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->to('/admin/question/' . $id);
        }

        // Ambil file yang di-upload
        $file = $this->request->getFile('fileToUpload');

        try {
            // Validasi file Excel
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getActiveSheet();

            // Loop untuk membaca data dari file Excel
            $dataToInsert = [];
            $id_exam = $id; // ID Exam diambil dari parameter

            foreach ($worksheet->getRowIterator(2) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Include kolom yang kosong

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $dataToInsert[] = [
                    'id_exam' => $id_exam, // ID Exam diambil dari parameter
                    'soal' => $rowData[0],
                    'pilihan' => json_encode([
                        'A' => $rowData[1],
                        'B' => $rowData[2],
                        'C' => $rowData[3],
                        'D' => $rowData[4]
                    ]),
                    'correct_answer' => $rowData[5],
                    'nilai' => $rowData[6],
                    'nomor_soal' => $rowData[7],
                ];
            }

            // Simpan data ke database
            $this->examQuestion->insertBatch($dataToInsert);

            session()->setFlashdata('success', 'Data berhasil di-import.');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat meng-import data.');
        }

        return redirect()->to('/admin/question/' . $id);
    }

    public function database()
    {
        $data = [
            'page_title' => 'Database'
        ];

        return view('admin/database', $data);
    }

    public function exportDatabase()
    {
        // Tentukan lokasi dan nama file untuk menyimpan dump database
        $file_path = 'assets/file/cbt-polinela-tb_exam.sql';

        try {
            // Atur opsi untuk hanya meng-include tabel 'tb_exam'
            $dumpSettings = [
                'include-tables' => ['tb_exam'],
                'add-drop-table' => true,
            ];

            // Buat dump database dengan opsi yang telah ditentukan
            $dump = new IMysqldump\Mysqldump(
                'mysql:host=nss.h.filess.io;port=3307;dbname=cbtpolinela_calljumpgo',
                'cbtpolinela_calljumpgo',
                'd75e5fd26d9c20b5fdf77b87773f3b513ddd04aa',
                $dumpSettings
            );
            $dump->start($file_path);

            // Set pesan sukses
            session()->setFlashdata('success', 'Dump database untuk tabel tb_exam berhasil diunduh.');

            // Redirect ke halaman admin/database
            return redirect()->to('admin/database');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            session()->setFlashdata('error', 'Terjadi kesalahan saat membuat dump database: ' . $e->getMessage());

            // Redirect ke halaman admin/database
            return redirect()->to('admin/database');
        }
    }
}
