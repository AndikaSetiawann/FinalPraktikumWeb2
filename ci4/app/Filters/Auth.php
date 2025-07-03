<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Debug session
        log_message('debug', 'Auth Filter - Session data: ' . json_encode(session()->get()));

        // Jika user belum login
        if (!session()->get('logged_in')) {
            // Redirect ke halaman login
            return redirect()->to('/user/login');
        }

        // Check if admin access required
        $uri = $request->getUri()->getPath();
        if (strpos($uri, 'admin') !== false) {
            if (session()->get('role') !== 'admin') {
                return redirect()->to('/user/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah request untuk saat ini
    }
}
