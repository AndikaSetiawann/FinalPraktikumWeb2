<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Article CMS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Modern Login Styles */
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            z-index: 2;
            animation: slideUp 0.6s ease;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .login-brand {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            opacity: 0.9;
            margin: 0;
        }

        .login-form {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-modern {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .form-control-modern:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .input-group-modern {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 2;
        }

        .form-control-modern.with-icon {
            padding-left: 3rem;
        }

        .btn-login-modern {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .alert-modern {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-danger-modern {
            background: linear-gradient(135deg, #fed7d7, #feb2b2);
            color: #742a2a;
        }

        .back-link-modern {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .back-link-modern a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link-modern a:hover {
            color: #764ba2;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
            }
            
            .login-form {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container">
                    <!-- Login Header -->
                    <div class="login-header">
                        <div class="login-brand">
                            <i class="fas fa-newspaper me-2"></i>
                            Article CMS
                        </div>
                        <p class="login-subtitle">Silakan masuk untuk mengakses panel admin</p>
                    </div>

                    <!-- Login Form -->
                    <div class="login-form">

                        <?php if (session()->getFlashdata('flash_msg')): ?>
                            <div class="alert-modern alert-danger-modern">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= session()->getFlashdata('flash_msg') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-warning alert-modern">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-modern">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>



                        <form action="<?= base_url('user/login') ?>" method="post">
                            <div class="form-group">
                                <label class="form-label" for="InputForEmail">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email Address
                                </label>
                                <div class="input-group-modern">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email"
                                           name="email"
                                           class="form-control-modern with-icon"
                                           id="InputForEmail"
                                           value="<?= old('email') ?>"
                                           placeholder="Enter your email"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="InputForPassword">
                                    <i class="fas fa-lock me-2"></i>
                                    Password
                                </label>
                                <div class="input-group-modern">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password"
                                           name="password"
                                           class="form-control-modern with-icon"
                                           id="InputForPassword"
                                           placeholder="Enter your password"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn-login-modern">
                                <i class="fas fa-sign-in-alt"></i>
                                Login with Email
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="text-center my-4">
                            <div class="d-flex align-items-center">
                                <hr class="flex-grow-1">
                                <span class="px-3 text-muted">or</span>
                                <hr class="flex-grow-1">
                            </div>
                        </div>

                        <!-- Google Login Button -->
                        <a href="<?= base_url('auth/google') ?>" class="btn btn-danger btn-lg w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 1rem; border-radius: 12px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fab fa-google"></i>
                            Login dengan Google
                        </a>

                        <div class="back-link-modern">
                            <a href="<?= base_url('user/register') ?>" class="me-3">
                                <i class="fas fa-user-plus me-2"></i>
                                Create Account
                            </a>
                            <a href="<?= base_url('/') ?>">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
