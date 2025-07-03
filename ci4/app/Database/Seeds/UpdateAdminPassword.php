<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateAdminPassword extends Seeder
{
    public function run()
    {
        // Update data admin yang sudah ada
        $newPassword = password_hash('admin123', PASSWORD_DEFAULT);

        $this->db->table('user')
                 ->where('username', 'admin')
                 ->update([
                     'userpassword' => $newPassword,
                     'useremail' => 'admin@email.com',
                     'username' => 'Admin'
                 ]);

        echo "Data Admin berhasil diupdate:\n";
        echo "- Email: admin@email.com\n";
        echo "- Username: Admin\n";
        echo "- Password: admin123\n";
    }
}
