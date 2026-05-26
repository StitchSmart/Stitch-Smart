<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?= $webname ?? 'Stitch Smart' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/luxury_theme.css" rel="stylesheet">
    <style>
        body {
            background-color: var(--bg-dark, #000);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .forgot-card {
            background: #0a0a0a;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(193, 154, 78, 0.3);
            width: 100%;
            max-width: 450px;
        }
        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(193, 154, 78, 0.2);
            color: #fff;
            padding: 12px;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: #c19a4e;
            box-shadow: none;
        }
        .btn-luxury {
            background: linear-gradient(135deg, #c19a4e 0%, #a67c37 100%);
            color: #000;
            font-weight: bold;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
        }
        .btn-luxury:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="forgot-card">
    <h3 class="mb-3 text-center" style="color: #c19a4e; font-family: 'Playfair Display', serif; font-weight: 700;">Password Recovery</h3>

    <?php if(isset($_SESSION['forgot_error'])): ?>
        <div class="alert alert-danger p-2 text-center" style="font-size: 0.9rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 8px;"><?= $_SESSION['forgot_error']; unset($_SESSION['forgot_error']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['forgot_success'])): ?>
        <div class="alert alert-success p-2 text-center" style="font-size: 0.9rem; background: rgba(74, 222, 128, 0.1); border: 1px solid rgba(74, 222, 128, 0.2); color: #4ade80; border-radius: 8px;"><?= $_SESSION['forgot_success']; unset($_SESSION['forgot_success']); ?></div>
    <?php endif; ?>

    <?php 
    $step = $_SESSION['reset_step_customer'] ?? 'request'; 
    ?>

    <?php if ($step === 'request'): ?>
        <p class="text-center mb-4" style="font-size: 0.9rem; color: #ccc;">Enter your administrator/customer email address and we will send you a one-time OTP to recover your password.</p>
        <form method="POST" action="<?= BASE_URL ?>index.php?page=customer_forgot_password_process">
            <div class="mb-4">
                <input type="email" name="email" class="form-control" placeholder="Your Email Address" required autocomplete="off">
            </div>
            <button type="submit" class="btn-luxury mb-3">Send OTP Code</button>
            <div class="text-center">
                <a href="<?= BASE_URL ?>index.php?page=checkout" style="color: #c19a4e; text-decoration: none; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#c19a4e'">Back to Checkout</a>
            </div>
        </form>

    <?php elseif ($step === 'verify_otp'): ?>
        <p class="text-center mb-4" style="font-size: 0.9rem; color: #ccc;">A 6-digit OTP has been sent to <strong><?= htmlspecialchars($_SESSION['reset_email_customer'] ?? '') ?></strong>. Please enter it below.</p>

        <form method="POST" action="<?= BASE_URL ?>index.php?page=customer_forgot_password_process">
            <div class="mb-4">
                <input type="text" name="otp" class="form-control text-center" placeholder="••••••" required maxlength="6" style="font-size: 1.5rem; letter-spacing: 5px; font-weight: bold;">
            </div>
            <button type="submit" class="btn-luxury mb-3">Verify OTP Code</button>
            <div class="text-center">
                <a href="<?= BASE_URL ?>index.php?page=customer_forgot_password_process&action=cancel" style="color: #ccc; text-decoration: none; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#ccc'">Cancel & Start Over</a>
            </div>
        </form>

    <?php elseif ($step === 'reset_password'): ?>
        <p class="text-center mb-4" style="font-size: 0.9rem; color: #ccc;">Enter your new password below to complete the recovery process.</p>
        <form method="POST" action="<?= BASE_URL ?>index.php?page=customer_forgot_password_process">
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="New Password" required minlength="4">
            </div>
            <div class="mb-4">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required minlength="4">
            </div>
            <button type="submit" class="btn-luxury mb-3">Reset Password</button>
            <div class="text-center">
                <a href="<?= BASE_URL ?>index.php?page=customer_forgot_password_process&action=cancel" style="color: #ccc; text-decoration: none; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#ccc'">Cancel & Start Over</a>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
