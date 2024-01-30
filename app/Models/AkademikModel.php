<?php

namespace App\Models;

use CodeIgniter\Model;

class AkademikModel extends Model
{
    protected $table            = 'tb_akademik';
    protected $primaryKey       = 'id_akademik';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_akademik', 'nama', 'foto', 'username', 'password', 'role', 'status'];


    public function getAllData()
    {
        return $this->findAll();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    //method untuk mencari data username
    public function findByEmail($email)
    {
        return $this->where('username', $email)->first();
    }

    public function countStatusOn()
    {
        return $this->where('status', 'ON')->countAllResults();
    }

    public function countAkademik()
    {
        return $this->countAll();
    }
}
