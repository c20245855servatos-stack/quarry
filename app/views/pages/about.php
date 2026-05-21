<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - ABOUT PAGE
======================== */
:root {
  /* Core Palette - Construction Style */
  --primary: #1a1a1a;         /* Deep black - Primary elements */
  --secondary: #2d2d2d;       /* Dark gray - Secondary elements */
  --background: #1a1a1a;      /* Black - Main background */
  --accent: #FFD700;          /* Gold/Yellow - Accent elements */
  
  /* Semantic Colors */
  --text-primary: #ffffff;
  --text-secondary: rgba(255, 255, 255, 0.7);
  --text-light: #ffffff;
  --surface: #000000;         /* Pure black surface */
  --surface-alt: #2d2d2d;     /* Dark gray surface */
  --border: #333333;
  --border-light: #FFD700;
  
  /* Interactive States */
  --hover-primary: #333333;
  --hover-secondary: #FFB000;
  --focus-ring: rgba(255, 215, 0, 0.3);
  
  /* Shadows */
  --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.6);
  --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.7);
  --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.8);
}

/* ========================
   ANIMATIONS
======================== */
@keyframes slideInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

@keyframes glow {
    0%, 100% { box-shadow: 0 0 20px rgba(202, 170, 152, 0.3); }
    50% { box-shadow: 0 0 40px rgba(202, 170, 152, 0.6); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: var(--background);
    z-index: -1;
}

/* ========================
   PAGE HERO
======================== */
.page-hero {
    padding: 80px 80px 60px;
    display: flex;
    align-items: center;
    gap: 60px;
    background: linear-gradient(180deg, #1A1A1A 0%, #242424 100%);
    animation: slideInUp 0.8s ease;
}

.page-hero-text {
    flex: 1.2;
    animation: slideInLeft 0.8s ease;
}

.page-tag {
    display: inline-block;
    background: transparent;
    border-left: 4px solid var(--accent);
    color: var(--accent);
    padding: 0 0 0 15px;
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.page-hero-text h1 {
    font-size: 3.4rem;
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    margin: 0 0 18px;
    color: var(--text-light);
}

.page-hero-text h1 span {
    color: var(--accent);
}

.page-hero-text p {
    color: var(--text-secondary);
    font-size: 1rem;
    line-height: 1.75;
    max-width: 520px;
    margin: 0 0 14px;
    font-weight: 700;
}

/* IMAGE SLIDER */
.about-slider-wrap {
    flex: 1;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border);
    position: relative;
    animation: slideInRight 0.8s ease;
    transition: 0.3s ease;
}

.about-slider-wrap:hover {
    border-color: var(--accent);
    box-shadow: var(--shadow-lg);
}

.slider {
    position: relative;
    width: 100%;
    height: 380px;
    overflow: hidden;
}

.slider img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    animation: imgFade 12s infinite;
}

.slider img:nth-child(1) { animation-delay: 0s; }
.slider img:nth-child(2) { animation-delay: 4s; }
.slider img:nth-child(3) { animation-delay: 8s; }

@keyframes imgFade {
    0%   { opacity: 0; }
    8%   { opacity: 1; }
    33%  { opacity: 1; }
    41%  { opacity: 0; }
    100% { opacity: 0; }
}

/* ========================
   SECTION SHARED
======================== */
.sec {
    padding: 80px 80px;
    background: linear-gradient(180deg, #242424 0%, #2A2A2A 100%);
}

.sec-alt {
    background: linear-gradient(180deg, #2A2A2A 0%, #303030 100%);
}

.sec-head {
    text-align: center;
    margin-bottom: 52px;
}

.sec-head h2 {
    font-size: 2rem;
    font-weight: 900;
    margin: 0 0 10px;
    color: var(--text-light);
}

.sec-head p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 700;
}

/* ========================
   FEATURES
======================== */
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.feat-card {
    background: var(--surface);
    border: 2px solid var(--border);
    border-radius: 16px;
    padding: 30px 24px;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease both;
    box-shadow: var(--shadow-md);
}

.feat-card:nth-child(1) { animation-delay: 0.1s; }
.feat-card:nth-child(2) { animation-delay: 0.2s; }
.feat-card:nth-child(3) { animation-delay: 0.3s; }
.feat-card:nth-child(4) { animation-delay: 0.4s; }
.feat-card:nth-child(5) { animation-delay: 0.5s; }
.feat-card:nth-child(6) { animation-delay: 0.6s; }

.feat-card::after {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--accent);
    opacity: 0;
    transition: 0.25s;
}

.feat-card:hover {
    transform: translateY(-12px) scale(1.03);
    background: var(--surface-alt);
    border-color: var(--accent);
    box-shadow: var(--shadow-lg);
}

.feat-card:hover::after {
    opacity: 1;
}

.feat-icon {
    font-size: 2rem;
    margin-bottom: 14px;
    display: block;
    transition: 0.3s ease;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    pointer-events: none;
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
}

.feat-card:hover .feat-icon {
    transform: scale(1.1);
}

.feat-card h3 {
    font-size: 1rem;
    font-weight: 900;
    margin-bottom: 8px;
    color: var(--text-light);
}

.feat-card p {
    color: var(--text-secondary);
    font-size: 0.88rem;
    margin: 0;
    line-height: 1.6;
    font-weight: 700;
}

/* ========================
   MISSION / VALUES
======================== */
.mission-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.mission-card {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 16px;
    padding: 32px 28px;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInUp 0.6s ease both;
}

.mission-card:nth-child(1) { animation-delay: 0.2s; }
.mission-card:nth-child(2) { animation-delay: 0.4s; }

.mission-card:hover {
    background: rgba(255, 215, 0, 0.2);
    transform: translateY(-10px) scale(1.02);
    border-color: var(--accent);
    box-shadow: var(--shadow-lg);
}

.mission-card .m-icon {
    font-size: 2.2rem;
    margin-bottom: 16px;
    display: block;
    transition: 0.3s ease;
    animation: float 3.5s ease-in-out infinite;
}

.mission-card:hover .m-icon {
    animation: none;
    transform: scale(1.25) rotate(-10deg);
}

.mission-card h3 {
    font-size: 1.1rem;
    font-weight: 900;
    margin-bottom: 10px;
    color: var(--accent);
}

.mission-card p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.7;
    margin: 0;
    font-weight: 700;
}

