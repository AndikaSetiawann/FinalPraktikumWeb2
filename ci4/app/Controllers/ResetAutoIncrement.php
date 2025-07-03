<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ResetAutoIncrement extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get current max ID
        $query = $db->query("SELECT MAX(id) as max_id FROM artikel");
        $result = $query->getRow();
        $maxId = $result->max_id ?? 0;
        
        // Set auto increment to next number
        $nextId = $maxId + 1;
        $db->query("ALTER TABLE artikel AUTO_INCREMENT = $nextId");
        
        echo "<h2>✅ Auto Increment Reset!</h2>";
        echo "<p>Current Max ID: $maxId</p>";
        echo "<p>Next Auto Increment: $nextId</p>";
        echo "<br><a href='/admin/artikel'>← Kembali ke Admin</a>";
        echo "<br><a href='/lab8_vuejs/index.html'>← Kembali ke Vue.js</a>";
    }
}
?>
