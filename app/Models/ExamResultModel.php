<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamResultModel extends Model
{
    protected $table = 'tb_exam_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_mahasiswa', 'id_exam', 'total_score', 'answered_questions', 'correct_answers', 'incorrect_answers', 'unanswered_questions', 'start_time', 'end_time', 'student_answers', 'status'];

    public function getResultsByClassAndExam($id_exam, $id_kelas)
    {
        $builder = $this->db->table('tb_exam_results');
        $builder->select('tb_exam_results.*, tb_mahasiswa.*');  // Tambahkan field yang diinginkan
        $builder->join('tb_exam', 'tb_exam.id_exam = tb_exam_results.id_exam');
        $builder->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_exam_results.id_mahasiswa');  // Join dengan tabel mahasiswa
        $builder->where('tb_exam_results.id_exam', $id_exam);
        $builder->where('tb_exam.id_kelas', $id_kelas);

        return $builder->get()->getResultArray();
    }
}
