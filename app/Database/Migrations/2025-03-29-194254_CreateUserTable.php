<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
  public function up()
  {
    $this->forge->addPrimaryKey('id')->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true,
      ],
      'username' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'email' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
      ],
      'password' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
      ],
      'created_at' => [
        'type' => 'DATETIME',
        'default' => date('Y-m-d H:i:s'),
      ],
    ])->createTable('users');

    
  }

  public function down()
  {
    $this->forge->dropTable('users');
  }
}
