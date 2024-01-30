<?php

namespace App\Models;

use CodeIgniter\Model;

class MatkulModel extends Model
{
    protected $table            = 'tb_matkul';
    protected $primaryKey       = 'id_matkul';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_matkul', 'nama', 'kode_matkul', 'semester', 'thn_ajaran', 'id_dosen'];


    public function getAllData()
    {
        return $this->findAll();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getAllDataJoin()
    {
        $builder = $this->db->table('tb_matkul');
        $builder->select('tb_matkul.*, tb_dosen.nama as nama_dosen');
        $builder->join('tb_dosen', 'tb_dosen.id_dosen = tb_matkul.id_dosen');

        return $builder->get()->getResultArray();
    }

    public function getMatkulByDosen($id_dosen)
    {
        return $this->where('id_dosen', $id_dosen)->findAll();
    }

    public function getDataMatkulDosen($id_dosen)
    {
        return $this->where('id_dosen', $id_dosen)->findAll();
    }
}
