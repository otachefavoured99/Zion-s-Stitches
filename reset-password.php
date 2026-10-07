<?php
require_once 'config.php';

$message = '';
$validToken = false;
$emailForReset = '';
$token = $_GET['token'] ?? '';

if ($token !== '') {
    $conn->query("CREATE TABLE IF NOT EXISTS password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX(email),
        INDEX(token)
    )");

    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $validToken = true;
            $emailForReset = $row['email'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password === '' || $confirm === '') {
        $message = 'Please enter both password fields.';
    } elseif ($password !== $confirm) {
        $message = 'Passwords do not match.';
    } else {
        $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1");
        if ($stmt === false) {
            $message = 'This reset link is invalid or expired.';
        } else {
            $stmt->bind_param('s', $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if (!$row) {
                $message = 'This reset link is invalid or expired.';
            } else {
                $emailToUpdate = $row['email'];
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE registrations SET password_hash = ? WHERE email = ?");
                if ($updateStmt === false) {
                    $message = 'Unable to save the new password.';
                } else {
                    $updateStmt->bind_param('ss', $newHash, $emailToUpdate);
                    if ($updateStmt->execute()) {
                        $deleteStmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                        if ($deleteStmt) {
                            $deleteStmt->bind_param('s', $emailToUpdate);
                            $deleteStmt->execute();
                            $deleteStmt->close();
                        }
                        $message = 'Password reset successful. Please use the login page to continue.';
                        $validToken = false;
                    } else {
                        $message = 'There was a problem saving the new password.';
                    }
                    $updateStmt->close();
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
    <title>Reset Password | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section-padding" style="background-color: #f6f5f2; min-height: 80vh;">
        <div class="auth-panel-card">
            <div class="auth-center-icon">&#128273;</div>
            <h3>Reset Password</h3>

            <?php if ($message !== ''): ?>
                <div class="notice-box" style="margin-bottom: 15px; padding: 10px 12px; background: #eef7ff; color: #163d5f; border: 1px solid #bfd7ee; border-radius: 8px;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($validToken || ($token !== '' && $message === '')): ?>
                <form method="POST" action="reset-password.php">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="form-group-block">
                        <label>New Password</label>
                        <input type="password" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group-block">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn-submit-wide">Reset Password</button>
                </form>
            <?php endif; ?>

            <p class="login-link">Return to <a href="login.php">Login</a></p>
        </div>
    </section>

    <footer>
        <div class="footer-top-grid">
            <div class="footer-brand-column">
                <div class="logo-container">
                    <span class="logo-text" style="font-size:22px;">ZION</span>
                    <span class="logo-subtext" style="font-size:8px; letter-spacing:4px;">STITCHES</span>
                </div>
                <p>We make custom clothes for every style and occasion.</p>
            </div>
            <div>
                <h4 class="footer-column-heading">Quick Links</h4>
                <ul class="footer-links-list">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="portfolio.php">Collections</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="login.php?redirect=book-consultation.php">Book Consultation</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-column-heading">Our Collections</h4>
                <ul class="footer-links-list">
                    <li><a href="portfolio.php">Bridal Wear</a></li>
                    <li><a href="portfolio.php">Men's Fashion</a></li>
                    <li><a href="portfolio.php">Traditional Wear</a></li>
                    <li><a href="portfolio.php">Other</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-column-heading">Contact Us</h4>
                <ul class="contact-detail-bullets footer-links-list">
                    <li><span>&#128222;</span><span>+234 806 123 4567</span></li>
                    <li><span>&#128231;</span><span>zionstitches@gmail.com</span></li>
                    <li><span>&#128205;</span><span>Dutse Alhaji 1, Abuja, Nigeria</span></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
