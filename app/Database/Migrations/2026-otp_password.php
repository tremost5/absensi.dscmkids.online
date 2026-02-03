<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OtpPassword extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','auto_increment'=>true],
            'user_id' => ['type'=>'INT'],
            'otp' => ['type'=>'VARCHAR','constraint'=>6],
            'expired_at' => ['type'=>'DATETIME'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('password_otps');
    }

    public function down()
    {
        $this->forge->dropTable('password_otps');
    }
}
