<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail = 'helper@dscmkids.online';
    public $fromName  = 'Absensi Sekolah Minggu';

    public $protocol  = 'smtp';
    public $SMTPHost  = 'mail.dscmkids.online';
    public $SMTPUser  = 'helper@dscmkids.online';
    public $SMTPPass  = 'RF.JMa_=AI@at~@)';
    public $SMTPPort  = 587;
    public $SMTPCrypto = 'tls';

    public $mailType = 'html';
    public $charset  = 'UTF-8';
    public $wordWrap = true;
}
