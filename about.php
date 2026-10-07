<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Our Atelier | Zion Stitches</title>
    <link rel="stylesheet" href="style.css">
    <script src="nav.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&display=swap');

        :root {
            --gold: #dfba8c;
            --dark-gold: #c5a880;
            --beige-bg: #f4efe6;
            --black: #0d0d0d;
            --charcoal: #161616;
            --white: #ffffff;
            --gray-text: #666666;
            --border-color: #e0e0e0;
            --font-serif: 'Cormorant Garamond', serif;
            --font-sans: 'Montserrat', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--white);
            color: var(--black);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s;
        }


        /* --- NAVIGATION HEADER --- */
header {
    background-color: var(--black);
    padding: 20px 4%;
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(197, 168, 128, 0.2);
}

.logo-container .logo-text {
    font-family: var(--font-serif);
    color: var(--white);
    font-size: 26px;
    letter-spacing: 4px;
    font-weight: 700;
}

.logo-container .logo-subtext {
    color: var(--primary-gold);
    font-size: 10px;
    letter-spacing: 6px;
    display: block;
    margin-top: -4px;
}

nav ul {
    display: flex;
    list-style: none;
    gap: 30px;
}

nav ul li a {
    color: #e0e0e0;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
}

nav ul li a:hover, nav ul li a.active {
    color: var(--primary-gold);
}

.btn-nav-book {
    border: 1px solid var(--primary-gold);
    color: var(--primary-gold);
    padding: 10px 20px;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s;
}

