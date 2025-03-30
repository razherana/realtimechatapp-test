<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
      $this->db->table('users')->insertBatch([
        [
          'username' => 'admin',
          'email'    => 'admin@example.com',
          'password' => password_hash('admin123', PASSWORD_BCRYPT),
          'created_at' => date('Y-m-d H:i:s'),
        ],
        [
          'username' => 'user1',
          'email'    => 'user1@example.com',
          'password' => password_hash('user123', PASSWORD_BCRYPT),
          'created_at' => date('Y-m-d H:i:s'),
        ],
        [
          'username' => 'user2',
          'email'    => 'user2@example.com',
          'password' => password_hash('user123', PASSWORD_BCRYPT),
          'created_at' => date('Y-m-d H:i:s'),
        ],
      ]);
    }
}
