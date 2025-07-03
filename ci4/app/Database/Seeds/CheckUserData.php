<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CheckUserData extends Seeder
{
    public function run()
    {
        // Cek semua data di tabel user
        $users = $this->db->table('user')->get()->getResult();

        echo "=== DATA USER DI DATABASE ===\n";
        if (empty($users)) {
            echo "Tidak ada data user di database!\n";
        } else {
            foreach ($users as $user) {
                echo "ID: " . $user->id . "\n";
                echo "Username: " . $user->username . "\n";
                echo "Email: " . $user->useremail . "\n";
                echo "Password Hash: " . substr($user->userpassword, 0, 20) . "...\n";
                echo "---\n";
            }
        }

        // Cek struktur tabel
        echo "\n=== STRUKTUR TABEL USER ===\n";
        $fields = $this->db->getFieldNames('user');
        foreach ($fields as $field) {
            echo "- " . $field . "\n";
        }
    }
}
