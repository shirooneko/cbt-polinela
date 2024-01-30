<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'tb_prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_prodi', 'nama_prodi', 'id_jurusan'];


    public function getAllData()
    {
        $builder = $this->db->table('tb_prodi');
        $builder->select('tb_prodi.*, tb_jurusan.*');
        $builder->join('tb_jurusan', 'tb_jurusan.id_jurusan = tb_prodi.id_jurusan');
        $result = $builder->get()->getResultArray();
    
        return $result;    
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getIdByName($name)
    {
        return $this->where('nama_prodi', $name)->first();
    }
}
