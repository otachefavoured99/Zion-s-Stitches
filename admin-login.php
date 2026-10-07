<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === 'admin@zionstitches.com' && $password === 'admin123') {
        $_SESSION['user_id'] = 0;
        $_SESSION['user_email'] = 'admin@zionstitches.com';
        $_SESSION['user_name'] = 'System Admin';
        $_SESSION['is_admin'] = true;
        header('Location: admin.php');
        exit;
    }

    $error = 'Invalid admin email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login as Admin | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section-padding" style="background-color: #f6f5f2; min-height: 80vh;">
        <div class="auth-panel-card">
            <div class="auth-center-icon">&#128274;</div>
            <h3>Login as Admin</h3>

            <?php if ($error !== ''): ?>
                <div class="error-box" style="margin-bottom: 15px; padding: 10px 12px; background: #fdecec; color: #8b1e1e; border: 1px solid #e7b3b3; border-radius: 8px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="admin-login.php">
                <div class="form-group-block">
                    <label>Admin Email Address</label>
                    <input type="email" name="email" placeholder="Enter admin email" required>
                </div>
                <div class="form-group-block">
                    <label>Admin Password</label>
                    <input type="password" name="password" placeholder="Enter admin password" required>
                </div>
                <button type="submit" class="btn-submit-wide">Login as Admin</button>
            </form>

            <p class="login-link" style="margin-top:18px; text-align:center;">
                <a href="login.php">Back to customer booking</a>
            </p>
        </div>
    </section>
</body>
</html>
