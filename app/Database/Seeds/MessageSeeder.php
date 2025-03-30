<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MessageSeeder extends Seeder
{
  public function run()
  {
    $this->db->table('messages')->insertBatch([
      [
        'sender_id' => 1,
        'receiver_id' => 2,
        'message' => 'Hello, how are you?',
        'created_at' => date('Y-m-d H:i:s'),
      ],
      [
        'sender_id' => 2,
        'receiver_id' => 1,
        'message' => 'I am good, thank you! How about you?',
        'created_at' => date('Y-m-d H:i:s'),
      ],
      [
        'sender_id' => 1,
        'receiver_id' => 2,
        'message' => 'I am doing well too. Thanks for asking!',
        'created_at' => date('Y-m-d H:i:s'),
      ],
    ]);
  }
}
