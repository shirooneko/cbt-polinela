<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MatkulModel;
use App\Models\SesiModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamResultModel;

class Dosen extends BaseController
{
    protected $dosen;
    protected $kelas;
    protected $mahasiswa;
    protected $matkul;
    protected $sesi;
    protected $exam;
    protected $examQuestion;
    protected $examResult;

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
    }

    public function index()
    {
        if (!session('id_dosen')) {
            return redirect()->to('/login');
        }

        $data['page_title'] = "dashboard";
        return view('dosen/dashboard', $data);
    }

    public function exam()
    {
        if (!session('id_dosen')) {
            return redirect()->to('/login');
        }

        $id_dosen = session('id_dosen');

        $data = [
            'dataMatkul' => $this->matkul->getDataMatkulDosen($id_dosen),
            'dataSesi' => $this->sesi->getAllData(),
            'dataKelas' => $this->kelas->getAllData(),
            'dataExam' => $this->exam->getAllDataJoinDosen($id_dosen),
            'page_title' => "Exam"
        ];

        return view('dosen/exam', $data);
    }

    public function filterExams()
    {
        $id_dosen = session('id_dosen');
        $status = $this->request->getVar('status');
        $id_kelas = $this->request->getVar('id_kelas');
        $id_sesi = $this->request->getVar('id_sesi');
        $id_matkul = $this->request->getVar('id_matkul');

        $dataExam = $this->exam->getAllDataJoinDosen($id_dosen, $status, $id_kelas, $id_sesi, $id_matkul);

        return $this->response->setJSON($dataExam);
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
        return redirect()->to('dosen/exam');
    }

    public function examUpdate($id)
    {
        // Ambil data dari request
        $data = [
            'nama_exam' => $this->request->getPost('nama_exam'),
            'id_matkul' => $this->request->getPost('id_matkul'),
            'id_sesi' => $this->request->getPost('id_sesi'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'tgl_exam' => $this->request->getPost('tgl_exam'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time')
        ];

        // Simpan data ke database
        $this->exam->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to('dosen/exam');
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
            return redirect()->to('dosen/exam');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $error = $e->getMessage();
            if (strpos($error, '1451') !== false) {
                session()->setFlashdata('error', 'Tidak dapat menghapus ujian karena masih ada soal atau peserta yang terkait dengan ujian ini.');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan: Data sedang digunakan');
            }
            return redirect()->to('dosen/exam');
        }
    }

    public function publish($id)
    {
        $exam = $this->exam->find($id);
        if (!$exam) {
            session()->setFlashdata('error', 'Ujian tidak ditemukan.');
            return redirect()->to('dosen/exam');
        }

        $data = ['status' => 'publish'];
        $this->exam->update($id, $data);

        session()->setFlashdata('success', 'Ujian berhasil dipublish.');
        return redirect()->to('dosen/exam');
    }

    public function examViewResult($id)
    {
        $id_kelas = $this->exam->find($id)['id_kelas'];  // asumsi id_kelas tersedia di data ujian
        $results = $this->examResult->getResultsByClassAndExam($id, $id_kelas);  // panggil method baru

        $data = [
            'dataExam' => $this->examQuestion->getExamDataById($id),
            'results' => $results,  // tambahkan ini ke array data
            'page_title' => $this->exam->find($id)['nama_exam']
        ];
        return view('dosen/examViewResult', $data);
    }


    //************************************//
    // bagian manage exam question start //
    //**********************************//

    public function question($id)
    {
        if (!session('id_dosen')) {
            return redirect()->to('/login');
        }

        $data = [
            'totalPoints' => $this->examQuestion->calculateTotalPoints($id),
            'dataExamQuestion' => $this->examQuestion->getQuestionsByExamIdDosen($id),
            'dataExam' => $this->examQuestion->getExamDataById($id),
            'page_title' => $this->exam->find($id)['nama_exam']
        ];

        // Ambil daftar ujian dengan id mata kuliah yang sama
        $id_matkul = $data['dataExam']['id_matkul'];
        $similarExams = $this->exam->getExamsByMatkul($id_matkul);

        $data = [
            'similarExams' => $similarExams,
            'page_title' => $this->exam->find($id)['nama_exam'],
            'dataExamQuestion' => $this->examQuestion->getQuestionsByExamIdDosen($id),
            'dataExam' => $this->examQuestion->getExamDataById($id),
            'totalPoints' => $this->examQuestion->calculateTotalPoints($id),
            'id' => $id,
        ];

        return view('dosen/examAddQuestion', $data);
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
        return redirect()->to('dosen/question/' . $id);
    }


    public function questionUpdate($id_question)
    {
        helper(['form', 'url']);

        // Mengambil data dari form
        $soal = $this->request->getPost('soal');
        $jawaban_benar = $this->request->getPost('jawaban_benar');
        $nilai = $this->request->getPost('nilai');

        // Menyusun pilihan dan gambar pilihan ke dalam format JSON
        $pilihan = [];
        $gambar_pilihan = [];
        foreach (['A', 'B', 'C', 'D'] as $huruf) {
            $pilihan[$huruf] = $this->request->getPost('pilihan_' . strtolower($huruf));

            // Memeriksa apakah file gambar pilihan diunggah
            $fileGambarPilihan = $this->request->getFile('gambar_pilihan_' . strtolower($huruf));
            if ($fileGambarPilihan->isValid() && !$fileGambarPilihan->hasMoved()) {
                $namaGambarPilihan = $fileGambarPilihan->getRandomName();
                $fileGambarPilihan->move('assets/images/exam/pilihan', $namaGambarPilihan);
                $gambar_pilihan[$huruf] = $namaGambarPilihan;
            } else {
                // Jika tidak ada file gambar baru, gunakan gambar lama
                $questionData = $this->examQuestion->find($id_question);
                $gambar_pilihan_lama = json_decode($questionData['gambar_pilihan'], true);
                $gambar_pilihan[$huruf] = $gambar_pilihan_lama[$huruf];
            }
        }
        $pilihan_string = json_encode($pilihan);
        $gambar_pilihan_string = json_encode($gambar_pilihan);

        // Memeriksa apakah file gambar soal diunggah
        $fileGambarSoal = $this->request->getFile('gambar_soal');
        $gambar_soal = null;
        if ($fileGambarSoal->isValid() && !$fileGambarSoal->hasMoved()) {
            $namaGambarSoal = $fileGambarSoal->getRandomName();
            $fileGambarSoal->move('assets/images/exam/soal', $namaGambarSoal);
            $gambar_soal = $namaGambarSoal;
        } else {
            // Jika tidak ada file gambar baru, gunakan gambar lama
            $questionData = $this->examQuestion->find($id_question);
            $gambar_soal = $questionData['gambar_soal'];
        }

        // Menyusun data untuk update
        $data = [
            'soal' => $soal,
            'pilihan' => $pilihan_string,
            'gambar_pilihan' => $gambar_pilihan_string,
            'gambar_soal' => $gambar_soal,
            'correct_answer' => $jawaban_benar,
            'nilai' => $nilai
        ];

        // Melakukan update data
        $this->examQuestion->update($id_question, $data);

        // Mendapatkan id_exam dari database berdasarkan id_question
        $questionData = $this->examQuestion->find($id_question);
        $id_exam = $questionData['id_exam'];

        // Memberikan feedback ke user dan mengarahkan kembali ke halaman question
        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('dosen/question/' . $id_exam);
    }

    public function questionDelete($id)
    {
        $questionData = $this->examQuestion->find($id);
        $id_exam = $questionData['id_exam'];

        // Menghapus gambar soal jika ada
        if ($questionData['gambar_soal']) {
            unlink('assets/images/exam/soal/' . $questionData['gambar_soal']);
        }

        $gambar_pilihan = json_decode($questionData['gambar_pilihan'], true);

        // Cek jika $gambar_pilihan adalah array sebelum iterasi
        if (is_array($gambar_pilihan)) {
            foreach ($gambar_pilihan as $gambar) {
                if ($gambar) {
                    unlink('assets/images/exam/pilihan/' . $gambar);
                }
            }
        }

        // Menghapus data soal dari database
        $this->examQuestion->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('dosen/question/' . $id_exam);
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
            return redirect()->to('/dosen/question/' . $id);
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

                // Strukturkan data sesuai kebutuhan Anda
                // $rowData[0] adalah Soal
                // $rowData[1] adalah Pilihan A
                // $rowData[2] adalah Pilihan B
                // $rowData[3] adalah Pilihan C
                // $rowData[4] adalah Pilihan D
                // $rowData[5] adalah Jawaban yang benar
                // $rowData[6] adalah Nilai
                // $rowData[7] adalah Nomor Soal

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

        return redirect()->to('/dosen/question/' . $id);
    }


    //**********************************//
    // bagian manage exam question end //
    //********************************//
}
