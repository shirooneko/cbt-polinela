<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'tb_kelas';
    protected $primaryKey       = 'id_kelas';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_kelas', 'nama', 'semester', 'id_prodi'];


    public function getAllData()
    {
        $builder = $this->db->table('tb_kelas');
        $builder->select('tb_kelas.*, tb_prodi.nama_prodi as nama_prodi');
        $builder->join('tb_prodi', 'tb_kelas.id_prodi = tb_prodi.id_prodi');
        $builder->orderBy('tb_kelas.nama', 'asc');
        $query = $builder->get();

        return $query->getResultArray();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getIdByName($name)
    {
        return $this->where('nama', $name)->first();
    }
}
