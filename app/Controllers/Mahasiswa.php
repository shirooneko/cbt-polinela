<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MatkulModel;
use App\Models\SesiModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamResultModel;
use Bluerhinos\phpMQTT;
use App\Models\ProdiModel;
use App\Models\JurusanModel;


class Mahasiswa extends BaseController
{
    protected $dosen;
    protected $kelas;
    protected $mahasiswa;
    protected $matkul;
    protected $sesi;
    protected $exam;
    protected $examQuestion;
    protected $examResult;
    protected $prodi;
    protected $jurusan;

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
        $this->jurusan = new JurusanModel();
        $this->prodi = new ProdiModel();
    }

    public function index()
    {
        if (!session('id_mahasiswa')) {
            return redirect()->to('/login');
        }

        $data['page_title'] = "dashboard";
        return view('mahasiswa/dashboard', $data);
    }

    public function exam()
    {
        if (!session('id_mahasiswa')) {
            return redirect()->to('/login');
        }

        $id_kelas = session('id_kelas');
        $id_mahasiswa = session('id_mahasiswa');

        $data = [
            'dataMatkul' => $this->matkul->getAllData(),
            'dataKelas' => $this->kelas->getAllData(),
            'dataSesi' => $this->sesi->getAllData(),
            'dataExam' => $this->exam->getAllDataJoinMahasiswa($id_kelas, ['publish', 'expired']),
            'page_title' => "Exam"
        ];

        return view('mahasiswa/exam', $data);
    }

    public function getExamData($id_kelas, $status)
    {
        $dataExam = $this->exam->getAllDataJoinMahasiswa($id_kelas, [$status]);
        echo json_encode($dataExam);
    }

    public function resetSessionData($id)
    {
        $sessionKey = 'question_order_' . $id . '_' . session('id_mahasiswa');
        $currentOrderIndexKey = 'current_order_index_' . $sessionKey;
        session()->remove($sessionKey);
        session()->remove($currentOrderIndexKey);
    }

    // Di dalam controller Anda
    public function setStartTime()
    {
        $request = service('request');
        $start_time = (int) $request->getPost('start_time');

        if ($start_time > 0) {
            session()->set('start_time', $start_time);
            return $this->response->setJSON(['success' => true]);
        } else {
            log_message('error', 'Gagal mendapatkan start_time dari POST request');
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid data type for start_time']);
        }
    }



    public function takeExam($id, $action = null)
    {
        if (!session('id_mahasiswa')) {
            return redirect()->to('/login');
        }

        $sessionKey = 'question_order_' . $id . '_' . session('id_mahasiswa');
        $questionOrder = session($sessionKey);

        // Pastikan variabel $questionOrder sudah diinisialisasi sebelum digunakan
        if ($questionOrder === null) {
            $questionOrder = $this->prepareExamData($id);
            session()->set($sessionKey, $questionOrder);
        }

        $dataExam = $this->examQuestion->getExamDataById($id);
        $start_time = $dataExam['start_time'];
        $end_time = $dataExam['end_time'];
        $current_time = date('Y-m-d H:i:s');
        $remaining_seconds = strtotime($end_time) - strtotime($current_time);

        $currentOrderIndex = $this->initializeCurrentOrderIndex($sessionKey, $questionOrder);

        // Handle user action for navigating questions
        if ($action == 'next' && $currentOrderIndex < count($questionOrder) - 1) {
            $currentOrderIndex++;
        } elseif ($action == 'prev' && $currentOrderIndex > 0) {
            $currentOrderIndex--;
        }

        session()->set('current_order_index_' . $sessionKey, $currentOrderIndex);

        if (empty($questionOrder) || !isset($questionOrder[$currentOrderIndex])) {
            $error_message = empty($questionOrder) ? 'Tidak ada pertanyaan yang tersedia.' : 'Indeks pertanyaan tidak valid.';
            $page_title = $this->exam->find($id)['nama_exam'];
            $data = [
                'error_message' => $error_message,
                'page_title' => $page_title,
                'dataExam' => $dataExam,
                'questionOrder' => $questionOrder,
            ];
            return view('mahasiswa/takeExam', $data);
        } else {
            $currentQuestionNumber = $questionOrder[$currentOrderIndex];
            $singleQuestion = $this->examQuestion->getQuestionByOrder($id, $currentQuestionNumber);

            if (!$singleQuestion) {
                $error_message = 'Tidak dapat menemukan pertanyaan yang diminta.';
                $page_title = $this->exam->find($id)['nama_exam'];
                $data = [
                    'error_message' => $error_message,
                    'page_title' => $page_title,
                    'questionOrder' => $questionOrder,
                    'singleQuestion' => $singleQuestion,
                    'dataExam' => $dataExam,
                ];
                return view('mahasiswa/takeExam', $data);
            }

            $totalQuestions = $this->examQuestion->getTotalQuestions($id);
            $allQuestions = $this->examQuestion->getAllQuestions($id);

            $data = [
                'singleQuestion' => $singleQuestion,
                'allQuestions' => $allQuestions,
                'dataExam' => $dataExam,
                'page_title' => $this->exam->find($id)['nama_exam'],
                'totalQuestions' => $totalQuestions,
                'id' => $id,
                'currentOrderIndex' => $currentOrderIndex,
                'remaining_seconds' => $remaining_seconds,
                'questionOrder' => $questionOrder,
                'answers' => $this->getAnswers($id, $allQuestions)
            ];

            $answers = [];
            foreach ($allQuestions as $question) {
                $jawabanKey = 'jawaban_' . $id . '_' . $question['id_question'] . '_' . session('id_mahasiswa');
                $answers[$question['id_question']] = session($jawabanKey);
            }
            $data['answers'] = $answers;

            // var_dump($allQuestions, $questionOrder, $answers);

            return view('mahasiswa/takeExam', $data);
        }
    }

    public function getAnswers($id_exam, $allQuestions)
    {
        $answers = [];
        foreach ($allQuestions as $question) {
            $jawabanKey = 'jawaban_' . $id_exam . '_' . $question['id_question'] . '_' . session('id_mahasiswa');
            $answers[$question['id_question']] = session($jawabanKey);
        }
        return $answers;
    }

    public function gotoQuestion($id, $index)
    {
        // Pastikan sesi sudah aktif, sesuaikan dengan implementasi Anda
        if (!session('id_mahasiswa')) {
            return redirect()->to('/login');
        }

        $sessionKey = 'question_order_' . $id . '_' . session('id_mahasiswa');
        $questionOrder = session($sessionKey);

        if ($questionOrder === null) {
            // Jika urutan pertanyaan belum diinisialisasi dalam sesi, inisialisasi dulu
            $questionOrder = $this->prepareExamData($id);
            session()->set($sessionKey, $questionOrder);
        }

        // Validasi indeks yang diminta
        if (!isset($questionOrder[$index])) {
            return redirect()->back()->with('error', 'Indeks pertanyaan tidak valid.');
        }

        // Tetapkan indeks yang diminta sebagai indeks saat ini
        session()->set('current_order_index_' . $sessionKey, $index);

        // Redirect kembali ke halaman ujian dengan indeks yang diperbarui
        return redirect()->to('/mahasiswa/takeExam/' . $id);
    }


    public function saveAnswer($id_exam)
    {
        $id_question = $this->request->getPost('id_question');
        $jawaban = $this->request->getPost('jawaban');
        $jawabanKey = 'jawaban_' . $id_exam . '_' . $id_question . '_' . session('id_mahasiswa');
        session()->set($jawabanKey, $jawaban);
        return json_encode(['success' => true, 'message' => 'Jawaban tersimpan']);
    }


    public function clearAnswer($id_exam)
    {
        $id_question = $this->request->getPost('id_question');
        $jawabanKey = 'jawaban_' . $id_exam . '_' . $id_question . '_' . session('id_mahasiswa');
        session()->remove($jawabanKey);  // Menghapus jawaban dari sesi
        return json_encode(['status' => 'pilihan berhasil di hapus']);
    }

    public function prepareExamData($id)
    {
        $allQuestions = $this->examQuestion->getQuestionsByExamIdAdmin($id);
        $questionNumbers = array_column($allQuestions, 'nomor_soal');
        shuffle($questionNumbers);
        return $questionNumbers;
    }

    public function initializeCurrentOrderIndex($sessionKey, $questionOrder)
    {
        $currentOrderIndex = session('current_order_index_' . $sessionKey);
        if ($currentOrderIndex === null || $currentOrderIndex >= count($questionOrder)) {
            $currentOrderIndex = 0;
            session()->set('current_order_index_' . $sessionKey, $currentOrderIndex);
        }
        return $currentOrderIndex;
    }

    public function previousQuestion($id)
    {
        $this->takeExam($id, 'prev');
        return redirect()->to('mahasiswa/takeExam/' . $id);
    }

    public function nextQuestion($id)
    {
        $this->takeExam($id, 'next');
        return redirect()->to('mahasiswa/takeExam/' . $id);
    }


    public function submitAnswer($id_exam)
    {
        $id_mahasiswa = session('id_mahasiswa');

        if (empty($id_mahasiswa) || empty($id_exam)) {
            return redirect()->to('/error');
        }

        $allQuestions = $this->examQuestion->getAllQuestions($id_exam);

        $answeredQuestions = 0;
        $correctAnswers = 0;
        $incorrectAnswers = 0;
        $totalScore = 0;
        $studentAnswers = [];

        foreach ($allQuestions as $question) {
            $jawabanKey = 'jawaban_' . $id_exam . '_' . $question['id_question'] . '_' . $id_mahasiswa;
            $jawaban = session($jawabanKey);

            if ($jawaban !== null) {
                $answeredQuestions++;
                $pilihan = json_decode($question['pilihan'], true);

                if ($pilihan[$jawaban] == $pilihan[$question['correct_answer']]) {
                    $correctAnswers++;
                    $totalScore += $question['nilai'];
                } else {
                    $incorrectAnswers++;
                }

                $studentAnswers[] = [
                    'id_question' => $question['id_question'],
                    'selected_answer' => $jawaban,
                ];

                session()->remove($jawabanKey);
            }
        }

        $unansweredQuestions = count($allQuestions) - $answeredQuestions;
        $start_time = session('start_time');
        $end_time = date('Y-m-d H:i:s');
        $studentAnswersJson = json_encode($studentAnswers);

        $data = [
            'id_mahasiswa' => $id_mahasiswa,
            'id_exam' => $id_exam,
            'total_score' => $totalScore,
            'answered_questions' => $answeredQuestions,
            'correct_answers' => $correctAnswers,
            'incorrect_answers' => $incorrectAnswers,
            'unanswered_questions' => $unansweredQuestions,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'student_answers' => $studentAnswersJson,
            'status' => 'submitted',
        ];

        $this->examResult->save($data);

        // Inisialisasi koneksi MQTT
        $mqtt_broker = "192.168.43.156"; // Ganti dengan alamat broker MQTT
        $mqtt_port = 1883;
        $mqtt_topic = "dataHasilUjian"; // Ganti dengan topik MQTT yang diinginkan
        $mqtt_client_id = "Client_ID";

        $mqtt = new phpMQTT($mqtt_broker, $mqtt_port, $mqtt_client_id);

        // Coba terhubung ke broker MQTT
        if ($mqtt->connect()) {
            // Kirim data hasil ujian ke broker MQTT
            $mqtt_data = [
                'id_mahasiswa' => $id_mahasiswa,
                'id_exam' => $id_exam,
                'total_score' => $totalScore,
                'answered_questions' => $answeredQuestions,
                'correct_answers' => $correctAnswers,
                'incorrect_answers' => $incorrectAnswers,
                'unanswered_questions' => $unansweredQuestions,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'student_answers' => $studentAnswersJson,
                'status' => 'submitted',
            ];

            $mqtt_message = json_encode($mqtt_data);
            $mqtt->publish($mqtt_topic, $mqtt_message, 0);

            // Tutup koneksi MQTT
            $mqtt->close();

            return redirect()->to('/mahasiswa/exam');
        } else {
            // Handle connection error
            echo "Gagal terhubung ke broker MQTT.";
        }
    }

    public function myProfile()
    {
        if (!session('id_mahasiswa')) {
            return redirect()->to('/login');
        }

        $id = session('id_mahasiswa');

        return view('/mahasiswa/my-profile', [
            'page_title' => 'Profile',
            'dataMahasiswa' => $this->mahasiswa->getDataById($id),
            'dataJurusan' => $this->jurusan->getAllData(),
            'dataProdi' => $this->prodi->getAllData(),
        ]);
    }

    public function mahasiswaUpdate($id)
    {
        $mahasiswa = $this->mahasiswa->find($id);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'sex' => $this->request->getPost('sex'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
        ];

        $passwordInput = $this->request->getPost('password');

        if (!empty($passwordInput)) {
            $data['password'] = sha1($passwordInput);
        }

        $this->mahasiswa->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate.');
        return redirect()->to("/mahasiswa/myProfile");
    }

    public function updateFoto()
    {
        $idUser = $this->request->getPost('id_mahasiswa');
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoBaru = $foto->getRandomName();
            $foto->move(FCPATH . 'assets/images/mahasiswa/', $fotoBaru);

            $userInfo = $this->mahasiswa->find($idUser);

            $oldImagePath = FCPATH . '/assets/images/mahasiswa/' . $userInfo['foto'];
            if ($userInfo['foto'] && is_file($oldImagePath) && $userInfo['foto'] !== 'profile.png') {
                unlink($oldImagePath);
            }

            $updateData = ['foto' => $fotoBaru];
            $this->mahasiswa->update($idUser, $updateData);
            session()->setFlashdata('success', 'Foto berhasil diupdate.');
        } else {
            session()->setFlashdata('error', 'Tidak ada foto yang diupload atau terjadi kesalahan.');
        }

        return redirect()->to("/mahasiswa/myProfile");
    }
}
