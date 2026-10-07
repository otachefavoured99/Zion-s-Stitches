<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: book-consultation.php');
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

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$preferred_date = trim($_POST['preferred_date'] ?? '');
$preferred_time = trim($_POST['preferred_time'] ?? '');
$service_type = trim($_POST['service_type'] ?? '');
$notes = trim($_POST['notes'] ?? '');

if ($full_name === '' || $email === '' || $preferred_date === '' || $preferred_time === '' || $service_type === '') {
    echo "<script>alert('Please complete all required fields before submitting.'); window.history.back();</script>";
    exit;
}

$stmt = $conn->prepare("INSERT INTO appointments (full_name, email, phone, preferred_date, preferred_time, service_type, additional_notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");
if (!$stmt) {
    error_log('Appointment insert prepare failed: ' . $conn->error);
    header('Location: book-consultation.php?error=1');
    exit;
}

$stmt->bind_param('sssssss', $full_name, $email, $phone, $preferred_date, $preferred_time, $service_type, $notes);

if ($stmt->execute()) {
    header('Location: book-consultation.php?success=1');
    exit;
}

error_log('Appointment insert failed: ' . $stmt->error);
$stmt->close();
$conn->close();
header('Location: book-consultation.php?error=1');
exit;
?>