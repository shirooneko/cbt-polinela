<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table            = 'tb_question';
    protected $primaryKey       = 'id_question';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['	id_question', 'id_exam', 'soal', 'pilihan', 'correct_answer', 'nilai', 'nomor_soal','gambar_soal','gambar_pilihan', 'id_matkul'];


    public function getAllData()
    {
        return $this->findAll();
    }

    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function calculateTotalPoints($id_exam)
    {
        $builder = $this->db->table('tb_question');
        $builder->selectSum('nilai');
        $builder->where('id_exam', $id_exam);
        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['nilai'];
    }

    public function getQuestionsByExamIdAdmin($id_exam)
    {
        return $this->where('id_exam', $id_exam)->findAll();
    }

    public function getQuestionsByExamIdDosen($id_exam)
    {
        return $this->where('id_exam', $id_exam)->findAll();
    }

    public function getExamDataById($id)
    {
        $builder = $this->db->table('tb_exam');
        $builder->select('tb_exam.*, tb_kelas.nama AS nama_kelas, tb_sesi.nama_sesi, tb_matkul.nama AS nama_matkul');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_exam.id_kelas');
        $builder->join('tb_sesi', 'tb_sesi.id_sesi = tb_exam.id_sesi');
        $builder->join('tb_matkul', 'tb_matkul.id_matkul = tb_exam.id_matkul');
        $builder->where('tb_exam.id_exam', $id);
        return $builder->get()->getRowArray();
    }


    public function getQuestionByOrder($id_exam, $order)
    {
        return $this->where('id_exam', $id_exam)
            ->where('nomor_soal', $order)
            ->first();
    }

    public function getTotalQuestions($id_exam)
    {
        return $this->where('id_exam', $id_exam)->countAllResults();
    }

    public function getAllQuestions($id_exam) {
        return $this->where('id_exam', $id_exam)->findAll();
    }
    
    public function getOldQuestionsByMatkul($id_matkul)
    {
        return $this->where('id_matkul', $id_matkul)->findAll();
    }

    public function getQuestionsByExamId($examId)
    {
        return $this->where('id_exam', $examId)->findAll();
    }

    public function getIdMatkulByExamId($id_exam)
    {
        $examModel = new ExamModel(); // Gantilah sesuai dengan nama model dan lokasi model Anda

        // Menggunakan ExamModel untuk mendapatkan id_matkul
        $examData = $examModel->find($id_exam);

        // Periksa apakah data ujian ditemukan
        if ($examData) {
            return $examData['id_matkul'];
        } else {
            return null; // Atau dapatkan nilai default sesuai kebutuhan Anda
        }
    }
}
