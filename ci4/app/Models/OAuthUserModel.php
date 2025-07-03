<?php

namespace App\Models;

use CodeIgniter\Model;

class OAuthUserModel extends Model
{
    protected $table            = 'oauth_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'google_id',
        'email',
        'password',
        'login_type',
        'name',
        'avatar',
        'email_verified',
        'email_verification_token',
        'email_verification_sent_at',
        'role',
        'status',
        'last_login'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'google_id' => 'required|is_unique[oauth_users.google_id,id,{id}]',
        'email'     => 'required|valid_email|is_unique[oauth_users.email,id,{id}]',
        'name'      => 'required|min_length[2]|max_length[255]',
        'role'      => 'in_list[admin,user]',
        'status'    => 'in_list[active,inactive,banned]',
    ];

    protected $validationMessages = [
        'google_id' => [
            'required'  => 'Google ID is required',
            'is_unique' => 'This Google account is already registered'
        ],
        'email' => [
            'required'    => 'Email is required',
            'valid_email' => 'Please provide a valid email',
            'is_unique'   => 'This email is already registered'
        ],
        'name' => [
            'required'   => 'Name is required',
            'min_length' => 'Name must be at least 2 characters',
            'max_length' => 'Name cannot exceed 255 characters'
        ]
    ];

    /**
     * Find user by Google ID
     */
    public function findByGoogleId($googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    /**
     * Find user by email (for email/password login)
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Create user with email/password
     */
    public function createEmailUser($data)
    {
        // Determine role based on email
        $adminEmails = ['dik23sep@gmail.com']; // Same as GoogleAuth controller
        $role = in_array($data['email'], $adminEmails) ? 'admin' : 'user';

        // Generate verification token
        $verificationToken = bin2hex(random_bytes(32));

        $userData = [
            'google_id'                    => 'email_' . uniqid(), // Generate unique ID for email users
            'email'                        => $data['email'],
            'password'                     => password_hash($data['password'], PASSWORD_DEFAULT),
            'login_type'                   => 'email',
            'name'                         => $data['name'],
            'avatar'                       => null,
            'email_verified'               => true, // Auto-verify for simplicity
            'email_verification_token'     => $verificationToken,
            'email_verification_sent_at'   => date('Y-m-d H:i:s'),
            'role'                         => $role,
            'status'                       => 'active',
            'created_at'                   => date('Y-m-d H:i:s'),
            'updated_at'                   => date('Y-m-d H:i:s')
        ];

        $userId = $this->insert($userData);
        return $this->find($userId);
    }

    /**
     * Verify email/password login
     */
    public function verifyEmailLogin($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        // Check if user has password (email login enabled)
        if (empty($user['password'])) {
            return false;
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }

        return false;
    }

    /**
     * Verify email with token
     */
    public function verifyEmailToken($token)
    {
        $user = $this->where('email_verification_token', $token)->first();

        if (!$user) {
            return false;
        }

        // Check if token is not expired (24 hours)
        $sentAt = strtotime($user['email_verification_sent_at']);
        $now = time();
        $hoursDiff = ($now - $sentAt) / 3600;

        if ($hoursDiff > 24) {
            return false; // Token expired
        }

        // Verify email
        $this->update($user['id'], [
            'email_verified' => true,
            'email_verification_token' => null,
            'email_verification_sent_at' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $user;
    }

    /**
     * Resend verification email
     */
    public function resendVerificationToken($email)
    {
        $user = $this->findByEmail($email);

        if (!$user || $user['email_verified']) {
            return false;
        }

        $newToken = bin2hex(random_bytes(32));

        $this->update($user['id'], [
            'email_verification_token' => $newToken,
            'email_verification_sent_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $newToken;
    }

    /**
     * Create or update user from Google OAuth data
     */
    public function createOrUpdateFromGoogle($googleUser)
    {
        $existingUser = $this->findByGoogleId($googleUser['id']);
        
        $userData = [
            'google_id'      => $googleUser['id'],
            'email'          => $googleUser['email'],
            'name'           => $googleUser['name'],
            'avatar'         => $googleUser['picture'] ?? null,
            'email_verified' => $googleUser['email_verified'] ?? true,
            'last_login'     => date('Y-m-d H:i:s'),
        ];

        // Add role if provided (from GoogleAuth controller)
        if (isset($googleUser['role'])) {
            $userData['role'] = $googleUser['role'];
        }

        if ($existingUser) {
            // Update existing user, but preserve admin role if already set
            if ($existingUser['role'] === 'admin') {
                $userData['role'] = 'admin'; // Keep admin role
            }
            $this->update($existingUser['id'], $userData);
            return $this->find($existingUser['id']);
        } else {
            // Create new user
            if (!isset($userData['role'])) {
                $userData['role'] = 'user'; // Default role if not set
            }
            $userData['status'] = 'active'; // Default status

            $userId = $this->insert($userData);
            return $this->find($userId);
        }
    }

    /**
     * Update last login time
     */
    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * Get active users only
     */
    public function getActiveUsers()
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Get admin users
     */
    public function getAdminUsers()
    {
        return $this->where('role', 'admin')
                    ->where('status', 'active')
                    ->findAll();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        return $user && $user['role'] === 'admin' && $user['status'] === 'active';
    }

    /**
     * Ban user
     */
    public function banUser($userId)
    {
        return $this->update($userId, ['status' => 'banned']);
    }

    /**
     * Activate user
     */
    public function activateUser($userId)
    {
        return $this->update($userId, ['status' => 'active']);
    }

    /**
     * Promote user to admin
     */
    public function promoteToAdmin($userId)
    {
        return $this->update($userId, ['role' => 'admin']);
    }

    /**
     * Demote admin to user
     */
    public function demoteToUser($userId)
    {
        return $this->update($userId, ['role' => 'user']);
    }
}
