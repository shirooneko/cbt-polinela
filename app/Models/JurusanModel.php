<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = 'tb_jurusan';
    protected $primaryKey       = 'id_jurusan';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_jurusan', 'nama_jurusan'];


    public function getAllData()
    {
        return $this->findAll();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function getIdByName($name)
    {
        return $this->where('nama_jurusan', $name)->first();
    }
}
