<?php ob_start(); ?>

<style>
/* ========================
   GLOBAL RESPONSIVE FIXES
======================== */
* {
  box-sizing: border-box;
}

html, body {
  overflow-x: hidden;
  width: 100%;
  max-width: 100vw;
}

/* ========================
   MODERN CONSTRUCTION THEME
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
    50% { transform: translateY(-10px); }
}

/* ========================
   HERO SECTION - CONSTRUCTION STYLE
======================== */
.hero {
    min-height: 90vh;
    background-image: url("https://images.pexels.com/photos/8247090/pexels-photo-8247090.jpeg");
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    padding: 0 5%;
    overflow: hidden;
    width: 100%;
}

.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.85) 45%, rgba(0,0,0,0.4) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 3;
    max-width: 500px;
    color: var(--text-light);
    width: 100%;
    padding-right: 2rem;
}

.hero-badge {
    display: inline-block;
    background: transparent;
    color: var(--accent);
    padding: 0;
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-left: 4px solid var(--accent);
    padding-left: 15px;
}

.hero-title {
    font-size: clamp(2rem, 8vw, 4.5rem);
    font-weight: 900;
    line-height: 1.1;
    margin: 0 0 30px;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: -2px;
    word-wrap: break-word;
}

.hero-title .highlight {
    color: var(--accent);
}

.hero-subtitle {
    font-size: clamp(1rem, 2.5vw, 1.2rem);
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 40px;
    font-weight: 400;
    max-width: 100%;
}

.hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 36px;
    background: var(--accent);
    color: var(--primary);
    font-weight: 900;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.hero-cta::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
    transition: 0.5s;
}

.hero-cta:hover::before {
    left: 100%;
}

.hero-cta:hover {
    background: var(--hover-secondary);
    transform: translateY(-3px) scale(1.05);
    box-shadow: var(--shadow-md);
}

.hero-truck {
    position: absolute;
    bottom: -50px;
    left: 50px;
    width: min(400px, 30vw);
    height: 200px;
    background-image: url("");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 2;
    animation: slideInLeft 1s ease 0.5s both;
}

/* ========================
   PARTNERS SECTION - CONSTRUCTION STYLE
======================== */
.partners-section {
    padding: 80px 5%;
    background: var(--surface);
    border-bottom: 2px solid var(--border);
    width: 100%;
}

.partners-grid {
    display: flex;
    justify-content: space-between;
    align-items: center;
    opacity: 0.8;
    gap: clamp(20px, 5vw, 50px);
    flex-wrap: wrap;
}

.partner-logo {
    font-size: clamp(1rem, 2.5vw, 1.3rem);
    font-weight: 900;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: 0.3s ease;
    flex: 1;
    min-width: 150px;
    text-align: center;
}

.partner-logo:hover {
    color: var(--accent);
    transform: scale(1.05);
}

/* ========================
   FEATURES SECTION - CONSTRUCTION STYLE
======================== */
.features-section {
    padding: 120px 5%;
    background: var(--surface-alt);
    width: 100%;
}

.features-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(50px, 10vw, 100px);
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
}

.features-content {
    animation: slideInLeft 0.8s ease;
}

.features-badge {
    display: inline-block;
    background: transparent;
    color: var(--accent);
    padding: 0;
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-left: 4px solid var(--accent);
    padding-left: 15px;
}

.features-title {
    font-size: clamp(2rem, 6vw, 3rem);
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1.1;
    margin-bottom: 25px;
    text-transform: uppercase;
    letter-spacing: -1px;
}

.features-description {
    color: var(--text-secondary);
    font-size: clamp(1rem, 2.5vw, 1.1rem);
    line-height: 1.6;
    margin-bottom: 35px;
}

.features-list {
    list-style: none;
    padding: 0;
    margin-bottom: 35px;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px 0;
    color: var(--text-primary);
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.features-list li::before {
    content: "✓";
    width: 24px;
    height: 24px;
    background: var(--accent);
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 900;
}

.features-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    background: var(--accent);
    color: var(--primary);
    font-weight: 900;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.features-cta::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
    transition: 0.5s;
}

