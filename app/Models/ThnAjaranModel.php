<?php

namespace App\Models;

use CodeIgniter\Model;

class ThnAjaranModel extends Model
{
    protected $table = 'tb_thnajaran';
    protected $primaryKey = 'id_thnAjaran';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_thnAjaran', 'tahun_ajaran', 'status'];

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
