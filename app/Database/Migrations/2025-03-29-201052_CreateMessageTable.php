<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMessageTable extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true,
      ],
      'sender_id' => [
        'type' => 'INT',
        'constraint' => 11,
      ],
      'receiver_id' => [
        'type' => 'INT',
        'constraint' => 11,
      ],
      'message' => [
        'type' => 'TEXT',
      ],
      'created_at' => [
        'type' => 'DATETIME',
        'default' => date('Y-m-d H:i:s'),
      ],
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('sender_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('receiver_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('messages');
  }

  public function down()
  {
    $this->forge->dropForeignKey('messages', 'sender_id');
    $this->forge->dropForeignKey('messages', 'receiver_id');
    $this->forge->dropTable('messages');
  }
}