.features-cta:hover::before {
    left: 100%;
}

.features-cta:hover {
    background: var(--hover-secondary);
    transform: translateY(-3px);
}

.features-visual {
    position: relative;
    animation: slideInRight 0.8s ease;
}

.features-image {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 3px solid var(--accent);
}

.construction-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: 0.4s ease;
    display: block;
}

.construction-image:hover {
    transform: scale(1.05);
}

/* ========================
   PRODUCTS SECTION - CONSTRUCTION STYLE
======================== */
.products-section {
    padding: 120px 5%;
    background: var(--primary);
    position: relative;
    width: 100%;
}

.products-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 0%, rgba(255, 215, 0, 0.1) 100%);
}

.products-header {
    text-align: center;
    margin-bottom: 80px;
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.products-badge {
    display: inline-block;
    background: transparent;
    color: var(--accent);
    padding: 0;
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-left: 4px solid var(--accent);
    padding-left: 15px;
}

.products-title {
    font-size: clamp(2rem, 6vw, 3rem);
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: -1px;
}

.products-description {
    color: var(--text-secondary);
    font-size: clamp(1rem, 2.5vw, 1.1rem);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
}

.product-item {
    animation: slideInUp 0.8s ease both;
    transition: 0.4s ease;
}

.product-item:nth-child(1) { animation-delay: 0.1s; }
.product-item:nth-child(2) { animation-delay: 0.2s; }
.product-item:nth-child(3) { animation-delay: 0.3s; }
.product-item:nth-child(4) { animation-delay: 0.4s; }

.product-item:hover {
    transform: translateY(-8px) scale(1.02);
}

.product-image {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid var(--accent);
    box-shadow: var(--shadow-md);
    transition: 0.4s ease;
}

.product-image:hover {
    border-color: var(--hover-secondary);
    box-shadow: var(--shadow-lg);
}

.product-img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: 0.4s ease;
}

.product-img:hover {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
    padding: 20px;
    transform: translateY(100%);
    transition: 0.4s ease;
}

.product-item:hover .product-overlay {
    transform: translateY(0);
}

.product-name {
    color: var(--accent);
    font-size: 1.1rem;
    font-weight: 900;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ========================
   HOW IT WORKS SECTION
======================== */
.how-it-works-section {
    padding: 100px 5%;
    background: #1a1a1a;
    position: relative;
    overflow: hidden;
    width: 100%;
}

.how-it-works-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    z-index: 1;
}

.how-it-works-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
}

.how-it-works-header {
    margin-bottom: 80px;
}

.how-it-works-badge {
    display: inline-block;
    background: transparent;
    color: #FFD700;
    padding: 0;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-left: 4px solid #FFD700;
    padding-left: 15px;
}

.how-it-works-title {
    font-size: clamp(2.5rem, 8vw, 4rem);
    font-weight: 900;
    color: white;
    margin-bottom: 30px;
    line-height: 1.1;
    text-transform: uppercase;
    letter-spacing: -2px;
}

.how-it-works-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: clamp(1rem, 2.5vw, 1.1rem);
    max-width: 500px;
    line-height: 1.6;
    margin-bottom: 50px;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
}

.step-card {
    background: #000;
    border: none;
    padding: clamp(40px, 8vw, 60px) clamp(20px, 5vw, 40px);
    text-align: left;
    transition: 0.4s ease;
    position: relative;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;
}

.step-card:nth-child(1) {
    background: #FFD700;
    color: #000;
}

.step-card:nth-child(2) {
    background: #000;
    color: white;
}

.step-card:nth-child(3) {
    background: #000;
    color: white;
}

.step-card:nth-child(4) {
    background: #FFD700;
    color: #000;
}

.step-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 0%, rgba(255, 215, 0, 0.1) 100%);
    opacity: 0;
    transition: 0.4s ease;
}

.step-card:hover::before {
    opacity: 1;
}

.step-card:hover {
    transform: scale(1.02);
}

.step-number {
    font-size: clamp(3rem, 8vw, 5rem);
    font-weight: 900;
    margin-bottom: 20px;
    opacity: 0.3;
    line-height: 1;
}

