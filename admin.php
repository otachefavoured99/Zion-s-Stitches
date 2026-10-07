<?php
require_once 'config.php';
require_once 'portfolio_helpers.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email']) || empty($_SESSION['user_email']) || !($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php?redirect=admin.php');
    exit;
}

$status_message = '';
$status_is_error = false;
$portfolioCategories = portfolio_categories();
$csrfToken = $_SESSION['portfolio_csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['portfolio_csrf_token'] = $csrfToken;
ensure_portfolio_table($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $hasValidCsrfToken = isset($_POST['csrf_token'])
        && is_string($_POST['csrf_token'])
        && hash_equals($csrfToken, $_POST['csrf_token']);

    if ($action === 'add_portfolio' || $action === 'delete_portfolio') {
        if (!$hasValidCsrfToken) {
            $status_message = 'Your session validation failed. Please try again.';
            $status_is_error = true;
        } elseif ($action === 'add_portfolio') {
            $titleInput = $_POST['title'] ?? '';
            $title = is_string($titleInput) ? trim($titleInput) : '';
            $category = $_POST['category'] ?? '';
            if (!is_string($category)) {
                $category = '';
            }
            $upload = $_FILES['portfolio_image'] ?? null;

            if ($title === '' || strlen($title) > 120 || !isset($portfolioCategories[$category])) {
                $status_message = 'Enter a title of 1-120 characters and choose a valid category.';
                $status_is_error = true;
            } elseif ($upload === null || !isset($upload['error']) || $upload['error'] !== UPLOAD_ERR_OK) {
                $uploadError = $upload['error'] ?? UPLOAD_ERR_NO_FILE;
                $status_message = ($uploadError === UPLOAD_ERR_INI_SIZE || $uploadError === UPLOAD_ERR_FORM_SIZE)
                    ? 'Image files must be 5 MB or smaller.'
                    : 'Choose a valid image file to upload.';
                $status_is_error = true;
            } elseif ($upload['size'] > 5 * 1024 * 1024) {
                $status_message = 'Image files must be 5 MB or smaller.';
                $status_is_error = true;
            } elseif (!is_uploaded_file($upload['tmp_name'])) {
                $status_message = 'The uploaded image could not be verified.';
                $status_is_error = true;
            } else {
                $imageInfo = getimagesize($upload['tmp_name']);
                $allowedMimes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];
                $mime = $imageInfo !== false ? ($imageInfo['mime'] ?? '') : '';

                if ($imageInfo === false || !isset($allowedMimes[$mime])) {
                    $status_message = 'Use a valid JPEG, PNG, or WebP image.';
                    $status_is_error = true;
                } else {
                    $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'portfolio';
                    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
                        $status_message = 'The image upload folder could not be created.';
                        $status_is_error = true;
                    } else {
                        $filename = bin2hex(random_bytes(16)) . '.' . $allowedMimes[$mime];
                        $imagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $filename;
                        $relativePath = 'uploads/portfolio/' . $filename;

                        if (!move_uploaded_file($upload['tmp_name'], $imagePath)) {
                            $status_message = 'The image could not be saved. Check the upload folder permissions.';
                            $status_is_error = true;
                        } else {
                            $stmt = $conn->prepare('INSERT INTO portfolio_items (title, category, image_path) VALUES (?, ?, ?)');
                            if ($stmt === false) {
                                unlink($imagePath);
                                $status_message = 'Unable to save the portfolio item to the database.';
                                $status_is_error = true;
                            } else {
                                $stmt->bind_param('sss', $title, $category, $relativePath);
                                if ($stmt->execute()) {
                                    $status_message = 'Portfolio image added successfully.';
                                } else {
                                    unlink($imagePath);
                                    $status_message = 'Unable to save the portfolio item to the database.';
                                    $status_is_error = true;
                                }
                                $stmt->close();
                            }
                        }
                    }
                }
            }
        } else {
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('SELECT image_path FROM portfolio_items WHERE id = ?');
            if ($stmt === false) {
                $status_message = 'Unable to find the portfolio item.';
                $status_is_error = true;
            } else {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $item = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!$item) {
                    $status_message = 'Portfolio item not found.';
                    $status_is_error = true;
                } else {
                    $stmt = $conn->prepare('DELETE FROM portfolio_items WHERE id = ?');
                    if ($stmt === false) {
                        $status_message = 'Unable to delete the portfolio item.';
                        $status_is_error = true;
                    } else {
                        $stmt->bind_param('i', $id);
                        if ($stmt->execute()) {
                            $storedFilename = basename($item['image_path']);
                            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'portfolio' . DIRECTORY_SEPARATOR . $storedFilename;
                            if (preg_match('/^[a-f0-9]{32}\.(jpg|png|webp)$/', $storedFilename) && is_file($imagePath) && !unlink($imagePath)) {
                                $status_message = 'The portfolio item was deleted, but its image file could not be removed.';
                                $status_is_error = true;
                            } else {
                                $status_message = 'Portfolio image deleted successfully.';
                            }
                        } else {
                            $status_message = 'Unable to delete the portfolio item.';
                            $status_is_error = true;
                        }
                        $stmt->close();
                    }
                }
            }
        }
    } elseif ($action === 'delete') {
        $type = $_POST['type'] ?? '';
        $idInput = $_POST['id'] ?? null;
        $id = is_scalar($idInput) ? (int) $idInput : 0;
        $tableByType = [
            'Consultation' => 'appointments',
            'Contact' => 'contact_messages',
            'Registration' => 'registrations',
        ];

        if (!$hasValidCsrfToken) {
            $status_message = 'Your session validation failed. Please try again.';
            $status_is_error = true;
        } elseif ($id < 1 || !is_string($type) || !isset($tableByType[$type])) {
            $status_message = 'The selected request could not be deleted.';
            $status_is_error = true;
        } else {
            $stmt = $conn->prepare('DELETE FROM ' . $tableByType[$type] . ' WHERE id = ?');
            if ($stmt === false) {
                $status_message = 'Unable to prepare the delete request.';
                $status_is_error = true;
            } else {
                $stmt->bind_param('i', $id);
                if ($stmt->execute()) {
                    $status_message = $type . ' deleted successfully.';
                } else {
                    $status_message = 'Unable to delete the selected request.';
                    $status_is_error = true;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'update_status') {
        $idInput = $_POST['id'] ?? null;
        $id = is_scalar($idInput) ? (int) $idInput : 0;
        $status = $_POST['status'] ?? 'Pending';

        if (!$hasValidCsrfToken) {
            $status_message = 'Your session validation failed. Please try again.';
            $status_is_error = true;
        } elseif ($id < 1 || !is_string($status) || !in_array($status, ['Pending', 'Confirmed'], true)) {
            $status_message = 'The selected booking status is invalid.';
            $status_is_error = true;
        } else {
            $stmt = $conn->prepare('UPDATE appointments SET status = ? WHERE id = ?');
            if ($stmt === false) {
                $status_message = 'Unable to prepare the booking status update.';
                $status_is_error = true;
            } else {
                $stmt->bind_param('si', $status, $id);
                if ($stmt->execute()) {
                    $status_message = $status === 'Confirmed'
                        ? 'Booking confirmed successfully.'
                        : 'Booking status updated to Pending.';
                } else {
                    $status_message = 'Unable to update the booking status.';
                    $status_is_error = true;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'clear_all') {
        if (!$hasValidCsrfToken) {
            $status_message = 'Your session validation failed. Please try again.';
            $status_is_error = true;
        } else {
            $clearSucceeded = $conn->begin_transaction();
            if ($clearSucceeded) {
                foreach (['appointments', 'contact_messages', 'registrations'] as $table) {
                    if (!$conn->query('DELETE FROM ' . $table)) {
                        $clearSucceeded = false;
                        break;
                    }
                }
            }
            if ($clearSucceeded) {
                $clearSucceeded = $conn->commit();
            } else {
                $conn->rollback();
            }
            $status_message = $clearSucceeded
                ? 'Consultations, contact messages, and registrations cleared.'
                : 'Unable to clear all requests. Check the database connection and try again.';
            $status_is_error = !$clearSucceeded;
        }
    }
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

$conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$bookingCount = (int) $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'];
$contactCount = (int) $conn->query("SELECT COUNT(*) AS total FROM contact_messages")->fetch_assoc()['total'];
$registrationCount = (int) $conn->query("SELECT COUNT(*) AS total FROM registrations")->fetch_assoc()['total'];
$portfolioRows = $conn->query('SELECT id, title, category, image_path FROM portfolio_items ORDER BY created_at DESC');
if ($portfolioRows === false) {
    throw new RuntimeException('Unable to load portfolio items.');
}
$portfolioItems = [];
while ($portfolioItem = $portfolioRows->fetch_assoc()) {
    $portfolioItems[] = $portfolioItem;
}

$bookingRows = $conn->query("SELECT * FROM appointments ORDER BY created_at DESC");
$contactRows = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$registrationRows = $conn->query("SELECT * FROM registrations ORDER BY created_at DESC");

$allEntries = [];

while ($row = $bookingRows->fetch_assoc()) {
    $row['type'] = 'Consultation';
    $row['notes'] = $row['additional_notes'] ?? '';
    $row['submitted_at'] = $row['created_at'];
    $allEntries[] = $row;
}

while ($row = $contactRows->fetch_assoc()) {
    $row['type'] = 'Contact';
    $row['submitted_at'] = $row['created_at'];
    $allEntries[] = $row;
}

while ($row = $registrationRows->fetch_assoc()) {
    $row['type'] = 'Registration';
    $row['submitted_at'] = $row['created_at'];
    $allEntries[] = $row;
}

usort($allEntries, function ($a, $b) {
    return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zion Stitches Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
  
</head>
<body>
    <header class="admin-site-header">
        <a href="index.php" class="logo-container" aria-label="Zion Stitches home">
            <span class="logo-text">ZION</span>
            <span class="logo-subtext">STITCHES</span>
        </a>
        <a href="logout.php" class="btn-nav-book admin-header-logout">Logout</a>
    </header>

    <main class="admin-panel">
        <div class="admin-panel-header">
            <div>
                <h1>Admin Requests Dashboard</h1>
                <p style="color:#666;">All consultation, contact, and registration requests are stored in the database.</p>
            </div>
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                <form method="POST" action="admin.php" style="margin:0;">
                    <input type="hidden" name="action" value="clear_all">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                    <button type="submit" class="btn-submit-wide" style="width:auto; padding:12px 20px; background:#b33a3a; color:#fff; border:none;" onclick="return confirm('Clear all consultations, contact messages, and registrations?');">Clear All</button>
                </form>
            </div>
        </div>

        <div class="admin-stats-grid">
            <div class="admin-card">
                <h3>Consultations</h3>
                <p><?php echo $bookingCount; ?></p>
            </div>
            <div class="admin-card">
                <h3>Contacts</h3>
                <p><?php echo $contactCount; ?></p>
            </div>
            <div class="admin-card">
                <h3>Registrations</h3>
                <p><?php echo $registrationCount; ?></p>
            </div>
        </div>

        <div class="admin-alert">
            <strong>Live tracking:</strong> Every form submission from the site is captured here instantly.
        </div>

        <?php if ($status_message !== ''): ?>
            <div class="admin-alert" style="background:<?php echo $status_is_error ? '#fdecec' : '#f1fbf3'; ?>; border-color:<?php echo $status_is_error ? '#e7b3b3' : '#b9d8c1'; ?>; color:<?php echo $status_is_error ? '#8b1e1e' : '#1f5b39'; ?>; margin-bottom:20px;">
                <?php echo htmlspecialchars($status_message); ?>
            </div>
        <?php endif; ?>

        <section style="margin:30px 0;">
            <h2>Manage Portfolio</h2>
            <p style="color:#666;">Upload JPEG, PNG, or WebP images up to 5 MB. New items appear on the Collections page.</p>
            <form method="POST" action="admin.php" enctype="multipart/form-data" style="display:flex; gap:12px; align-items:end; flex-wrap:wrap; margin:20px 0;">
                <input type="hidden" name="action" value="add_portfolio">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                <div class="form-group-block" style="margin:0;">
                    <label for="portfolio-title">Title</label>
                    <input id="portfolio-title" type="text" name="title" maxlength="120" required>
                </div>
                <div class="form-group-block" style="margin:0;">
                    <label for="portfolio-category">Category</label>
                    <select id="portfolio-category" name="category" required>
                        <?php foreach ($portfolioCategories as $categoryValue => $categoryLabel): ?>
                            <option value="<?php echo htmlspecialchars($categoryValue); ?>"><?php echo htmlspecialchars($categoryLabel); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group-block" style="margin:0;">
                    <label for="portfolio-image">Image</label>
                    <input id="portfolio-image" type="file" name="portfolio_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
                </div>
                <button type="submit" class="btn-submit-wide" style="width:auto; padding:12px 20px;">Add to Portfolio</button>
            </form>

            <?php if (empty($portfolioItems)): ?>
                <p style="color:#888;">No admin-uploaded portfolio images yet.</p>
            <?php else: ?>
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:16px;">
                    <?php foreach ($portfolioItems as $portfolioItem): ?>
                        <div style="border:1px solid #ddd; padding:12px; border-radius:8px;">
                            <img src="<?php echo htmlspecialchars($portfolioItem['image_path']); ?>" alt="<?php echo htmlspecialchars($portfolioItem['title']); ?>" style="width:100%; height:180px; object-fit:cover;">
                            <p><strong><?php echo htmlspecialchars($portfolioItem['title']); ?></strong><br><?php echo htmlspecialchars($portfolioCategories[$portfolioItem['category']] ?? ''); ?></p>
                            <form method="POST" action="admin.php" onsubmit="return confirm('Delete this portfolio image?');">
                                <input type="hidden" name="action" value="delete_portfolio">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                                <input type="hidden" name="id" value="<?php echo (int) $portfolioItem['id']; ?>">
                                <button type="submit" style="padding:8px 12px; border:none; background:#b33a3a; color:#fff; border-radius:6px; cursor:pointer;">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name / Email</th>
                        <th>Phone</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($allEntries)): ?>
                        <tr>
                            <td colspan="7" style="text-align:center; color:#888;">No requests yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($allEntries as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['type']); ?></td>
                                <td>
                                    <?php
                                        $name = htmlspecialchars((string) ($item['full_name'] ?? $item['name'] ?? '—'));
                                        $email = htmlspecialchars((string) ($item['email'] ?? ''));
                                        echo $name . '<br><span style="color:#888;">' . $email . '</span>';
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars((string) ($item['phone'] ?? '—')); ?></td>
                                <td>
                                    <?php if ($item['type'] === 'Consultation'): ?>
                                        <strong>Date:</strong> <?php echo htmlspecialchars((string) ($item['preferred_date'] ?? '—')); ?><br>
                                        <strong>Time:</strong> <?php echo htmlspecialchars((string) ($item['preferred_time'] ?? '—')); ?><br>
                                        <strong>Service:</strong> <?php echo htmlspecialchars((string) ($item['service_type'] ?? '—')); ?><br>
                                        <small><?php echo htmlspecialchars((string) ($item['notes'] ?? 'No notes provided.')); ?></small>
                                    <?php elseif ($item['type'] === 'Contact'): ?>
                                        <strong>Subject:</strong> <?php echo htmlspecialchars((string) ($item['subject'] ?? '—')); ?><br>
                                        <small><?php echo htmlspecialchars((string) ($item['message'] ?? 'No message provided.')); ?></small>
                                    <?php else: ?>
                                        <strong>Name:</strong> <?php echo htmlspecialchars((string) ($item['full_name'] ?? '—')); ?><br>
                                        <strong>Password:</strong> Stored securely<br>
                                        <strong>Registered:</strong> <?php echo htmlspecialchars((string) ($item['created_at'] ?? '—')); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['type'] === 'Consultation'): ?>
                                        <span style="display:inline-block; padding:6px 10px; border-radius:999px; background:<?php echo (($item['status'] ?? 'Pending') === 'Confirmed') ? '#eafaf1' : '#f9f3d8'; ?>; color:<?php echo (($item['status'] ?? 'Pending') === 'Confirmed') ? '#1f5b39' : '#7a6200'; ?>; font-weight:600;">
                                            <?php echo htmlspecialchars((string) ($item['status'] ?? 'Pending')); ?>
                                        </span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars((string) ($item['submitted_at'] ?? '—')); ?></td>
                                <td>
                                    <?php if ($item['type'] === 'Consultation'): ?>
                                        <?php if (($item['status'] ?? 'Pending') === 'Confirmed'): ?>
                                            <form method="POST" action="admin.php" style="margin:0;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                                                <input type="hidden" name="id" value="<?php echo (int) ($item['id'] ?? 0); ?>">
                                                <input type="hidden" name="status" value="Pending">
                                                <button type="submit" style="padding:8px 12px; border:none; background:#7a6200; color:#fff; border-radius:6px; cursor:pointer;">Set Pending</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" action="admin.php" style="margin:0;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                                                <input type="hidden" name="id" value="<?php echo (int) ($item['id'] ?? 0); ?>">
                                                <input type="hidden" name="status" value="Confirmed">
                                                <button type="submit" style="padding:8px 12px; border:none; background:#1f5b39; color:#fff; border-radius:6px; cursor:pointer;">Confirm booking</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <form method="POST" action="admin.php" style="margin:8px 0 0;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                                        <input type="hidden" name="type" value="<?php echo htmlspecialchars($item['type']); ?>">
                                        <input type="hidden" name="id" value="<?php echo (int) ($item['id'] ?? 0); ?>">
                                        <button type="submit" style="padding:8px 12px; border:none; background:#b33a3a; color:#fff; border-radius:6px; cursor:pointer;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
