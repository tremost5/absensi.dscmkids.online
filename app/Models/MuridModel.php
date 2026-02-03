<?php
namespace App\Models;

use CodeIgniter\Model;

class MuridModel extends Model
{
    protected $table = 'murid';
    protected $allowedFields = [
        'kelas_id','nama_depan','nama_belakang',
        'alamat','no_hp','foto','status'
    ];
}