.step-card:nth-child(1) .step-number,
.step-card:nth-child(4) .step-number {
    color: rgba(0, 0, 0, 0.3);
}

.step-card:nth-child(2) .step-number,
.step-card:nth-child(3) .step-number {
    color: rgba(255, 215, 0, 0.3);
}

.step-content {
    position: relative;
    z-index: 2;
}

.step-title {
    font-size: 1.8rem;
    font-weight: 900;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: -1px;
    line-height: 1.2;
}

.step-description {
    font-size: 1rem;
    line-height: 1.6;
    opacity: 0.8;
    margin-bottom: 25px;
}

.step-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: 0.3s ease;
}

.step-card:nth-child(1) .step-link,
.step-card:nth-child(4) .step-link {
    color: #000;
}

.step-card:nth-child(2) .step-link,
.step-card:nth-child(3) .step-link {
    color: #FFD700;
}

.step-link:hover {
    transform: translateX(5px);
}

.step-link::after {
    content: "→";
    font-size: 1.2rem;
    transition: 0.3s ease;
}

.step-link:hover::after {
    transform: translateX(3px);
}

/* ========================
   SERVICES SECTION - CONSTRUCTION STYLE
======================== */
.services-section {
    padding: 120px 5%;
    background: var(--surface-alt);
    width: 100%;
}

.services-header {
    text-align: center;
    margin-bottom: 80px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.services-badge {
    display: inline-block;
    background: transparent;
    color: var(--accent);
    padding: 0;
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-left: 4px solid var(--accent);
    padding-left: 15px;
}

.services-title {
    font-size: clamp(2rem, 6vw, 3rem);
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: -1px;
}

.services-description {
    color: var(--text-secondary);
    font-size: clamp(1rem, 2.5vw, 1.1rem);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    align-items: stretch;
}

.service-card {
    background: var(--surface);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 2px solid var(--border);
    transition: 0.4s ease;
    animation: slideInUp 0.8s ease both;
    position: relative;
    display: flex;
    flex-direction: column;
}

.service-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 0%, rgba(255, 215, 0, 0.1) 100%);
    opacity: 0;
    transition: 0.4s ease;
}

.service-card:hover::before {
    opacity: 1;
}

.service-card:nth-child(1) { animation-delay: 0.1s; }
.service-card:nth-child(2) { animation-delay: 0.2s; }
.service-card:nth-child(3) { animation-delay: 0.3s; }

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent);
}

.service-image {
    width: 100%;
    height: 200px;
    min-height: 200px;
    flex-shrink: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    transition: 0.4s ease;
}

.service-image::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
}

.service-card:hover .service-image {
    transform: scale(1.05);
}

.quarry-extraction {
    background-image: url("https://images.pexels.com/photos/31925745/pexels-photo-31925745.jpeg");
}

.material-processing {
    background-image: url("https://images.pexels.com/photos/4946889/pexels-photo-4946889.jpeg");
}

.bulk-delivery {
    background-image: url("https://images.pexels.com/photos/29174547/pexels-photo-29174547.jpeg");
}

