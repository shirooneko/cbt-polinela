<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model
{
    protected $table            = 'tb_exam';
    protected $primaryKey       = 'id_exam';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_exam', 'nama_exam', 'start_time', 'end_time', 'duration', 'tgl_exam', 'id_kelas', 'id_matkul', 'id_sesi', 'status'];


    public function getAllData()
    {
        return $this->findAll();
    }

    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getExamsByMatkul($id_matkul)
    {
        return $this->where('id_matkul', $id_matkul)->findAll();
    }


    public function getAllDataJoin($status = null)
    {
        $builder = $this->db->table('tb_exam e');
        $builder->select('e.*, k.nama as nama_kelas, m.nama as nama_matkul, s.nama_sesi as nama_sesi');
        $builder->join('tb_kelas k', 'k.id_kelas = e.id_kelas');
        $builder->join('tb_matkul m', 'm.id_matkul = e.id_matkul');
        $builder->join('tb_sesi s', 's.id_sesi = e.id_sesi');

        if ($status) {
            $builder->where('e.status', $status);
        }

        return $builder->get()->getResultArray();
    }

    public function getAllDataJoinMahasiswa($id_kelas, $status = null)
    {
        $id_mahasiswa = session('id_mahasiswa');

        $builder = $this->db->table('tb_exam e');
        $builder->select('e.*, k.nama as nama_kelas, m.nama as nama_matkul, s.nama_sesi as nama_sesi, er.status as exam_status, er.total_score');
        $builder->join('tb_kelas k', 'k.id_kelas = e.id_kelas');
        $builder->join('tb_matkul m', 'm.id_matkul = e.id_matkul');
        $builder->join('tb_sesi s', 's.id_sesi = e.id_sesi');
        $builder->join('tb_exam_results er', 'er.id_exam = e.id_exam AND er.id_mahasiswa = ' . $this->db->escape($id_mahasiswa), 'left');
        $builder->where('e.id_kelas', $id_kelas);
        if ($status) {
            $builder->whereIn('e.status', $status);
        }

        return $builder->get()->getResultArray();
    }

    public function getAllDataJoinDosen($id_dosen, $status = null, $id_kelas = null, $id_sesi = null, $id_matkul = null)
    {
        $builder = $this->db->table('tb_exam');
        $builder->select('
        tb_exam.*,
        tb_matkul.nama as nama_matkul,
        tb_kelas.nama as nama_kelas,
        tb_sesi.nama_sesi as nama_sesi,
        tb_exam.start_time,
        tb_exam.end_time,
        tb_exam.status,
        tb_exam.tgl_exam
    ');

        $builder->join('tb_matkul', 'tb_exam.id_matkul = tb_matkul.id_matkul');
        $builder->join('tb_kelas', 'tb_exam.id_kelas = tb_kelas.id_kelas', 'left');
        $builder->join('tb_sesi', 'tb_exam.id_sesi = tb_sesi.id_sesi', 'left');
        $builder->where('tb_matkul.id_dosen', $id_dosen);

        if ($status) {
            $builder->where('tb_exam.status', $status);
        }
        if ($id_kelas) {
            $builder->where('tb_exam.id_kelas', $id_kelas);
        }
        if ($id_sesi) {
            $builder->where('tb_exam.id_sesi', $id_sesi);
        }
        if ($id_matkul) {
            $builder->where('tb_exam.id_matkul', $id_matkul);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }


    public function checkAndUpdateExamStatus()
    {
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $builder = $this->db->table($this->table);
    
        $builder->where('status', 'publish');
        $builder->where("tgl_exam < '$currentDate' OR end_time < '$currentTime'");
    
        $builder->update(['status' => 'expired']);
    }    


    public function countExamsByStatus()
    {
        $builder = $this->db->table('tb_exam');
        $pending = $builder->where('status', 'pending')->countAllResults();
        $publish = $builder->where('status', 'publish')->countAllResults();
        $expired = $builder->where('status', 'expired')->countAllResults();

        return [
            'pending' => $pending,
            'publish' => $publish,
            'expired' => $expired
        ];
    }

    public function countExams($status = null)
    {
        if ($status === null) {
            return $this->countAllResults();
        } else {
            return $this->where('status', $status)->countAllResults();
        }
    }

    public function getExamForAkademik()
    {
        $builder = $this->db->table('tb_exam');
        $builder->select('
        tb_exam.*,
        tb_matkul.nama as nama_matkul,
        tb_kelas.nama as nama_kelas,
        tb_sesi.nama_sesi as nama_sesi,
        tb_exam.start_time,
        tb_exam.end_time,
        tb_exam.status,
        tb_exam.tgl_exam
    ');

        $builder->join('tb_matkul', 'tb_exam.id_matkul = tb_matkul.id_matkul');
        $builder->join('tb_kelas', 'tb_exam.id_kelas = tb_kelas.id_kelas', 'left');
        $builder->join('tb_sesi', 'tb_exam.id_sesi = tb_sesi.id_sesi', 'left');
        $builder->where('tb_exam.status', 'expired');

        $query = $builder->get();
        return $query->getResultArray();
    }
}
