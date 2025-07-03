<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OAuthUserModel;
use App\Services\EmailService;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();

        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Jika tidak ada input email, tampilkan form login
        if (!$email || !$password) {
            return view('user/login_modern');
        }

        $session = session();
        $oauthModel = new OAuthUserModel();

        // Try OAuth users table first (unified authentication)
        $user = $oauthModel->verifyEmailLogin($email, $password);

        if ($user) {
            // Email verification disabled for simplicity

            // Set session data (same format as Google OAuth)
            $sessionData = [
                'user_id'    => $user['id'],
                'google_id'  => $user['google_id'],
                'email'      => $user['email'],
                'name'       => $user['name'],
                'avatar'     => $user['avatar'],
                'role'       => $user['role'],
                'logged_in'  => true,
                'login_type' => 'email'
            ];

            $session->set($sessionData);
            $session->setFlashdata('success', 'Successfully logged in!');

            // Redirect based on role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/artikel');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            // Fallback to old UserModel for backward compatibility
            $userModel = new UserModel();
            $oldUser = $userModel->where('useremail', $email)->first();

            if ($oldUser && password_verify($password, $oldUser['userpassword'])) {
                // Old user login - migrate to new system
                $session->set([
                    'user_id'    => $oldUser['id'],
                    'user_name'  => $oldUser['username'],
                    'user_email' => $oldUser['useremail'],
                    'logged_in'  => true,
                    'login_type' => 'traditional',
                    'role'       => 'admin' // Old users are admin
                ]);

                return redirect()->to('/admin/artikel');
            } else {
                $session->setFlashdata('error', 'Email atau password salah.');
                return redirect()->to('/user/login');
            }
        }
    }

    public function register()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'POST') {
            // Validation rules
            $rules = [
                'name'     => 'required|min_length[3]|max_length[50]',
                'email'    => 'required|valid_email|is_unique[oauth_users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return view('user/register', [
                    'validation' => $this->validator
                ]);
            }

            // Create new user
            $oauthModel = new OAuthUserModel();
            $userData = [
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password')
            ];

            try {
                $user = $oauthModel->createEmailUser($userData);

                if ($user) {
                    // Email verification disabled for simplicity
                    session()->setFlashdata('success', 'Registration successful! You can now login.');
                    return redirect()->to('/user/login');
                } else {
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                    return view('user/register');
                }
            } catch (\Exception $e) {
                log_message('error', 'Registration error: ' . $e->getMessage());
                session()->setFlashdata('error', 'Registration failed: ' . $e->getMessage());
                return view('user/register');
            }
        }

        return view('user/register');
    }

    public function verifyEmail($token = null)
    {
        if (!$token) {
            session()->setFlashdata('error', 'Invalid verification token.');
            return redirect()->to('/user/login');
        }

        $oauthModel = new OAuthUserModel();
        $user = $oauthModel->verifyEmailToken($token);

        if ($user) {
            session()->setFlashdata('success', 'Email verified successfully! You can now login.');
        } else {
            session()->setFlashdata('error', 'Invalid or expired verification token.');
        }

        return redirect()->to('/user/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
