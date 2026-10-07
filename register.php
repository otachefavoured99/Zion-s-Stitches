<?php
require_once 'config.php';

$redirect = $_GET['redirect'] ?? 'dashboard.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $redirect = trim($_POST['redirect'] ?? $redirect);

    if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $error = 'Please complete all required fields.';
    } elseif (strtolower($email) === 'admin@zionstitches.com') {
        $error = 'This email is reserved for administrator use only.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $conn->query("CREATE TABLE IF NOT EXISTS registrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) DEFAULT NULL,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $checkStmt = $conn->prepare("SELECT id FROM registrations WHERE email = ? LIMIT 1");
        if ($checkStmt === false) {
            $error = 'Unable to validate your account details.';
        } else {
            $checkStmt->bind_param('s', $email);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $error = 'An account with this email already exists. Please log in instead.';
            } else {
                $stmt = $conn->prepare("INSERT INTO registrations (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param('ssss', $name, $email, $phone, $passwordHash);

                if ($stmt->execute()) {
                    $userId = (int) $conn->insert_id;
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_phone'] = $phone;
                    $_SESSION['is_admin'] = false;
                    header('Location: ' . $redirect);
                    exit;
                }

                $error = 'Unable to save your registration right now. Please try again.';
            }

            $checkStmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section-padding" style="background-color: #f6f5f2; min-height: 80vh;">
        <div class="auth-panel-card">
            <div class="auth-center-icon">&#128132;</div>
            <h3>Create Account</h3>

            <?php if ($error !== ''): ?>
                <div class="error-box" style="margin-bottom: 15px; padding: 10px 12px; background: #fdecec; color: #8b1e1e; border: 1px solid #e7b3b3; border-radius: 8px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                <div class="form-group-block">
                    <label>Full Structural Name</label>
                    <input type="text" name="name" placeholder="Enter full name" required>
                </div>
                <div class="form-row-twin">
                    <div class="form-group-block">
                        <label>Primary Email Address</label>
                        <input type="email" name="email" placeholder="Enter account email" required>
                    </div>
                    <div class="form-group-block">
                        <label>Mobile Line Connection</label>
                        <input type="tel" name="phone" placeholder="Enter phone contact">
                    </div>
                </div>
                <div class="form-row-twin">
                    <div class="form-group-block">
                        <label>Construct Password</label>
                        <input type="password" name="password" placeholder="Minimum 8 characters" required>
                    </div>
                    <div class="form-group-block">
                        <label>Confirm Password Alignment</label>
                        <input type="password" name="confirm_password" placeholder="Repeat password input" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit-wide" style="background-color: var(--primary-gold); color: var(--black);">Register</button>
            </form>

            <p style="text-align:center; font-size:11px; margin-top:20px; color:#888;">By joining, you agree to our styling terms.</p>
            <p class="login-link">Already have an account? <a href="login.php?redirect=<?php echo urlencode($redirect); ?>">Login here</a></p>
        </div>
    </section>
</body>
</html>
