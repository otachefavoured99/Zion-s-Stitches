<?php
require_once 'config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $messageText = trim($_POST['message'] ?? '');

    if ($full_name === '' || $email === '' || $subject === '' || $messageText === '') {
        $error = 'Please complete all required fields before sending your message.';
    } else {
        $conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) DEFAULT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $error = 'Unable to prepare contact message insert.';
        } else {
            $stmt->bind_param('sssss', $full_name, $email, $phone, $subject, $messageText);
            if ($stmt->execute()) {
                $message = 'Your message has been sent successfully. We will get back to you soon.';
                $full_name = '';
                $email = '';
                $phone = '';
                $subject = '';
                $messageText = '';
            } else {
                $error = 'There was a problem sending your message. Please try again.';
            }
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
    <title>Contact Our Design Team | Zion Stitches</title>
    <link rel="stylesheet" href="style.css?v=compact-hero-20261005">
    
</head>
<body>
    <header>
        <a href="index.php" class="logo-container" aria-label="Zion Stitches home">
            <span class="logo-text">ZION</span>
            <span class="logo-subtext">STITCHES</span>
        </a>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="service.php">Service</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="portfolio.php">Collections</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
        </nav>
        <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false" aria-controls="site-navigation">
            <span></span><span></span><span></span>
        </button>
        <a href="login.php" class="btn-nav-book">Login</a>
    </header>

    <section class="hero-banner contact-hero compact-page-hero">
        <span class="hero-tag">Get In Touch</span>
        <h1>We'd love to<br><span>hear from you</span></h1>
        <div class="hero-divider"><span>&#10059;</span></div>
        <p>Tell us about your event, your style, or the outfit you want. We are ready to help.</p>
    </section>

    <section class="section-padding" style="background-color: #ffffff;">
        <div class="contact-grid">
            <div class="contact-form-card">
                <span class="section-tag">Send Us A Message</span>
                <h2 class="serif-title" style="font-size: 32px; margin-bottom: 10px;">How can we help?</h2>
                <p style="color:#666; font-size:14px; margin-bottom: 30px;">Tell us what you need and we will guide you the right way.</p>

               

                <?php if ($message !== ''): ?>
                    <div class="success-card-alert" style="margin-bottom:20px; padding:18px; border:1px solid #c5a880; background:#f6fdf8; color:#1d5f3a;">
                        <h4 style="margin:0 0 8px;">Message received</h4>
                        <p style="margin:0;"><?php echo htmlspecialchars($message); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($error !== ''): ?>
                    <div class="success-card-alert" style="margin-bottom:20px; padding:18px; border:1px solid #d8a3a3; background:#fff1f1; color:#7d1d1d;">
                        <p style="margin:0;"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="contact.php">
                    <div class="form-row-twin">
                        <div class="form-group-block">
                            <label>Full Name</label>
                            <input id="contactName" type="text" name="full_name" placeholder="Enter full name" value="<?php echo htmlspecialchars($full_name ?? ''); ?>" required>
                        </div>
                        <div class="form-group-block">
                            <label>Email Address</label>
                            <input id="contactEmail" type="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-row-twin">
                        <div class="form-group-block">
                            <label>Phone Number</label>
                            <input id="contactPhone" type="tel" name="phone" placeholder="Enter phone number" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                        </div>
                        <div class="form-group-block">
                            <label>Select Subject</label>
                            <select id="contactSubject" name="subject" required>
                                <option value="">What is this regarding?</option>
                                <option value="Bridal Couture Request" <?php if (($subject ?? '') === 'Bridal Couture Request') echo 'selected'; ?>>Bridal Couture Request</option>
                                <option value="Ready-To-Wear Inquiry" <?php if (($subject ?? '') === 'Ready-To-Wear Inquiry') echo 'selected'; ?>>Ready-To-Wear Inquiry</option>
                                <option value="Fittings & Alterations" <?php if (($subject ?? '') === 'Fittings & Alterations') echo 'selected'; ?>>Fittings & Alterations</option>
                                <option value="General Brand Question" <?php if (($subject ?? '') === 'General Brand Question') echo 'selected'; ?>>General Brand Question</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-block">
                        <label>Your Message</label>
                        <textarea id="contactMessage" name="message" placeholder="Type your message details here..." required><?php echo htmlspecialchars($messageText ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn-submit-wide" style="background-color: var(--black); color: var(--white);">Send Message</button>
                </form>
            </div>

            <div class="info-sidebar-card" style="padding-left: 20px;">
                <span class="section-tag">Contact Information</span>
                <h2 class="serif-title" style="font-size: 32px; margin-bottom: 35px;">Contact details</h2>

                <div class="info-row-item">
                    <div class="info-icon-circle">&#128222;</div>
                    <div class="info-text-node">
                        <h5>Phone Number</h5>
                        <p>+234 806 123 4567</p>
                        <span>Mon - Sat: 9:00 AM - 6:00 PM</span>
                    </div>
                </div>

                <div class="info-row-item">
                    <div class="info-icon-circle">&#128231;</div>
                    <div class="info-text-node">
                        <h5>Email Address</h5>
                        <p>zionstitches@gmail.com</p>
                        <span>We reply as soon as possible</span>
                    </div>
                </div>

                <div class="info-row-item">
                    <div class="info-icon-circle">&#128172;</div>
                    <div class="info-text-node">
                        <h5>WhatsApp Chat</h5>
                        <p>Chat instantly with our styling agents.</p>
                        <a href="https://wa.me/2348061234567" target="_blank" class="btn-whatsapp-chat">Chat Now &nbsp; &#128405;</a>
                    </div>
                </div>

                <div class="info-row-item">
                    <div class="info-icon-circle">&#128205;</div>
                    <div class="info-text-node">
                        <h5>Studio Location</h5>
                        <p>Dutse Alhaji 1, Abuja, Nigeria</p>
                        <span>Mon - Sat: 10:00 AM - 6:00 PM</span>
                    </div>
                </div>
            </div>
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
