<?php
/**
 * Generate Encryption Key untuk CodeIgniter 4
 * Jalankan: php generate-key.php
 */

function generateEncryptionKey($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = '';
    
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[random_int(0, strlen($characters) - 1)];
    }
    
    return $key;
}

echo "=== ENCRYPTION KEY GENERATOR ===\n";
echo "Generated 32-character encryption key:\n";
echo generateEncryptionKey(32) . "\n";
echo "\nCopy key di atas dan paste ke file .env:\n";
echo "encryption.key = [paste_key_here]\n";
echo "================================\n";
?>
