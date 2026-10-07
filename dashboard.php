<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || (int) $_SESSION['user_id'] <= 0 || !empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit;
}

$conn->query("CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    preferred_date DATE DEFAULT NULL,
    preferred_time TIME DEFAULT NULL,
    service_type VARCHAR(255) DEFAULT NULL,
    additional_notes TEXT DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$email = $_SESSION['user_email'];
$appointments = [];
$stmt = $conn->prepare('SELECT preferred_date, preferred_time, service_type, status, created_at FROM appointments WHERE email = ? ORDER BY created_at DESC');
if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($appointment = $result->fetch_assoc()) {
        $appointments[] = $appointment;
    }
    $stmt->close();
}

$pendingCount = count(array_filter($appointments, static fn($appointment) => strtolower($appointment['status'] ?? '') === 'pending'));
$confirmedCount = count(array_filter($appointments, static fn($appointment) => strtolower($appointment['status'] ?? '') === 'confirmed'));
$escape = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | Zion Stitches</title>
    <link rel="stylesheet" href="style.css?v=customer-dashboard-layout-20261005">
    <script src="nav.js" defer></script>
</head>
<body>
    <header class="customer-dashboard-header">
        <a href="index.php" class="logo-container" aria-label="Zion Stitches home">
            <span class="logo-text">ZION</span>
            <span class="logo-subtext">STITCHES</span>
        </a>
        <a href="logout.php" class="btn-nav-book">Logout</a>
    </header>

    <main class="customer-dashboard">
        <section class="customer-dashboard-heading">
            <div>
                <p class="customer-dashboard-eyebrow">Customer account</p>
                <h1>Welcome, <?php echo $escape($_SESSION['user_name'] ?? 'Customer'); ?></h1>
                <p><?php echo $escape($email); ?></p>
            </div>
            <a href="book-consultation.php" class="btn-submit-wide customer-dashboard-book">Book a consultation</a>
        </section>

        <section class="customer-dashboard-overview" aria-labelledby="overview-title">
            <div class="customer-dashboard-section-heading">
                <div>
                    <h2 id="overview-title">Booking overview</h2>
                    <p>Your appointment requests at a glance</p>
                </div>
            </div>
            <div class="customer-dashboard-stats" aria-label="Appointment summary">
                <div><span>Total requests</span><strong><?php echo count($appointments); ?></strong></div>
                <div><span>Pending</span><strong><?php echo $pendingCount; ?></strong></div>
                <div><span>Confirmed</span><strong><?php echo $confirmedCount; ?></strong></div>
            </div>
        </section>

        <section class="customer-appointments">
            <div class="customer-appointments-heading">
                <div>
                    <h2>My appointments</h2>
                    <p>Updates from the Zion Stitches team</p>
                </div>
                <span><?php echo count($appointments); ?> total</span>
            </div>
            <?php if ($appointments): ?>
                <div class="customer-appointment-list">
                    <?php foreach ($appointments as $appointment): ?>
                        <?php $status = $appointment['status'] ?: 'Pending'; ?>
                        <article class="customer-appointment-row">
                            <div class="customer-appointment-date">
                                <span>Date</span>
                                <strong><?php echo $escape($appointment['preferred_date'] ? date('M j, Y', strtotime($appointment['preferred_date'])) : 'To be set'); ?></strong>
                                <span><?php echo $escape($appointment['preferred_time'] ? date('g:i A', strtotime($appointment['preferred_time'])) : 'Time to be set'); ?></span>
                            </div>
                            <div class="customer-appointment-details">
                                <h3><?php echo $escape($appointment['service_type'] ?: 'Consultation'); ?></h3>
                                <p>Consultation request</p>
                            </div>
                            <span class="customer-appointment-status <?php echo strtolower($status) === 'confirmed' ? 'is-confirmed' : 'is-pending'; ?>">
                                <?php echo $escape($status); ?>
                            </span>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="customer-dashboard-empty">
                    <h3>No appointments yet</h3>
                    <p>Your consultation requests and their status will appear here.</p>
                    <a href="book-consultation.php">Book your first consultation</a>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>