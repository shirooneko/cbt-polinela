<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AkademikModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MatkulModel;
use App\Models\SesiModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\ExamResultModel;

class Akademik extends BaseController
{
    protected $akademik;
    protected $kelas;
    protected $mahasiswa;
    protected $matkul;
    protected $sesi;
    protected $exam;
    protected $examQuestion;
    protected $examResult;

    public function __construct()
    {
        $this->akademik = new AkademikModel();
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
        if (!session('id_akademik')) {
            return redirect()->to('/login');
        }

        $data['page_title'] = "dashboard";
        return view('akademik/dashboard', $data);
    }

    public function exam()
    {
        if (!session('id_akademik')) {
            return redirect()->to('/login');
        }

        $id_dosen = session('id_dosen');

        $data = [
            'dataMatkul' => $this->matkul->getDataMatkulDosen($id_dosen),
            'dataSesi' => $this->sesi->getAllData(),
            'dataKelas' => $this->kelas->getAllData(),
            'dataExam' => $this->exam->getExamForAkademik(),
            'page_title' => "Nilai"
        ];

        return view('akademik/exam', $data);
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
        return view('akademik/examViewResult', $data);
    }
}