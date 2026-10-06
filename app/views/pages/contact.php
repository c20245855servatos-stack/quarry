<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - CONTACT PAGE
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

body {
    background: linear-gradient(180deg, #1A1A1A 0%, #242424 50%, #2A2A2A 100%);
    color: var(--text-primary);
    min-height: 100vh;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
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
    text-align: center;
    border-bottom: 1px solid rgba(52, 101, 109, 0.1);
    animation: slideInUp 0.8s ease;
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

.page-hero h1 {
    font-size: 3.2rem;
    font-weight: 900;
    text-transform: uppercase;
    margin: 0 0 14px;
    color: var(--text-primary);
}

.page-hero h1 span {
    color: var(--accent);
}

.page-hero p {
    color: var(--text-secondary);
    font-size: 1rem;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.7;
    font-weight: 700;
}

/* ========================
   CONTACT SECTION
======================== */
.contact-sec {
    padding: 80px 80px;
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 40px;
    align-items: start;
}

/* ========================
   INFO PANEL
======================== */
.info-panel {
    display: flex;
    flex-direction: column;
    gap: 16px;
    animation: slideInLeft 0.8s ease;
}

.info-panel h2 {
    font-size: 1.4rem;
    font-weight: 900;
    margin: 0 0 6px;
    color: var(--text-primary);
}

.info-panel .sub {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0 0 20px;
    line-height: 1.6;
    font-weight: 700;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 14px;
    padding: 18px 20px;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInLeft 0.6s ease both;
}

.info-item:nth-child(2) { animation-delay: 0.1s; }
.info-item:nth-child(3) { animation-delay: 0.2s; }
.info-item:nth-child(4) { animation-delay: 0.3s; }

.info-item:hover {
    background: rgba(255, 215, 0, 0.2);
    transform: translateX(8px) translateY(-4px);
    border-color: var(--accent);
    box-shadow: var(--shadow-sm);
}

.info-item .i-icon {
    width: 42px; height: 42px;
    background: var(--accent);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    color: var(--primary);
}

.info-item .i-text strong {
    display: block;
    font-size: 0.88rem;
    font-weight: 900;
    margin-bottom: 3px;
    color: var(--text-primary);
}

.info-item .i-text span {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-weight: 700;
}

/* Hours card */
.hours-card {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 14px;
    padding: 20px;
    margin-top: 4px;
    animation: slideInLeft 0.6s ease 0.35s both;
    transition: 0.3s ease;
}

.hours-card:hover {
    background: rgba(255, 215, 0, 0.2);
    border-color: var(--accent);
    box-shadow: var(--shadow-md);
}

.hours-card h4 {
    font-size: 0.88rem;
    font-weight: 900;
    color: var(--accent);
    margin: 0 0 12px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.hours-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    padding: 6px 0;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    color: var(--text-secondary);
    font-weight: 700;
}

.hours-row:last-child { border-bottom: none; }
.hours-row .day { color: var(--text-secondary); font-weight: 700; }
.hours-row .time { font-weight: 900; color: var(--text-primary); }

/* ========================
   FORM PANEL
======================== */
.form-panel {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 40px 36px;
    backdrop-filter: blur(10px);
}

.form-panel h2 {
    font-size: 1.4rem;
    font-weight: 800;
    margin: 0 0 6px;
}

.form-panel .sub {
    color: rgba(255,255,255,0.5);
    font-size: 0.88rem;
    margin: 0 0 28px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 14px;
}

.form-group label {
    font-size: 0.82rem;
    font-weight: 900;
    color: rgba(255,255,255,0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-group input,
.form-group textarea,
.form-group select {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.9rem;
    outline: none;
    transition: 0.2s;
    width: 100%;
    font-family: Arial, sans-serif;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: rgba(255,255,255,0.25);
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #34656D;
    background: rgba(255,255,255,0.09);
    box-shadow: 0 0 0 3px rgba(52, 101, 109, 0.15);
}

.form-group select option {
    background: #1a1a1a;
    color: white;
}

.form-group textarea {
    height: 130px;
    resize: vertical;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #34656D, #28a745);
    color: white;
    font-weight: 900;
    font-size: 0.95rem;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
    letter-spacing: 0.3px;
    margin-top: 4px;
}

.btn-submit:hover {
    opacity: 0.88;
    transform: translateY(-2px);
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
    .page-hero, .contact-sec { padding-left: 40px; padding-right: 40px; }
    .site-footer { padding: 24px 40px; }
}

@media (max-width: 900px) {
    .contact-sec {
        grid-template-columns: 1fr;
        padding: 50px 40px;
    }
}

@media (max-width: 768px) {
    .page-hero { padding: 50px 24px 40px; }
    .page-hero h1 { font-size: 2.4rem; }
    .contact-sec { padding: 40px 24px; }
    .form-panel { padding: 28px 20px; }
    .form-row { grid-template-columns: 1fr; }
    .site-footer { flex-direction: column; gap: 8px; text-align: center; padding: 20px; }
}

@media (max-width: 575px) {
    .page-hero {
        padding: 36px 16px 28px;
    }

    .page-hero h1 {
        font-size: 2rem;
    }

    .contact-sec {
        padding: 28px 16px;
    }

    .form-panel {
        padding: 20px 16px;
        border-radius: 14px;
    }

    .info-item {
        padding: 14px 16px;
    }

    .hours-card {
        padding: 16px;
    }

    .site-footer {
        padding: 16px;
        font-size: 0.78rem;
    }
}
</style>

<!-- PAGE HERO -->
<section class="page-hero">
    <div class="page-tag">Get In Touch</div>
    <h1>Contact <span>Us</span></h1>
    <p>Have a question or ready to order? We'd love to hear from you. Our team responds within 24 hours.</p>
</section>

<!-- CONTACT SECTION -->
<div class="contact-sec" style="grid-template-columns: 1fr;">

    <!-- INFO PANEL -->
    <div class="info-panel">
        <h2>Contact Information</h2>
        <p class="sub">Reach us through any of the channels below and we'll get back to you as soon as possible.</p>

        <div class="info-item">
            <div class="i-icon"><i class="bi bi-geo-alt-fill"></i></div>
            <div class="i-text">
                <strong>Location</strong>
                <span>Ambulong, Talisay City, Negros Occidental</span>
            </div>
        </div>

        <div class="info-item">
            <div class="i-icon"><i class="bi bi-telephone-fill"></i></div>
            <div class="i-text">
                <strong>Phone</strong>
                <span>+63 9187536549</span>
            </div>
        </div>

        <div class="info-item">
            <div class="i-icon"><i class="bi bi-envelope-fill"></i></div>
            <div class="i-text">
                <strong>Email</strong>
                <span>terraforge@gmail.com</span>
            </div>
        </div>

        <div class="hours-card">
            <h4><i class="bi bi-clock-fill"></i> Business Hours</h4>
            <div class="hours-row">
                <span class="day">Monday – Friday</span>
                <span class="time">8:00 AM – 5:00 PM</span>
            </div>
            <div class="hours-row">
                <span class="day">Saturday</span>
                <span class="time">8:00 AM – 12:00 PM</span>
            </div>
            <div class="hours-row">
                <span class="day">Sunday</span>
                <span class="time">Closed</span>
            </div>
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
