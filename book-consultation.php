<?php
require_once "config.php";
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=book-consultation.php');
    exit;
}
$successMessage = isset($_GET['success']) && $_GET['success'] === '1';
$errorMessage = isset($_GET['error']) && $_GET['error'] === '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Private Consultation | Zion Stitches</title>
    <link rel="stylesheet" href="style.css?v=booking-hero-20261005">
</head>
<body>
    <header class="booking-page-header">
        <a href="index.php" class="logo-container">
            <span class="logo-text">ZION</span>
            <span class="logo-subtext">STITCHES</span>
        </a>
        <a href="logout.php" class="btn-nav-book booking-page-logout">Logout</a>
    </header>

    <section class="hero-banner booking-page-hero compact-page-hero">
        <span class="hero-tag">Appointments</span>
        <h1 style="font-size:42px;">Book a Consultation</h1>
        <p>Choose a date and time to discuss your design.</p>
    </section>

    <section class="section-padding booking-form-section" style="background-color: #f7f7f7;">
        <div class="booking-engine-wrapper">
            <div class="booking-left-form">
                <h3 class="serif-title" style="font-size: 26px; margin-bottom: 25px;">Your Details</h3>
                <form id="bookingForm" action="save_appointment.php" method="POST">
                    <div class="form-row-twin">
                        <div class="form-group-block">
                            <label>Full Name <span>*</span></label>
                            <input type="text" id="bookingName" name="full_name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group-block">
                            <label>Email Address <span>*</span></label>
                            <input type="email" id="bookingEmail" name="email" placeholder="Enter your email address" required>
                        </div>
                    </div>

                    <div class="form-row-twin">
                        <div class="form-group-block">
                            <label>Phone Number <span>*</span></label>
                            <input type="tel" id="bookingPhone" name="phone" placeholder="Enter phone number" required>
                        </div>
                        <div class="form-group-block">
                            <label>Preferred Date <span>*</span></label>
                            <input type="date" id="bookingDateDisplay" name="preferred_date" required>
                        </div>
                    </div>

                    <div class="form-group-block">
                        <label>Preferred Time <span>*</span></label>
                        <input type="time" id="bookingTimeDisplay" name="preferred_time" required>
                    </div>

                    <div class="form-group-block" style="margin-top: 10px;">
                        <label>Select Service Type <span>*</span></label>
                        <select name="service_type" class="form-group-block" style="padding:14px 16px;" required>
                            <option value="">Choose a service</option>
                            <option value="Custom Design">Custom Design</option>
                            <option value="Fitting">Fitting</option>
                            <option value="Consultation">Consultation</option>
                        </select>
                    </div>

                    <div class="form-group-block">
                        <label>Additional Notes (Optional)</label>
                        <textarea id="bookingNotes" name="notes" placeholder="Tell us about your design requirements, timeline goals or inspiration ideas..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit-wide">Confirm Booking Request</button>

                    <?php if ($successMessage): ?>
                        <div class="success-box" style="margin-top: 20px; padding: 12px 14px; background: #eafaf1; border: 1px solid #7ec89d; border-radius: 8px; color: #1f5b39;">
                            <h4 style="margin: 0 0 8px;">Booking request received</h4>
                            <p style="margin: 0;">Your consultation request has been submitted successfully.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($errorMessage): ?>
                        <div class="error-box" role="alert" style="margin-top: 20px; padding: 12px 14px; background: #fdecec; border: 1px solid #e7b3b3; border-radius: 8px; color: #8b1e1e;">
                            We could not save your booking. Please check your details and try again.
                        </div>
                    <?php endif; ?>

                    <p class="privacy-notice">&#128274; Your identity details remain fully confidential inside our client ledger.</p>
                </form>
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