.service-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.service-title {
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 18px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.service-description {
    color: var(--text-secondary);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 0;
}

.service-link {
    color: var(--accent);
    text-decoration: none;
    font-weight: 900;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: 0.3s ease;
    display: inline-block;
    margin-top: 20px;
}

.service-link:hover {
    color: var(--hover-secondary);
    transform: translateX(5px);
}

/* ========================
   RESPONSIVE DESIGN
======================== */
@media (max-width: 1200px) {
    .features-container { 
        grid-template-columns: 1fr; 
        gap: 50px; 
    }
    
    .steps-grid { 
        grid-template-columns: repeat(2, 1fr); 
    }
}

@media (max-width: 768px) {
    .hero { 
        padding: 0 20px; 
        min-height: 70vh;
    }
    
    .hero-truck { 
        display: none; 
    }
    
    .partners-section,
    .features-section,
    .products-section,
    .services-section,
    .how-it-works-section { 
        padding: 60px 20px; 
    }
    
    .partners-grid { 
        flex-direction: column;
        gap: 20px;
    }
    
    .partner-logo {
        min-width: auto;
    }
    
    .steps-grid { 
        grid-template-columns: 1fr; 
    }
    
    .step-card { 
        min-height: 250px; 
    }
    
    .products-grid,
    .services-grid { 
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .hero { 
        padding: 0 15px; 
        min-height: 60vh;
    }
    
    .partners-section,
    .features-section,
    .products-section,
    .services-section,
    .how-it-works-section { 
        padding: 40px 15px; 
    }
    
    .products-grid,
    .services-grid { 
        grid-template-columns: 1fr; 
        gap: 15px;
    }
    
    .step-card { 
        min-height: 200px; 
    }
    
    .hero-cta {
        padding: 15px 25px;
        font-size: 0.9rem;
    }
    
    .features-cta {
        padding: 14px 28px;
        font-size: 0.9rem;
    }
}

/* Prevent horizontal scroll on all screen sizes */
@media (max-width: 320px) {
    .hero,
    .partners-section,
    .features-section,
    .products-section,
    .services-section,
    .how-it-works-section {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .hero-title {
        font-size: 1.8rem;
        letter-spacing: -1px;
    }
    
    .products-grid,
    .services-grid {
        gap: 10px;
    }
}
</style>

<!-- ========================
     HERO SECTION
======================== -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">QUARRY MATERIALS<br><span class="highlight">DELIVERED</span></h1>
        <p class="hero-subtitle">Premium stone, sand, and gravel delivered directly to your construction site. Order online and experience reliable quarry materials delivery with professional logistics and on-time service.</p>
        <a href="?controller=auth&action=index" class="hero-cta">ORDER NOW →</a>
    </div>
    <div class="hero-truck"></div>
</section>

<!-- ========================
     PARTNERS SECTION
======================== -->
<section class="partners-section">
    <div class="partners-grid">
        <div class="partner-logo">Stone Quarry Co</div>
        <div class="partner-logo">Aggregate Supply</div>
        <div class="partner-logo">Rock & Sand Ltd</div>
        <div class="partner-logo">Quarry Materials Inc</div>
        <div class="partner-logo">Mining Solutions</div>
    </div>
</section>

<!-- ========================
     FEATURES SECTION
======================== -->
<section class="features-section">
    <div class="features-container">
        <div class="features-content">
            <div class="features-badge">Services</div>
            <h2 class="features-title">We'll keep your items damage free</h2>
            <p class="features-description">Logistic delivery service ensures that knowledge & experience in construction and stone delivery. We deliver materials safely from quarry to your hardware store with professional handling and technology intelligence.</p>
            

            
            <a href="?controller=page&action=about" class="features-cta">Discover →</a>
        </div>
        
        <div class="features-visual">
            <div class="features-image">
                <img src="https://images.pexels.com/photos/12201830/pexels-photo-12201830.jpeg" alt="Construction Materials and Equipment" class="construction-image">
            </div>
        </div>
    </div>
</section>

<!-- ========================
     PRODUCTS SECTION
======================== -->
<section class="products-section">
    <div class="products-header">
        <div class="products-badge">Our Products</div>
        <h2 class="products-title">Premium Quarry Materials</h2>
        <p class="products-description">High-quality stone, sand, and gravel extracted from our quarry operations. Perfect for construction, landscaping, and infrastructure projects.</p>
    </div>
    
    <div class="products-grid">
        <div class="product-item">
            <div class="product-image">
                <img src="https://images.pexels.com/photos/12044663/pexels-photo-12044663.jpeg" alt="Crushed Stone" class="product-img">
                <div class="product-overlay">
                    <h3 class="product-name">Crushed Stone</h3>
                </div>
            </div>
        </div>
        <div class="product-item">
            <div class="product-image">
                <img src="https://images.pexels.com/photos/13838908/pexels-photo-13838908.png" alt="Construction Gravel" class="product-img">
                <div class="product-overlay">
                    <h3 class="product-name">Construction Gravel</h3>
                </div>
            </div>
        </div>
        <div class="product-item">
            <div class="product-image">
                <img src="https://images.pexels.com/photos/27523355/pexels-photo-27523355.jpeg" alt="Fine Sand" class="product-img">
                <div class="product-overlay">
                    <h3 class="product-name">Fine Sand</h3>
                </div>
            </div>
        </div>
        <div class="product-item">
            <div class="product-image">
                <img src="https://images.pexels.com/photos/17320030/pexels-photo-17320030.jpeg" alt="Dakal-Dakal" class="product-img">
                <div class="product-overlay">
                    <h3 class="product-name">Dakal-Dakal</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================
     HOW IT WORKS SECTION
======================== -->
<section class="how-it-works-section">
    <div class="how-it-works-content">
        <div class="how-it-works-header">
            <div class="how-it-works-badge">OUR PROCESS</div>
            <h2 class="how-it-works-title">WE BUILD<br>YOUR SUPPLY</h2>
            <p class="how-it-works-description">Transforming material delivery into seamless reality through precision engineering, innovative solutions, and unwavering commitment to excellence.</p>
        </div>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3 class="step-title">CREATE ACCOUNT</h3>
                    <p class="step-description">Register for free and access our full product catalog instantly with comprehensive material specifications.</p>
                    <a href="?controller=auth&action=index" class="step-link">GET STARTED</a>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3 class="step-title">BROWSE PRODUCTS</h3>
                    <p class="step-description">Explore our wide range of sand, stone, and gravel products with detailed specifications and pricing.</p>
                    <a href="?controller=materials&action=index" class="step-link">EXPLORE</a>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3 class="step-title">PLACE ORDER</h3>
                    <p class="step-description">Add items to your cart and submit your order with precise delivery details and scheduling.</p>
                    <a href="?controller=dashboard&action=shop" class="step-link">ORDER NOW</a>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3 class="step-title">FAST DELIVERY</h3>
                    <p class="step-description">We deliver directly to your project site on schedule, every time with professional logistics.</p>
                    <a href="?controller=page&action=contact" class="step-link">CONTACT US</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================
     SERVICES SECTION
======================== -->
<section class="services-section">
    <div class="services-header">
        <div class="services-badge">What We Offer</div>
        <h2 class="services-title">Comprehensive Quarry Operations</h2>
        <p class="services-description">From extraction to delivery, we provide complete quarry services for construction materials. Our modern facilities and experienced team ensure premium quality stone, sand, and gravel for all your project needs.</p>
    </div>
    
    <div class="services-grid">
        <div class="service-card">
            <div class="service-image quarry-extraction"></div>
            <div class="service-content">
                <div>
                    <h3 class="service-title">Quarry Extraction</h3>
                    <p class="service-description">Professionala stone, sand, and gravel extraction using modern equipment and sustainable mining practices for premium quality materials.</p>
                </div>
            </div>
        </div>
        
        <div class="service-card">
            <div class="service-image material-processing"></div>
            <div class="service-content">
                <div>
                    <h3 class="service-title">Material Processing</h3>
                    <p class="service-description">Advanced crushing, screening, and washing facilities to produce construction-grade materials that meet industry specifications.</p>
                </div>
            </div>
        </div>
        
        <div class="service-card">
            <div class="service-image bulk-delivery"></div>
            <div class="service-content">
                <div>
                    <h3 class="service-title">Bulk Supply & Delivery</h3>
                    <p class="service-description">Reliable bulk material supply with efficient logistics and on-time delivery to construction sites and hardware stores.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<style>
.site-footer {
    background: var(--primary);
    padding: 28px 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    color: var(--text-light);
    font-weight: 700;
    flex-wrap: wrap;
    gap: 12px;
}
.site-footer .footer-brand {
    font-weight: 900;
    color: var(--text-light);
}
@media (max-width: 1100px) {
    .site-footer { padding: 24px 40px; }
}
@media (max-width: 600px) {
    .site-footer { flex-direction: column; gap: 8px; text-align: center; padding: 20px; }
}
</style>
<footer class="site-footer">
    <span class="footer-brand">TerraForge</span>
    <span>© 2026 All Rights Reserved</span>
    <span>Built for strong foundations</span>
</footer>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>