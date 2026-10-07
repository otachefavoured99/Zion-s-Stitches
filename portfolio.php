<?php
require_once 'config.php';
require_once 'portfolio_helpers.php';

ensure_portfolio_table($conn);
$portfolioCategories = portfolio_categories();
$portfolioRows = $conn->query('SELECT title, category, image_path FROM portfolio_items ORDER BY id ASC');
if ($portfolioRows === false) {
    throw new RuntimeException('Unable to load portfolio items.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections Portfolio | Zion Stitches</title>
    <link class="shared-css" rel="stylesheet" href="style.css?v=compact-hero-20261005">
    <script src="nav.js" defer></script>
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
                <li><a href="portfolio.php" class="active">Collections</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false" aria-controls="site-navigation">
            <span></span><span></span><span></span>
        </button>
        <a href="login.php" class="btn-nav-book">Login</a>
    </header>

    <section class="hero-banner compact-page-hero" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1920');">
        <span class="hero-tag">Our Collections</span>
        <h1 style="font-size: 48px;">Our styles,<br><span>made for you</span></h1>
        <p>Explore our collection of handmade outfits that mix classic style with modern design.</p>
    </section>

    <section class="section-padding">
        <div class="collection-filters">
            <button class="filter-btn active" onclick="filterGallery('all', this)">All Collections</button>
            <?php foreach ($portfolioCategories as $categoryValue => $categoryLabel): ?>
                <button class="filter-btn" onclick="filterGallery('<?php echo htmlspecialchars($categoryValue); ?>', this)"><?php echo htmlspecialchars($categoryLabel); ?></button>
            <?php endforeach; ?>
        </div>

        <div class="grid-gallery" id="portfolio-grid">
            <?php while ($item = $portfolioRows->fetch_assoc()): ?>
                <div class="gallery-card" data-category="<?php echo htmlspecialchars($item['category']); ?>">
                    <div class="card-img-container">
                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    </div>
                    <div class="card-details">
                        <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                        <span><?php echo htmlspecialchars($portfolioCategories[$item['category']] ?? ''); ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php if ($portfolioRows->num_rows === 0): ?>
                <p class="portfolio-empty-state">No collections have been added yet. Add images from the admin dashboard.</p>
            <?php endif; ?>
        </div>

        <div class="inline-cta-banner">
            <div class="cta-text-left">
                <h3>Love our collection?</h3>
                <p>Book a consultation and let us help you create your perfect outfit.</p>
            </div>
            <a href="login.php?redirect=book-consultation.php" class="btn-gold">Book Your Appointment &rarr;</a>
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

    <script>
        function filterGallery(category, activeButton) {
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            activeButton.classList.add('active');

            const cards = document.querySelectorAll('.gallery-card');
            cards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>