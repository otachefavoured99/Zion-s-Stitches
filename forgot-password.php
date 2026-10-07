<?php
require_once 'config.php';

$message = '';
$resetLink = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));

    if ($email === '') {
        $message = 'Please enter your email address.';
    } else {
        $conn->query("CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX(email)
        )");

        $stmt = $conn->prepare("SELECT id, full_name FROM registrations WHERE email = ? LIMIT 1");
        if ($stmt === false) {
            $message = 'Unable to access the user database right now.';
        } else {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$user) {
                $message = 'No account was found for that email address.';
            } else {
                $token = bin2hex(random_bytes(32));
                $expiresAt = date('Y-m-d H:i:s', time() + 3600);

                $delStmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                if ($delStmt) {
                    $delStmt->bind_param('s', $email);
                    $delStmt->execute();
                    $delStmt->close();
                }

                $insertStmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
                if ($insertStmt === false) {
                    $message = 'Unable to generate a reset token.';
                } else {
                    $insertStmt->bind_param('sss', $email, $token, $expiresAt);
                    $insertStmt->execute();
                    $insertStmt->close();

                    $resetLink = 'http://localhost/fashion_booking/reset-password.php?token=' . urlencode($token);
                    $subject = 'Reset your Zion Stitches password';
                    $body = "Hello " . $user['full_name'] . ",\n\n" .
                            "You requested a password reset. Click the link below to create a new password:\n\n" .
                            $resetLink . "\n\n" .
                            "This link will expire in 1 hour.\n\n" .
                            "If you did not request this, please ignore this message.";
                    $headers = "From: no-reply@zionstitches.local\r\n" .
                               "Reply-To: no-reply@zionstitches.local\r\n" .
                               "Content-Type: text/plain; charset=UTF-8\r\n";

                    $mailSent = @mail($email, $subject, $body, $headers);

                    if ($mailSent) {
                        $message = 'Password recovery instructions have been sent to ' . htmlspecialchars($email) . '.';
                    } else {
                        $message = 'Password recovery instructions have been sent to ' . htmlspecialchars($email) . '.';
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section-padding" style="background-color: #f6f5f2; min-height: 80vh;">
        <div class="auth-panel-card">
            <div class="auth-center-icon">&#128273;</div>
            <h3>Forgot Password</h3>

            <?php if ($resetLink !== ''): ?>
                <div class="notice-box" style="margin-bottom: 15px; padding: 10px 12px; background: #fff7e6; color: #7a5200; border: 1px solid #e7c98b; border-radius: 8px;">
                    <a href="<?php echo htmlspecialchars($resetLink); ?>"><?php echo htmlspecialchars($resetLink); ?></a>
                </div>
            <?php endif; ?>

            <form method="POST" action="forgot-password.php">
                <div class="form-group-block">
                    <label>Registered Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn-submit-wide">Send Recovery Instructions</button>
            </form>

            <p class="login-link">Remembered your password? <a href="login.php">Back to login</a></p>
        </div>
    </section>
</body>
</html>
