<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'tb_dosen';
    protected $primaryKey       = 'id_dosen';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['nip', 'nama', 'email', 'password', 'foto','id_dosen','role', 'status'];


    public function getAllData()
    {
        return $this->findAll();
    }

    //mengambil data berdasarkan id
    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function countDosen()
    {
        return $this->countAll();
    }

    public function countStatusOn()
    {
        return $this->where('status', 'ON')->countAllResults();
    }

}
