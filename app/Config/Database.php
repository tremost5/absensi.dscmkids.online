<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public $defaultGroup = 'default';

    public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'dscx7887_absensi_sekolah_minggu',
        'password' => 'VS.86cp28.',
        'database' => 'dscx7887_absensi_sekolah_minggu',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => false,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => '',
        'password' => '',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_',
        'pConnect' => false,
        'DBDebug'  => true,
    ];

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
