<?php
require_once 'config.php';

$redirect = $_GET['redirect'] ?? 'dashboard.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $redirect = trim($_POST['redirect'] ?? $redirect);

    if ($email === '' || $password === '') {
        $error = 'Please enter both your email and password.';
    } else {
        if (strtolower($email) === 'admin@zionstitches.com' && $password === 'admin123') {
            $_SESSION['user_id'] = 0;
            $_SESSION['user_email'] = 'admin@zionstitches.com';
            $_SESSION['user_name'] = 'System Admin';
            $_SESSION['is_admin'] = true;
            header('Location: admin.php');
            exit;
        }

        $stmt = $conn->prepare("SELECT id, full_name, email, password_hash FROM registrations WHERE email = ? LIMIT 1");
        if ($stmt === false) {
            $error = 'Unable to connect to the user database.';
        } else {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['is_admin'] = false;

                if ($redirect === 'admin.php') {
                    $redirect = 'dashboard.php';
                }

                header('Location: ' . $redirect);
                exit;
            }

            $error = 'Invalid email or password.';
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login as Customer | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section-padding" style="background-color: #f6f5f2; min-height: 80vh;">
        <div class="auth-panel-card">
            <div class="auth-center-icon">&#128274;</div>
            <h3>Login as Customer</h3>

            <?php if ($error !== ''): ?>
                <div class="error-box" style="margin-bottom: 15px; padding: 10px 12px; background: #fdecec; color: #8b1e1e; border: 1px solid #e7b3b3; border-radius: 8px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                <div class="form-group-block">
                    <label>Registered Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group-block">
                    <label>Secure Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="remember-forgot-flex">
                    <label><input type="checkbox"> Remember my session</label>
                    <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-submit-wide">Login as Customer</button>
            </form>

            <div style="margin-top:18px; text-align:center; display:flex; flex-direction:column; gap:8px;">
                <p class="login-link">Are you a new customer? <a href="register.php?redirect=<?php echo urlencode($redirect); ?>">Register here</a></p>
                <p class="login-link"><a href="admin-login.php">Login as admin</a></p>
            </div>

        </div>
    </section>
</body>
</html>