.btn-nav-book:hover {
    background-color: var(--primary-gold);
    color: var(--black);
}


        
        
        /* --- HERO BANNER --- */
        .hero-section {
            position: relative;
            height: 65vh;
            background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1512436991641-6745cdb1723f?q=80&w=1920') no-repeat center center/cover;
            display: flex;
            align-items: center;
            padding: 0 4%;
            color: var(--white);
        }

        .hero-content {
            max-width: 600px;
            margin-left: 6%;
        }

        .hero-content h1 {
            font-family: var(--font-serif);
            font-size: 56px;
            font-weight: 400;
            line-height: 1.15;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0 20px 0;
        }

        .divider::after {
            content: "";
            width: 120px;
            height: 1px;
            background-color: rgba(223, 186, 140, 0.4);
        }

        .divider span {
            color: var(--gold);
            font-size: 14px;
        }

        .hero-content p {
            font-size: 15px;
            color: #e0e0e0;
            font-weight: 300;
        }

        /* --- LEGACY SPLIT SECTION --- */
        .brand-intro {
            padding: 90px 6%;
            background-color: var(--white);
        }

        .intro-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 0.8fr;
            align-items: center;
            gap: 40px;
        }

        .intro-text-side {
            padding-left: 20px;
            border-left: 2px solid var(--gold);
        }

        .intro-text-side h3 {
            font-family: var(--font-serif);
            font-size: 36px;
            font-weight: 400;
            line-height: 1.2;
            color: #4a3b2c;
            margin-bottom: 20px;
        }

        .intro-text-side p {
            font-size: 14.5px;
            color: var(--gray-text);
            margin-bottom: 20px;
        }

        .intro-image-side img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }

        /* --- PILLARS CARD --- */
        .values-box {
            background-color: var(--beige-bg);
            padding: 40px 30px;
            border-radius: 6px;
            border: 1px solid rgba(197, 168, 128, 0.2);
        }

        .values-box h4 {
            font-family: var(--font-serif);
            font-size: 24px;
            color: #4a3b2c;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .pillars-list {
            list-style: none;
        }

        .pillars-list li {
            font-size: 14px;
            margin-bottom: 15px;
            color: #333333;
            position: relative;
            padding-left: 20px;
        }

        .pillars-list li::before {
            content: "▪";
            color: var(--dark-gold);
            position: absolute;
            left: 0;
            font-size: 16px;
            top: -2px;
        }

        /* --- SARTORIAL PROCESS SECTION --- */
        .featured-designs {
            padding: 90px 6%;
            background-color: var(--beige-bg);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-family: var(--font-serif);
            font-size: 38px;
            font-weight: 400;
            color: #4a3b2c;
        }

        .divider-small {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .divider-small::before, .divider-small::after {
            content: "";
            width: 40px;
            height: 1px;
            background-color: rgba(74, 59, 44, 0.3);
        }

        .divider-small span {
            color: #4a3b2c;
            font-size: 11px;
        }

        .designs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .process-card {
            background-color: var(--white);
            padding: 45px 35px;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border-bottom: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .process-card:hover {
            transform: translateY(-5px);
            border-bottom-color: var(--gold);
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
        }

        .step-number {
            font-family: var(--font-serif);
            font-size: 48px;
            color: var(--dark-gold);
            opacity: 0.5;
            line-height: 1;
            font-weight: 300;
        }

        .process-card h3 {
            font-family: var(--font-serif);
            font-size: 24px;
            margin: 15px 0 10px 0;
            font-weight: 500;
        }

        .process-card p {
            font-size: 14px;
            color: var(--gray-text);
            line-height: 1.6;
        }

        /* --- PREMIUM FOOTER --- */
        .main-footer {
            background-color: var(--charcoal);
            color: var(--white);
            padding: 60px 6% 25px 6%;
        }

        .footer-top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 40px;
        }

        .footer-cta-left h3 {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 400;
        }

        .footer-cta-left p {
            color: var(--gold);
            font-size: 14px;
            margin-top: 2px;
        }

        .divider-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .divider-footer::after {
            content: "";
            width: 100px;
            height: 1px;
            background-color: rgba(223, 186, 140, 0.3);
        }

        .divider-footer span {
            color: var(--gold);
            font-size: 11px;
        }

        .footer-comms-right {
            display: flex;
            gap: 40px;
        }

        .comm-block {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .comm-icon {
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--gold);
        }

        .comm-text label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            color: #888888;
            letter-spacing: 0.5px;
        }

        .comm-text span {
            font-size: 13px;
            color: #dddddd;
        }

        .footer-btn-container {
            display: flex;
            justify-content: center;
            margin: 35px 0;
        }

        .btn-footer-book {
            background-color: var(--gold);
            color: var(--black);
            border: none;
            padding: 12px 30px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-footer-book:hover {
            background-color: var(--dark-gold);
        }

        .footer-base-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .footer-socials {
            display: flex;
            gap: 15px;
        }

        .footer-socials a {
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .footer-socials a:hover {
            opacity: 1;
        }

        .copyright {
            font-size: 12px;
            color: #777777;
        }

        .tagline {
            font-size: 12px;
            color: var(--gold);
            font-style: italic;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 1024px) {
            .intro-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .intro-text-side {
                border-left: none;
                padding-left: 0;
            }
            .designs-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .footer-top-row {
                flex-direction: column;
                gap: 30px;
                align-items: center;
                text-align: center;
            }
            .footer-comms-right {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            header {
                flex-direction: row;
                gap: 12px;
                flex-wrap: wrap;
                position: relative;
            }
            header nav {
                display: none;
                position: absolute;
                top: 100%;
                right: 4%;
                width: auto;
                min-width: 220px;
                padding: 8px 18px;
                background-color: var(--black);
                border: 1px solid rgba(197, 168, 128, 0.2);
            }
            header.menu-open nav {
                display: block;
            }
            nav ul {
                flex-direction: column;
                gap: 0;
                padding: 10px 0;
                border-top: 1px solid rgba(197, 168, 128, 0.2);
            }
            nav ul li a {
                display: block;
                padding: 10px 0;
            }
            .hero-content h1 {
                font-size: 40px;
            }
            .footer-base-bar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
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
                <li><a href="about.php" class="active">About Us</a></li>
                <li><a href="portfolio.php">Collections</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false" aria-controls="site-navigation">
            <span></span><span></span><span></span>
        </button>
        <a href="login.php" class="btn-nav-book">Login</a>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Our Story</h1>
            <div class="divider"><span>&#10043;</span></div>
            <p>At Zion Stitches, we design clothes that fit your body, your style, and your life.</p>
        </div>
    </section>

    <section class="section-padding welcome-split">
        <div class="welcome-text-node">
            <h2 class="serif-title">Welcome to Zion Stitches</h2>
            <p>At Zion Stitches, we make custom clothes for every style and occasion. From wedding dresses to traditional outfits for men, each piece is made with care and attention to detail.</p>
            <div class="about-purpose">
                <h3>Our Vision</h3>
                <p>To help every person feel confident in clothes made for them.</p>
                <h3>Our Mission</h3>
                <p>To create quality custom clothing with care, skill, and attention to each customer's style.</p>
            </div>
        </div>
        <div class="welcome-image-wrapper">
            <img src="1st Image.jpg" alt="Zion Stitches Atelier Workspace">
        </div>
    </section>

    <section class="featured-designs">
        <div class="section-title">
            <h2>How We Work</h2>
            <div class="divider-small"><span>&#10043;</span></div>
        </div>
        
        <div class="designs-grid">
            <div class="process-card" data-step="1">
                <div class="step-number">01</div>
                <h3>Talk With Us</h3>
                <p>We listen to your ideas, check your style, and talk about fabrics, colors, and fit.</p>
            </div>
            <div class="process-card" data-step="2">
                <div class="step-number">02</div>
                <h3>Design</h3>
                <p>We make the pattern, choose the right cuts, and create the first version for your review.</p>
            </div>
            <div class="process-card" data-step="3">
                <div class="step-number">03</div>
                <h3>Final Touch</h3>
                <p>We adjust the fit, finish the details, and prepare your outfit for collection.</p>
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