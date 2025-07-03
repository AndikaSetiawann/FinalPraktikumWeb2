<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Article CMS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f8fafc;
            --accent-color: #06b6d4;
            --text-dark: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group-modern {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }

        .form-control-modern {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control-modern.with-icon {
            padding-left: 3rem;
        }

        .form-control-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .btn-register-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-register-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .back-link-modern {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link-modern a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link-modern a:hover {
            color: var(--accent-color);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .validation-errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .validation-errors ul {
            margin: 0;
            padding-left: 1.5rem;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Register Header -->
        <div class="register-header">
            <h2 class="mb-1">
                <i class="fas fa-user-plus me-2"></i>
                Create Account
            </h2>
            <p class="mb-0 opacity-75">Join Article CMS today</p>
        </div>

        <!-- Register Form -->
        <div class="register-form">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-modern">
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

            <!-- Validation Errors -->
            <?php if (isset($validation)): ?>
                <div class="validation-errors">
                    <h6><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</h6>
                    <ul>
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/register') ?>" method="post">
                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-user me-2"></i>
                        Full Name
                    </label>
                    <div class="input-group-modern">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               name="name" 
                               class="form-control-modern with-icon" 
                               id="name"
                               value="<?= old('name') ?>" 
                               placeholder="Enter your full name" 
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope me-2"></i>
                        Email Address
                    </label>
                    <div class="input-group-modern">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               name="email" 
                               class="form-control-modern with-icon" 
                               id="email"
                               value="<?= old('email') ?>" 
                               placeholder="Enter your email address" 
                               required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock me-2"></i>
                        Password
                    </label>
                    <div class="input-group-modern">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               name="password" 
                               class="form-control-modern with-icon" 
                               id="password"
                               placeholder="Enter your password" 
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm_password">
                        <i class="fas fa-lock me-2"></i>
                        Confirm Password
                    </label>
                    <div class="input-group-modern">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               name="confirm_password" 
                               class="form-control-modern with-icon" 
                               id="confirm_password"
                               placeholder="Confirm your password" 
                               required>
                    </div>
                </div>
                
                <button type="submit" class="btn-register-modern">
                    <i class="fas fa-user-plus me-2"></i>
                    Create Account
                </button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <!-- Google Register Button -->
            <a href="<?= base_url('auth/google') ?>" class="btn btn-danger btn-lg w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 1rem; border-radius: 12px; font-weight: 600; transition: all 0.3s ease;">
                <i class="fab fa-google"></i>
                Sign up with Google
            </a>

            <div class="back-link-modern">
                <a href="<?= base_url('user/login') ?>">
                    <i class="fas fa-arrow-left me-2"></i>
                    Already have an account? Login
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
