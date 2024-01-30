<?php

namespace App\Models;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table = 'tb_sesi';
    protected $primaryKey = 'id_sesi';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_sesi', 'nama_sesi'];

    public function getAllData()
    {
        return $this->findAll();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }
}
