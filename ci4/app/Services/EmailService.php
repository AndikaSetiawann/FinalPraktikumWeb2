<?php

namespace App\Services;

use CodeIgniter\Email\Email;

class EmailService
{
    protected $email;

    public function __construct()
    {
        $this->email = \Config\Services::email();
        
        // Email configuration
        $config = [
            'protocol'    => 'smtp',
            'SMTPHost'    => 'smtp.gmail.com',
            'SMTPUser'    => 'your-email@gmail.com', // Ganti dengan email bang
            'SMTPPass'    => 'your-app-password',    // Ganti dengan app password
            'SMTPPort'    => 587,
            'SMTPCrypto'  => 'tls',
            'mailType'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n"
        ];
        
        $this->email->initialize($config);
    }

    /**
     * Send email verification
     */
    public function sendEmailVerification($userEmail, $userName, $verificationToken)
    {
        $verificationUrl = base_url("user/verify-email/{$verificationToken}");
        
        $subject = 'Verify Your Email Address - Article CMS';
        
        $message = $this->getEmailVerificationTemplate($userName, $verificationUrl);
        
        $this->email->setFrom('noreply@articlecms.com', 'Article CMS');
        $this->email->setTo($userEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        if ($this->email->send()) {
            return true;
        } else {
            log_message('error', 'Email verification failed: ' . $this->email->printDebugger());
            return false;
        }
    }

    /**
     * Send password reset email
     */
    public function sendPasswordReset($userEmail, $userName, $resetToken)
    {
        $resetUrl = base_url("user/reset-password/{$resetToken}");
        
        $subject = 'Reset Your Password - Article CMS';
        
        $message = $this->getPasswordResetTemplate($userName, $resetUrl);
        
        $this->email->setFrom('noreply@articlecms.com', 'Article CMS');
        $this->email->setTo($userEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        if ($this->email->send()) {
            return true;
        } else {
            log_message('error', 'Password reset email failed: ' . $this->email->printDebugger());
            return false;
        }
    }

    /**
     * Email verification template
     */
    private function getEmailVerificationTemplate($userName, $verificationUrl)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #4f46e5, #06b6d4); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .btn { display: inline-block; background: #4f46e5; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
                .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎉 Welcome to Article CMS!</h1>
                    <p>Please verify your email address</p>
                </div>
                <div class='content'>
                    <h2>Hello {$userName}!</h2>
                    <p>Thank you for registering with Article CMS. To complete your registration and activate your account, please verify your email address by clicking the button below:</p>
                    
                    <div style='text-align: center;'>
                        <a href='{$verificationUrl}' class='btn'>✅ Verify Email Address</a>
                    </div>
                    
                    <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
                    <p style='word-break: break-all; background: #e9ecef; padding: 10px; border-radius: 5px;'>{$verificationUrl}</p>
                    
                    <p><strong>Important:</strong> This verification link will expire in 24 hours for security reasons.</p>
                    
                    <p>If you didn't create an account with us, please ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>© 2025 Article CMS. All rights reserved.</p>
                    <p>This is an automated email, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    /**
     * Password reset template
     */
    private function getPasswordResetTemplate($userName, $resetUrl)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #dc2626, #f59e0b); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .btn { display: inline-block; background: #dc2626; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
                .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔐 Password Reset Request</h1>
                    <p>Reset your Article CMS password</p>
                </div>
                <div class='content'>
                    <h2>Hello {$userName}!</h2>
                    <p>We received a request to reset your password for your Article CMS account. If you made this request, click the button below to reset your password:</p>
                    
                    <div style='text-align: center;'>
                        <a href='{$resetUrl}' class='btn'>🔑 Reset Password</a>
                    </div>
                    
                    <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
                    <p style='word-break: break-all; background: #e9ecef; padding: 10px; border-radius: 5px;'>{$resetUrl}</p>
                    
                    <p><strong>Important:</strong> This reset link will expire in 1 hour for security reasons.</p>
                    
                    <p>If you didn't request a password reset, please ignore this email. Your password will remain unchanged.</p>
                </div>
                <div class='footer'>
                    <p>© 2025 Article CMS. All rights reserved.</p>
                    <p>This is an automated email, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
