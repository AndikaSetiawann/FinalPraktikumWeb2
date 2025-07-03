<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah user Admin sudah ada
        $existingUser = $this->db->table('user')->where('username', 'Admin')->get()->getRow();

        if (!$existingUser) {
            $data = [
                'useremail'    => 'admin@email.com',
                'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
                'username'     => 'Admin',
            ];

            // Insert user baru
            $this->db->table('user')->insert($data);
            echo "User Admin berhasil dibuat.\n";
        } else {
            echo "User Admin sudah ada, skip insert.\n";
        }
    }
}