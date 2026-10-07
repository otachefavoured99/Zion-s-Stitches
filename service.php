<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Zion Stitches</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&display=swap');

        :root {
            --gold: #c5a880;
            --primary-gold: #c5a880;
            --light-gold: #be9c6e;
            --btn-gold: #c59b68;
            --bg-cream: #fbf9f6;
            --card-border: #f1eae1;
            --black: #0d0d0d;
            --charcoal: #0a0a0a;
            --white: #ffffff;
            --gray-text: #666666;
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
            background-color: var(--bg-cream);
            color: var(--black);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
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

.nav-toggle {
    display: none;
    background: transparent;
    border: 1px solid var(--primary-gold);
    padding: 8px;
    cursor: pointer;
}

.nav-toggle span {
    display: block;
    width: 22px;
    height: 2px;
    margin: 4px 0;
    background-color: var(--primary-gold);
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

        /* --- HERO INTRO SECTION --- */
        .intro-section {
            text-align: center;
            padding: 80px 4% 40px 4%;
            max-width: 800px;
            margin: 0 auto;
        }

        .intro-section h1 {
            font-family: var(--font-serif);
            font-size: 44px;
            font-weight: 400;
            color: var(--black);
            letter-spacing: 1px;
        }

        .title-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 15px 0 25px 0;
        }

        .title-divider::before, .title-divider::after {
            content: "";
            width: 80px;
            height: 1px;
            background-color: #e0d5c1;
        }

        .title-divider span {
            color: var(--gold);
            font-size: 12px;
        }

        .intro-section p {
            font-size: 15px;
            color: var(--gray-text);
            font-weight: 400;
            line-height: 1.7;
        }

        /* --- SERVICES CARD ROW GRID --- */
        .services-wrapper {
            max-width: 1150px;
            margin: 0 auto 90px auto;
            padding: 0 4%;
        }

        .service-block {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            background-color: var(--white);
            margin-bottom: 40px;
            border-radius: 4px;
            border: 1px solid var(--card-border);
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(165, 150, 130, 0.04);
        }

        .service-info {
            padding: 55px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-title-area {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }

        .service-vector-icon {
            width: 24px;
            height: 24px;
            stroke: var(--light-gold);
            stroke-width: 1.5;
            fill: none;
        }

        .service-info h2 {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 400;
            color: var(--black);
            letter-spacing: 0.5px;
        }

        .service-description {
            font-size: 14.5px;
            color: var(--gray-text);
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .meta-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--black);
            margin-bottom: 10px;
        }

        .includes-tree {
            list-style: none;
        }

        .includes-tree li {
            font-size: 14px;
            color: #4a4a4a;
            margin-bottom: 8px;
            position: relative;
            padding-left: 18px;
        }

        .includes-tree li::before {
            content: "•";
            color: var(--light-gold);
            position: absolute;
            left: 0;
            font-size: 16px;
            top: -1px;
        }

        .service-media {
            background-size: cover;
            background-position: center;
            min-height: 380px;
        }

        /* --- CALL TO ACTION BAR --- */
        .cta-strip {
            background-color: var(--charcoal);
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=1200');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 55px 4%;
            color: var(--white);
            border-top: 1px solid rgba(197, 168, 128, 0.15);
            border-bottom: 1px solid rgba(197, 168, 128, 0.15);
        }

        .cta-strip h2 {
            font-family: var(--font-serif);
            font-size: 30px;
            font-weight: 400;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .cta-strip p {
            font-size: 14px;
            color: #b5b5b5;
            margin-bottom: 22px;
            font-weight: 300;
        }

        .btn-action-gold {
            background-color: var(--btn-gold);
            color: var(--white);
            border: none;
            padding: 14px 35px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .btn-action-gold:hover {
            background-color: #b08756;
        }

        /* --- UNIFIED FOOTER SYSTEM --- */
        footer {
            background-color: var(--black);
            color: var(--white);
            padding: 70px 6% 30px 6%;
            font-size: 14px;
        }

        .footer-top-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .footer-brand-column p {
            margin-top: 15px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .footer-brand-column .social-icon-row {
            justify-content: flex-start;
            gap: 12px;
        }

        .footer-column-heading {
            color: var(--white);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-links-list {
            list-style: none;
        }

        .footer-links-list li {
            margin-bottom: 12px;
        }

        .footer-links-list li a:hover {
            color: var(--primary-gold);
        }

        .contact-detail-bullets li {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .contact-detail-bullets li span:first-child {
            color: var(--primary-gold);
        }

        .footer-bottom-bar {
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
        }

        .social-circle {
            width: 32px;
            height: 32px;
            border: 1px solid #262626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #8c8c8c;
            transition: all 0.3s ease;
        }

        .social-circle:hover {
            color: var(--gold);
            border-color: var(--gold);
        }

        .footer-column h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold);
            margin-bottom: 22px;
            font-weight: 600;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
        }

        .footer-column ul li a {
            color: #8c8c8c;
            font-size: 13.5px;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: var(--white);
        }

        .contact-channel li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #8c8c8c;
            font-size: 13.5px;
        }

        .contact-channel icon {
            color: var(--gold);
            font-size: 14px;
        }

        .footer-bottom-bar {
            border-top: 1px solid #1a1a1a;
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #595959;
            font-size: 12px;
        }

        /* --- RESPONSIVE MEDIA BREAKPOINTS --- */
        @media (max-width: 992px) {
            .service-block {
                grid-template-columns: 1fr;
            }
            .service-media {
                min-height: 300px;
                grid-row: 1;
            }
            .service-info {
                padding: 40px 35px;
            }
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            header {
                flex-direction: row;
                gap: 12px;
                flex-wrap: wrap;
                padding: 20px;
                position: relative;
            }
            .nav-toggle {
                display: block;
                margin-left: auto;
            }
            header nav {
                display: none;
                position: absolute;
                top: 100%;
                right: 20px;
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
            .btn-nav-book {
                display: none;
            }
            header.menu-open .nav-toggle span:nth-child(1) {
                transform: translateY(6px) rotate(45deg);
            }
            header.menu-open .nav-toggle span:nth-child(2) {
                opacity: 0;
            }
            header.menu-open .nav-toggle span:nth-child(3) {
                transform: translateY(-6px) rotate(-45deg);
            }
            .intro-section h1 {
                font-size: 34px;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .footer-bottom-bar {
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
                <li><a href="service.php" class="active">Service</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="portfolio.php">Collections</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false" aria-controls="site-navigation">
            <span></span><span></span><span></span>
        </button>
        <a href="login.php" class="btn-nav-book">Login</a>
    </header>


    <section class="intro-section">
        <h1>Our Services</h1>
        <div class="title-divider"><span>&#10059;</span></div>
        <p>We make fashion pieces that fit your style, your body, and your occasion. Whether you need a special outfit or everyday wear, we create pieces that look good and feel right.</p>
    </section>

    <section class="services-wrapper">
        
        <div class="service-block">
            <div class="service-info">
                <div class="service-title-area">
                    <svg class="service-vector-icon" viewBox="0 0 24 24"><path d="M6 3l12 18M18 3L6 21" stroke-linecap="round"/></svg>
                    <h2>Custom Dressmaking</h2>
                </div>
                <p class="service-description">We design and sew unique outfits based on your measurements, fabric choice, and personal style.</p>
                <div class="meta-label">Best for:</div>
                <ul class="includes-tree">
                    <li>Parties, events, casual wear, and special occasions.</li>
                </ul>
            </div>
            <div class="service-media" style="background-image: url('co\ 3.jpg');"></div>
        </div>

        <div class="service-block">
            <div class="service-info">
                <div class="service-title-area">
                    <svg class="service-vector-icon" viewBox="0 0 24 24"><path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <h2>Bridal Wear</h2>
                </div>
                <p class="service-description">Your big day deserves a perfect dress.</p>
                <div class="meta-label">Includes:</div>
                <ul class="includes-tree">
                    <li>Bridal gowns</li>
                    <li>Traditional wedding attire</li>
                    <li>Bridesmaids' dresses</li>
                </ul>
            </div>
            <div class="service-media" style="background-image: url('bridal\ maid.jpg');"></div>
        </div>

        <div class="service-block">
            <div class="service-info">
                <div class="service-title-area">
                    <svg class="service-vector-icon" viewBox="0 0 24 24"><path d="M20 7H4v14h16V7zM16 7V4a4 4 0 00-8 0v3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <h2>Ready-to-Wear Collections</h2>
                </div>
                <p class="service-description">Explore our stylish ready-made outfits available for immediate purchase.</p>
            </div>
            <div class="service-media" style="background-image: url('corporate\ 1.jpg');"></div>
        </div>

        

        <div class="service-block">
            <div class="service-info">
                <div class="service-title-area">
                    <svg class="service-vector-icon" viewBox="0 0 24 24"><path d="M12 22a3 3 0 003-3H9a3 3 0 003 3zm6-6V11a6 6 0 00-5-5.91V4a1 1 0 00-2 0v1.09A6 6 0 006 11v5l-2 2v1h16v-1l-2-2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <h2>Fashion Consultation</h2>
                </div>
                <p class="service-description">Not sure what style suits you?</p>
                <div class="meta-label">Ideal for:</div>
                <ul class="includes-tree">
                    <li>Events, weddings, photoshoots, and professionals.</li>
                </ul>
            </div>
            <div class="service-media" style="background-image: url('co 1.jpg');"></div>
        </div>

   
    </section>

    <section class="cta-strip">
        <h2>Love our collection?</h2>
        <p>Book a consultation with our team and let us create the outfit you want.</p>
        <a href="login.php?redirect=book-consultation.php" class="btn-action-gold">Book Your Appointment &gt;</a>
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