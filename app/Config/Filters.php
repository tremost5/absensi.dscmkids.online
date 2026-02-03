<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,

        // 🔴 FIX UTAMA (NAMA CLASS YANG BENAR)
        'auth' => \App\Filters\AuthFilter::class,
        'role' => \App\Filters\RoleFilter::class,
    ];

    public array $globals = [
        'before' => [
            'csrf' => [
                'except' => [
                    'guru/absen', // AJAX sekolah minggu
                ],
            ],
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}