/* ========================
   TEAM / STATS ROW
======================== */
.about-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 0;
}

.about-stat {
    text-align: center;
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 16px;
    padding: 32px 16px;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInUp 0.6s ease both;
}

.about-stat:nth-child(1) { animation-delay: 0.1s; }
.about-stat:nth-child(2) { animation-delay: 0.2s; }
.about-stat:nth-child(3) { animation-delay: 0.3s; }
.about-stat:nth-child(4) { animation-delay: 0.4s; }

.about-stat:hover {
    background: rgba(255, 215, 0, 0.2);
    transform: translateY(-12px) scale(1.05);
    border-color: var(--accent);
    box-shadow: var(--shadow-lg);
}

.about-stat .num {
    font-size: 2.4rem;
    font-weight: 900;
    color: var(--accent);
    line-height: 1;
    margin-bottom: 8px;
    transition: 0.3s ease;
}

.about-stat:hover .num {
    transform: scale(1.15);
    filter: brightness(1.2);
}

.about-stat .lbl {
    font-size: 0.8rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 900;
}

/* ========================
   CTA
======================== */
.cta-wrap {
    padding: 80px 80px 90px;
    background: linear-gradient(180deg, #303030 0%, #1F1F1F 100%);
    text-align: center;
}

.cta-text {
    text-align: center;
    animation: slideInUp 0.8s ease;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.cta-text h2 {
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 10px;
    color: var(--text-light);
}

.cta-text p {
    color: var(--text-secondary);
    margin-bottom: 28px;
    font-size: 0.95rem;
    font-weight: 700;
}

.cta-btns {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-gold {
    padding: 13px 30px;
    background: var(--accent);
    color: var(--primary);
    font-weight: 700;
    font-size: 0.95rem;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}

.btn-gold::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    transition: 0.5s;
}

.btn-gold:hover::before {
    left: 100%;
}

.btn-gold:hover {
    background: var(--text-light);
    color: var(--primary);
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 12px 30px rgba(202, 170, 152, 0.4);
}

.btn-ghost {
    padding: 13px 30px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    font-weight: 600;
    font-size: 0.95rem;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    backdrop-filter: blur(10px);
}

.btn-ghost:hover {
    border-color: var(--accent);
    color: var(--primary);
    background: var(--accent);
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(202, 170, 152, 0.3);
}

/* ========================
   FOOTER
======================== */
.site-footer {
    background: var(--primary);
    padding: 28px 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    color: var(--text-light);
    font-weight: 700;
}

.site-footer .footer-brand {
    font-weight: 900;
    color: var(--text-light);
}

/* ========================
   RESPONSIVE
======================== */
@media (max-width: 1100px) {
    .page-hero, .sec, .cta-wrap { padding-left: 40px; padding-right: 40px; }
    .site-footer { padding: 24px 40px; }
    
    .page-hero {
        gap: 40px;
    }
    
    .about-slider-wrap {
        flex: 1;
        min-width: 0;
    }
    
    .slider {
        height: 320px;
    }
}

@media (max-width: 992px) {
    .features-grid { grid-template-columns: repeat(2, 1fr); }
    .about-stats   { grid-template-columns: repeat(2, 1fr); }
    
    .page-hero {
        flex-direction: column;
        gap: 32px;
    }
    
    .page-hero-text {
        flex: 1;
        width: 100%;
    }
    
    .about-slider-wrap {
        flex: 1;
        width: 100%;
        max-width: 100%;
    }
    
    .slider {
        height: 300px;
        width: 100%;
    }
    
    .slider img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
}

@media (max-width: 768px) {
    .page-hero {
        flex-direction: column;
        padding: 50px 24px 40px;
        gap: 24px;
    }
    
    .page-hero-text {
        width: 100%;
    }
    
    .page-hero-text h1 { 
        font-size: 2.4rem; 
    }
    
    .about-slider-wrap {
        width: 100%;
        max-width: 100%;
        border-radius: 16px;
    }
    
    .slider { 
        height: 240px;
        width: 100%;
    }
    
    .slider img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    
    .sec { padding: 50px 24px; }
    .features-grid,
    .mission-grid,
    .about-stats { grid-template-columns: 1fr; }
    .cta-wrap { padding: 0 24px 50px; }
    .cta-block { padding: 40px 24px; }
    .site-footer { flex-direction: column; gap: 8px; text-align: center; padding: 20px; }
}

@media (max-width: 576px) {
    .page-hero {
        padding: 40px 16px 32px;
    }
    
    .page-hero-text h1 {
        font-size: 2rem;
    }
    
    .about-slider-wrap {
        border-radius: 12px;
    }
    
    .slider {
        height: 200px;
    }

    .sec {
        padding: 36px 16px;
    }

    .about-stats {
        grid-template-columns: 1fr;
    }

    .about-stat .num {
        font-size: 2rem;
    }

    .cta-wrap {
        padding: 0 16px 40px;
    }

    .site-footer {
        padding: 16px;
        font-size: 0.78rem;
    }
}
</style>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="page-hero-text">
        <div class="page-tag">About Us</div>
        <h1>About <span>TerraForge</span></h1>
        <p>
            TerraForge has been the trusted supplier of quality sand, stone, and gravel
            for hardware stores and home improvement retailers across the region.
        </p>
        <p>
            We are committed to delivering consistent quality, reliable service, and competitive pricing
            on every order from small independent hardware stores to large retail chains.
        </p>
        <p>
            We understand the unique needs of hardware retailers. Our mission is to ensure that every hardware store has access to premium sand, stone, and gravel products that meet the highest quality standards. We pride ourselves on our reliable delivery schedules, competitive pricing, and exceptional customer service.
        </p>
        <p>
            Whether you're stocking shelves for a small neighborhood hardware store or managing inventory for a large retail chain, TerraForge is your dependable partner. We source our materials responsibly, maintain strict quality control, and work closely with our retail partners to ensure their customers always get the best products available.
            
        </p>
    </div>

    <div class="about-slider-wrap">
        <div class="slider">
            <img src="https://images.pexels.com/photos/12201830/pexels-photo-12201830.jpeg" loading="lazy" alt="Hardware store">
            <img src="https://images.pexels.com/photos/36224103/pexels-photo-36224103.jpeg" loading="lazy" alt="Hardware supplies">
            <img src="https://images.pexels.com/photos/16567021/pexels-photo-16567021.jpeg" loading="lazy" alt="Retail hardware">
        </div>
    </div>
</section>

<!-- CTA -->
<div class="cta-wrap">
    <div class="cta-text">
        <h2>Ready to Work With Us?</h2>
        <p>Get in touch today and let us supply the sand, stone, and gravel your store needs.</p>
        <div class="cta-btns">
            <a href="?controller=auth&action=index" class="btn-gold">Get Started →</a>
            <a href="?controller=page&action=contact" class="btn-ghost">Contact Us</a>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <span class="footer-brand">TerraForge</span>
    <span>© 2026 All Rights Reserved</span>
    <span>Built for strong foundations</span>
</footer>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
