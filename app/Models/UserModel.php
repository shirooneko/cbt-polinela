<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $allowedFields       = ['id_user', 'nama', 'foto', 'username', 'password', 'role', 'status'];


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
    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function countStatusOn()
    {
        return $this->where('status', 'ON')->countAllResults();
    }

    public function countAdmin()
    {
        return $this->countAll();
    }
}
