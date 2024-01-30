<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'tb_mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_mahasiswa', 'npm', 'nama', 'foto', 'sex', 'tempat_lahir', 'tgl_lahir', 'angkatan', 'id_kelas', 'id_jurusan', 'id_prodi', 'email', 'password', 'role', 'status'];


    public function getAllData()
    {
        return $this->findAll();
    }

    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getAllDataJoin()
    {
        $builder = $this->db->table('tb_mahasiswa');
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');

        return $builder->get()->getResultArray();
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getMahasiswaByKelas($kelasId, $start, $length, $search = '', $orderColumn = '', $orderDir = 'asc')
    {
        $builder = $this->db->table('tb_mahasiswa');
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.id_prodi');
        $builder->where('tb_mahasiswa.id_kelas', $kelasId);

        // Untuk pencarian
        if ($search !== '') {
            $builder->like('nama', $search);
        }

        // Untuk sorting
        if ($orderColumn !== '') {
            $builder->orderBy($orderColumn, $orderDir);
        }

        // Untuk pagination
        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function countFiltered($kelasId, $search = '')
    {
        $builder = $this->db->table('tb_mahasiswa');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->where('tb_mahasiswa.id_kelas', $kelasId);

        if ($search !== '') {
            $builder->like('nama', $search);
        }

        return $builder->countAllResults();
    }

    public function countAllKelas($kelasId)
    {
        $builder = $this->db->table('tb_mahasiswa');
        $builder->where('id_kelas', $kelasId);
        return $builder->countAllResults();
    }

    public function searchMahasiswaByName($keyword)
    {

        $builder = $this->db->table($this->table);
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.id_prodi');
        $builder->like('tb_mahasiswa.nama', $keyword);

        return $builder->get()->getResultArray();
    }

    public function searchMahasiswaByNpm($npm)
    {

        $builder = $this->db->table($this->table);
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.id_prodi');
        $builder->like('tb_mahasiswa.npm', $npm);

        return $builder->get()->getResultArray();
    }


    public function searchMahasiswaByKelasAndName($kelasId, $keyword)
    {

        $builder = $this->db->table($this->table);
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.id_prodi');
        $builder->where('tb_mahasiswa.id_kelas', $kelasId);
        $builder->like('tb_mahasiswa.nama', $keyword);

        return $builder->get()->getResultArray();
    }

    public function searchMahasiswaByKelasAndNpm($kelasId, $keyword)
    {

        $builder = $this->db->table($this->table);
        $builder->select('tb_mahasiswa.*, tb_kelas.nama as nama_kelas, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_kelas', 'tb_kelas.id_kelas = tb_mahasiswa.id_kelas');
        $builder->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.id_prodi');
        $builder->where('tb_mahasiswa.id_kelas', $kelasId);
        $builder->like('tb_mahasiswa.npm', $keyword);

        return $builder->get()->getResultArray();
    }



    public function countMahasiswa()
    {
        return $this->countAll();
    }

    public function countStatusOn()
    {
        return $this->where('status', 'ON')->countAllResults();
    }
}
