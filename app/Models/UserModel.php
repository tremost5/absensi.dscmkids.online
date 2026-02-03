<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table='users';
    protected $primaryKey='id';
    protected $allowedFields = [
    'role_id',
    'nama_depan',
    'nama_belakang',
    'username',
    'email',
    'password',
    'phone',
    'alamat',
    'tanggal_lahir',
    'foto',
    'status',
    'session_token',
    'last_login' // 🔥 WAJIB ADA
];

}
