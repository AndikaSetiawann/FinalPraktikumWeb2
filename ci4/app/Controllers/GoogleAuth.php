<?php

namespace App\Controllers;

use App\Models\OAuthUserModel;
use CodeIgniter\Controller;

class GoogleAuth extends Controller
{
    protected $googleClientId;
    protected $googleClientSecret;
    protected $googleRedirectUri;

    // 👑 Admin emails (full access)
    protected $adminEmails = [
        'dik23sep@gmail.com'  // Email bang sebagai admin
    ];

    // 🔓 Allow all Google emails to login (role-based access)
    protected $allowAllGoogleEmails = true;

    public function __construct()
    {
        // Load Google OAuth credentials from environment
        $this->googleClientId = env('GOOGLE_CLIENT_ID');
        $this->googleClientSecret = env('GOOGLE_CLIENT_SECRET');
        $this->googleRedirectUri = base_url('auth/google/callback');
    }

    /**
     * Redirect to Google OAuth
     */
    public function login()
    {
        // Check if Google OAuth is configured
        if (empty($this->googleClientId) || empty($this->googleClientSecret)) {
            session()->setFlashdata('error',
                'Google OAuth belum dikonfigurasi. Silakan setup Google Cloud Console terlebih dahulu.<br>' .
                '<small>Panduan: <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></small>'
            );
            return redirect()->to('/user/login');
        }

        $params = [
            'client_id'     => $this->googleClientId,
            'redirect_uri'  => $this->googleRedirectUri,
            'scope'         => 'openid email profile',
            'response_type' => 'code',
            'access_type'   => 'offline',
            'prompt'        => 'consent'
        ];

        $googleAuthUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);

        return redirect()->to($googleAuthUrl);
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        $code = $this->request->getGet('code');
        $error = $this->request->getGet('error');

        if ($error) {
            session()->setFlashdata('error', 'Google authentication was cancelled or failed.');
            return redirect()->to('/user/login');
        }

        if (!$code) {
            session()->setFlashdata('error', 'No authorization code received from Google.');
            return redirect()->to('/user/login');
        }

        try {
            // Exchange code for access token
            $tokenData = $this->getAccessToken($code);
            
            if (!$tokenData || !isset($tokenData['access_token'])) {
                throw new \Exception('Failed to get access token from Google');
            }

            // Get user info from Google
            $googleUser = $this->getGoogleUserInfo($tokenData['access_token']);

            if (!$googleUser) {
                throw new \Exception('Failed to get user information from Google');
            }

            // 🎯 Determine user role based on email
            $userRole = in_array($googleUser['email'], $this->adminEmails) ? 'admin' : 'user';

            // Add role to Google user data for database storage
            $googleUser['role'] = $userRole;

            // Create or update user in database
            $userModel = new OAuthUserModel();
            $user = $userModel->createOrUpdateFromGoogle($googleUser);

            if (!$user) {
                throw new \Exception('Failed to create or update user in database');
            }

            // Set session data
            $sessionData = [
                'user_id'    => $user['id'],
                'google_id'  => $user['google_id'],
                'email'      => $user['email'],
                'name'       => $user['name'],
                'avatar'     => $user['avatar'],
                'role'       => $user['role'],
                'logged_in'  => true,
                'login_type' => 'google'
            ];

            session()->set($sessionData);

            // Set success message based on role
            if ($user['role'] === 'admin') {
                session()->setFlashdata('success', 'Welcome back, Admin! Successfully logged in with Google.');
                return redirect()->to('/admin/artikel');
            } else {
                session()->setFlashdata('success', 'Welcome! You have successfully logged in. You can view articles and content.');
                return redirect()->to('/user/dashboard');
            }

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth Error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Authentication failed: ' . $e->getMessage());
            return redirect()->to('/user/login');
        }
    }

    /**
     * Exchange authorization code for access token
     */
    private function getAccessToken($code)
    {
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        
        $postData = [
            'client_id'     => $this->googleClientId,
            'client_secret' => $this->googleClientSecret,
            'redirect_uri'  => $this->googleRedirectUri,
            'grant_type'    => 'authorization_code',
            'code'          => $code
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            log_message('error', 'Google token request failed with HTTP code: ' . $httpCode);
            return null;
        }

        return json_decode($response, true);
    }

    /**
     * Get user information from Google
     */
    private function getGoogleUserInfo($accessToken)
    {
        $userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $accessToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            log_message('error', 'Google user info request failed with HTTP code: ' . $httpCode);
            return null;
        }

        return json_decode($response, true);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/');
    }
}
