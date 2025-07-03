<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TestSequential extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        echo "<h2>Test Sequential ID System</h2>";
        
        // Show current articles
        $query = $db->query("SELECT id, judul FROM artikel ORDER BY id ASC");
        $articles = $query->getResultArray();
        
        echo "<h3>Current Articles:</h3>";
        if (empty($articles)) {
            echo "<p>No articles found.</p>";
        } else {
            echo "<ul>";
            foreach ($articles as $article) {
                echo "<li>ID: {$article['id']} - {$article['judul']}</li>";
            }
            echo "</ul>";
        }
        
        // Test next available ID
        $nextId = $this->getNextAvailableId();
        echo "<h3>Next Available ID: {$nextId}</h3>";
        
        // Show gaps
        if (!empty($articles)) {
            $existingIds = array_column($articles, 'id');
            $maxId = max($existingIds);
            $gaps = [];
            
            for ($i = 1; $i <= $maxId; $i++) {
                if (!in_array($i, $existingIds)) {
                    $gaps[] = $i;
                }
            }
            
            if (!empty($gaps)) {
                echo "<h3>ID Gaps Found: " . implode(', ', $gaps) . "</h3>";
            } else {
                echo "<h3>No ID gaps found</h3>";
            }
        }
        
        echo "<br><a href='/lab8_vuejs/index.html'>Back to Vue.js</a>";
    }
    
    private function getNextAvailableId()
    {
        $db = \Config\Database::connect();
        
        // Get all existing IDs in order
        $query = $db->query("SELECT id FROM artikel ORDER BY id ASC");
        $existingIds = array_column($query->getResultArray(), 'id');
        
        // Find the first gap in the sequence
        $expectedId = 1;
        foreach ($existingIds as $id) {
            if ($id != $expectedId) {
                // Found a gap, return the missing ID
                return $expectedId;
            }
            $expectedId++;
        }
        
        // No gaps found, return the next sequential ID
        return $expectedId;
    }
}
