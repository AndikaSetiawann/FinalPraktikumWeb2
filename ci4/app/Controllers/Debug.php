<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function session()
    {
        echo "<h2>Session Debug</h2>";
        echo "<pre>";
        print_r(session()->get());
        echo "</pre>";
        
        echo "<h3>Specific Session Values:</h3>";
        echo "logged_in: " . (session()->get('logged_in') ? 'true' : 'false') . "<br>";
        echo "role: " . session()->get('role') . "<br>";
        echo "email: " . session()->get('email') . "<br>";
        echo "name: " . session()->get('name') . "<br>";
        
        echo "<h3>Test Links:</h3>";
        echo '<a href="/admin/artikel">Admin Dashboard</a><br>';
        echo '<a href="/user/dashboard">User Dashboard</a><br>';
        echo '<a href="/user/login">Login</a><br>';
    }
}
