<?php require_once BASE_PATH . '/app/core/Flash.php'; ?>
<?php require_once BASE_PATH . '/app/core/Csrf.php'; ?>
<?php $isLoggedIn = isset($_SESSION['user']); ?>
<?php $user = $_SESSION['user'] ?? null; ?>
<?php $currentPage = ($_GET['controller'] ?? '') . '/' . ($_GET['action'] ?? ''); ?>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TerraForge</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  
  <!-- Preconnect to CDN for faster DNS resolution -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="preconnect" href="https://images.pexels.com">
  <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

  <style>
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
      
      /* Layout Variables */
      --navbar-height: 60px;
      --sidebar-width: 280px;
      --sidebar-width-mobile: 100vw;
      --content-padding: clamp(1rem, 3vw, 2rem);
      --border-radius: 0.5rem;
      --transition-speed: 0.3s;
    }

    /* ========================
       BASE - MODERN RESET
    ======================== */
    *, *::before, *::after { 
      box-sizing: border-box; 
      margin: 0;
      padding: 0;
    }

    html {
      font-size: 16px;
      scroll-behavior: smooth;
      overflow-x: hidden;
      width: 100%;
      max-width: 100vw;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--background);
      color: var(--text-primary);
      line-height: 1.6;
      overflow-x: hidden;
      width: 100%;
      max-width: 100vw;
    }

    /* ========================
       MAIN LAYOUT GRID
    ======================== */
    .app-layout {
      display: block;
      min-height: 100vh;
      padding-top: var(--navbar-height);
    }

    .app-layout.guest {
      display: block;
      padding-top: var(--navbar-height);
      min-height: 100vh;
    }

    .app-layout.guest .content-area {
      padding: 0;
      min-height: calc(100vh - var(--navbar-height));
    }

    .app-layout.sidebar-hidden .content-area {
      margin-left: 0;
    }

    /* ========================
       NAVBAR - FLEXIBLE DESIGN
    ======================== */
    .navbar {
      grid-area: navbar;
      background: var(--primary);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 0 var(--content-padding);
      display: flex;
      align-items: center;
      justify-content: flex-start;
      height: var(--navbar-height);
      box-shadow: var(--shadow-md);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      gap: 1rem;
    }

    .navbar .brand {
      display: flex;
      align-items: center;
      gap: 0.625rem;
      text-decoration: none;
      color: var(--text-primary);
      font-weight: 900;
      font-size: clamp(1rem, 2.5vw, 1.4rem);
      letter-spacing: 0.125rem;
      text-transform: uppercase;
      transition: color var(--transition-speed) ease;
      order: 1;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .navbar .brand span {
      flex-shrink: 0;
    }

    .navbar .brand:hover {
      color: var(--accent);
    }

    .navbar .brand .brand-icon {
      width: clamp(2rem, 5vw, 2.5rem);
      height: clamp(2rem, 5vw, 2.5rem);
      background: var(--accent);
      border-radius: var(--border-radius);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: clamp(0.875rem, 2vw, 1.2rem);
      color: var(--primary);
      font-weight: 900;
      box-shadow: var(--shadow-sm);
    }

    .navbar .brand span.highlight {
      color: var(--accent);
    }

    .navbar .brand .brand-logo {
      width: 2.5rem;
      height: 2.5rem;
      object-fit: contain;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
      transition: transform var(--transition-speed) ease;
      flex-shrink: 0;
      vertical-align: middle;
    }

    .navbar .brand:hover .brand-logo {
      transform: scale(1.1);
    }

    .navbar .nav-links {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 0.5rem;
      list-style: none;
      order: 2;
      flex: 0;
      margin: 0;
      padding: 0;
    }

    .navbar .nav-links a {
      text-decoration: none;
      color: var(--text-primary);
      font-size: clamp(0.8rem, 1.8vw, 0.9rem);
      font-weight: 700;
      padding: 0.75rem 1.25rem;
      border-radius: var(--border-radius);
      transition: all var(--transition-speed) ease;
      letter-spacing: 0.0625rem;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .navbar .nav-links a:hover {
      color: var(--accent);
      background: transparent;
      transform: translateY(-0.125rem);
    }

    .navbar .nav-links a.active {
      color: var(--text-primary);
      background: transparent;
    }

    .navbar .nav-right {
      display: flex;
      align-items: center;
      gap: 0.625rem;
      order: 3;
      flex-shrink: 0;
      margin-left: auto;
    }

    .navbar .btn-login {
      padding: 0.75rem 1.75rem;
      background: var(--accent);
      color: var(--primary);
      border: none;
      border-radius: var(--border-radius);
      font-weight: 900;
      font-size: clamp(0.8rem, 1.8vw, 0.9rem);
      text-decoration: none;
      transition: all var(--transition-speed) ease;
      letter-spacing: 0.0625rem;
      text-transform: uppercase;
      box-shadow: var(--shadow-sm);
      white-space: nowrap;
    }

    .navbar .btn-login:hover {
      background: var(--hover-secondary);
      color: var(--primary);
      transform: translateY(-0.1875rem) scale(1.05);
      box-shadow: var(--shadow-md);
    }

    /* Mobile hamburger menu */
    .navbar .hamburger {
      display: none;
      background: var(--accent);
      border: 2px solid var(--accent);
      color: var(--primary);
      font-size: 1.5rem;
      cursor: pointer;
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      transition: all var(--transition-speed) ease;
      font-weight: 900;
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
      order: 3;
      flex-shrink: 0;
      margin-left: auto;
    }

    .navbar .hamburger:hover {
      background: var(--hover-secondary);
      border-color: var(--hover-secondary);
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(255, 215, 0, 0.5);
    }

    .navbar .hamburger:active {
      transform: translateY(0) scale(0.98);
    }

    .navbar .mobile-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: rgba(10, 10, 10, 0.97);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.07);
      padding: 1rem 1.5rem;
      flex-direction: column;
      gap: 0.25rem;
      z-index: 999;
    }

    .navbar .mobile-menu.open {
      display: flex;
    }

    .navbar .mobile-menu a {
      text-decoration: none;
      color: rgba(255, 255, 255, 0.8);
      padding: 0.75rem 1rem;
      border-radius: var(--border-radius);
      font-size: 0.95rem;
      transition: all var(--transition-speed) ease;
    }

    .navbar .mobile-menu a:hover,
    .navbar .mobile-menu a.active {
      background: rgba(255, 255, 255, 0.07);
      color: var(--accent);
    }

    /* ========================
       SIDEBAR - FLEXIBLE GRID AREA
    ======================== */
    .sidebar {
      grid-area: sidebar;
      background: var(--surface);
      padding: 1rem;
      overflow-y: auto;
      overflow-x: hidden;
      border-right: 1px solid var(--border);
      box-shadow: inset -4px 0 12px rgba(0, 0, 0, 0.3);
      transition: transform var(--transition-speed) ease;
      display: flex;
      flex-direction: column;
      height: calc(100vh - var(--navbar-height));
      position: sticky;
      top: var(--navbar-height);
      align-self: flex-start;
      scrollbar-width: none; /* Firefox */
    }

    .sidebar::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Edge */
    }

    /* Hamburger button for sidebar */
    .sidebar-hamburger {
      display: none;
      background: var(--accent);
      border: 2px solid var(--accent);
      color: var(--primary);
      font-size: 1.3rem;
      cursor: pointer;
      padding: 0.6rem 0.75rem;
      position: fixed;
      top: 0.75rem;
      left: 0.75rem;
      z-index: 1001;
      border-radius: 8px;
      transition: all var(--transition-speed) ease;
      box-shadow: 0 4px 16px rgba(255, 215, 0, 0.4);
      font-weight: 900;
    }

    .sidebar-hamburger:hover {
      background: var(--hover-secondary);
      border-color: var(--hover-secondary);
      transform: translateY(-2px) scale(1.08);
      box-shadow: 0 6px 20px rgba(255, 215, 0, 0.6);
    }

    .sidebar-hamburger:active {
      transform: translateY(0) scale(0.98);
    }
      transform: translateY(-0.125rem) scale(1.05);
      box-shadow: var(--shadow-lg);
    }

    /* Mobile sidebar overlay */
    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.8);
      z-index: 998;
      top: var(--navbar-height);
      backdrop-filter: blur(4px);
    }

    .sidebar-overlay.open {
      display: block;
    }

    .sidebar .sidebar-brand {
      text-align: center;
      margin-bottom: 0.5rem;
      flex-shrink: 0;
    }

    .sidebar .sidebar-brand h5 {
      font-weight: 900;
      font-size: 0.9rem;
      color: var(--text-primary);
      margin: 0;
      letter-spacing: 0.125rem;
      text-transform: uppercase;
    }

    /* Sidebar menu toggle button */
    .sidebar-menu-toggle {
      background: var(--accent);
      border: 2px solid var(--accent);
      color: var(--primary);
      border-radius: 8px;
      padding: 0.6rem 0.75rem;
      font-size: 1rem;
      cursor: pointer;
      transition: all var(--transition-speed) ease;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      margin-bottom: 0.5rem;
      font-weight: 900;
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }

    .sidebar-menu-toggle:hover {
      background: var(--hover-secondary);
      border-color: var(--hover-secondary);
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(255, 215, 0, 0.5);
    }

    .sidebar-menu-toggle:active {
      transform: translateY(0) scale(0.98);
    }

    .sidebar .user-info {
      text-align: center;
      padding: 0.5rem;
      margin-bottom: 0.375rem;
      background: rgba(255, 255, 255, 0.05);
      border-radius: var(--border-radius);
      border: 1px solid rgba(255, 255, 255, 0.1);
      flex-shrink: 0;
    }

    .sidebar .user-info .avatar {
      width: 2.25rem;
      height: 2.25rem;
      background: var(--border);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      margin: 0 auto 0.375rem;
      color: var(--text-primary);
      font-weight: 900;
      box-shadow: var(--shadow-sm);
      transition: transform var(--transition-speed) ease;
    }

    .sidebar .user-info .avatar:hover {
      transform: scale(1.05);
      box-shadow: var(--shadow-md);
    }

    .sidebar .user-info p {
      margin: 0 0 0.125rem;
      font-size: 0.8rem;
      font-weight: 900;
      color: var(--text-primary);
      text-transform: uppercase;
      letter-spacing: 0.03125rem;
    }

    .sidebar .user-info small {
      color: rgba(255, 255, 255, 0.5);
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
    }

    .sidebar hr {
      border-color: rgba(255, 255, 255, 0.2);
      margin: 0.375rem 0;
      border-width: 1px;
    }

    .sidebar .nav-link {
      color: var(--text-primary);
      padding: 0.375rem 0.5rem;
      border-radius: 0.3125rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.75rem;
      transition: all var(--transition-speed) ease;
      margin-bottom: 0.125rem;
      font-weight: 700;
      min-height: 2rem;
      text-transform: uppercase;
      letter-spacing: 0.01875rem;
    }

    .sidebar .nav-link i {
      width: 1rem;
      text-align: center;
      font-size: 0.9rem;
      flex-shrink: 0;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      color: var(--text-primary);
      transform: translateX(0.5rem);
    }

    .sidebar .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: var(--text-primary);
      border-left: 4px solid var(--border);
      font-weight: 900;
    }

    .sidebar .nav-link.logout-link {
      background: rgba(220, 53, 69, 0.1);
      border: 1px solid rgba(220, 53, 69, 0.3);
      color: #ff6b6b;
      font-weight: 900;
      margin-top: 0.125rem;
    }

    .sidebar .nav-link.logout-link:hover {
      background: rgba(220, 53, 69, 0.2);
      color: #ff5252;
      transform: translateX(0.25rem);
      border-color: rgba(220, 53, 69, 0.5);
    }

    .sidebar .nav-container {
      flex: 1;
      overflow-y: auto;
      margin: 0.125rem 0;
      padding-right: 0.25rem;
      min-height: 0;
      scrollbar-width: none;
    }

    .sidebar .nav-container::-webkit-scrollbar {
      display: none;
    }

    .sidebar .sidebar-footer {
      margin-top: auto;
      padding-top: 0.25rem;
      flex-shrink: 0;
    }

    .sidebar .section-label {
      font-size: 0.55rem;
      text-transform: uppercase;
      letter-spacing: 0.09375rem;
      color: rgba(255, 255, 255, 0.6);
      padding: 0.25rem 0.5rem 0.125rem;
      font-weight: 900;
      margin-top: 0.125rem;
    }

    /* Cart badge enhancement */
    .cart-badge {
      background: var(--border);
      color: var(--text-primary);
      border-radius: 50%;
      width: 1.5rem;
      height: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      font-weight: 900;
      margin-left: auto;
      animation: pulse 2s infinite;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }

    /* ========================
       CONTENT AREA
    ======================== */
    .content-area {
      padding: var(--content-padding);
      min-height: calc(100vh - var(--navbar-height));
      background: var(--background);
      overflow-x: auto;
    }

    /* ========================
       FLASH MESSAGES - MODERN POSITIONING
    ======================== */
    .flash-container {
      position: fixed;
      top: calc(var(--navbar-height) + 1.25rem);
      right: 1.25rem;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      max-width: min(23.75rem, 90vw);
    }

    .flash-container .alert {
      border-radius: var(--border-radius);
      font-size: 0.9rem;
      padding: 1rem 1.25rem;
      border: 2px solid;
      box-shadow: var(--shadow-md);
      animation: slideIn 0.4s ease;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.03125rem;
    }

    .flash-container .alert-success {
      background: rgba(255, 215, 0, 0.9);
      color: var(--primary);
      border-color: var(--accent);
    }

    .flash-container .alert-danger {
      background: rgba(220, 53, 69, 0.9);
      color: white;
      border-color: #dc3545;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(2.5rem); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* ========================
       RESPONSIVE DESIGN - MOBILE FIRST APPROACH
    ======================== */

    /* MOBILE DEVICES (up to 575px) */
    @media (max-width: 575px) {
      :root {
        --navbar-height: 56px;
        --sidebar-width-mobile: 100vw;
        --content-padding: 0.75rem;
      }

      .app-layout {
        grid-template-columns: 0 1fr;
      }

      .navbar {
        height: var(--navbar-height);
        padding: 0 0.75rem;
      }

      .navbar .brand {
        padding-right: 1rem;
        flex-shrink: 1;
        min-width: auto;
      }

      .navbar .brand span {
        display: inline;
        font-size: 0.9rem;
      }

      .navbar .nav-links,
      .navbar .nav-right {
        display: none;
      }

      .navbar .hamburger {
        display: block;
      }

      .sidebar {
        position: fixed;
        left: 0;
        top: var(--navbar-height);
        width: var(--sidebar-width-mobile);
        height: calc(100vh - var(--navbar-height));
        z-index: 999;
        transform: translateX(-100%);
        transition: transform var(--transition-speed) cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 1rem 0.75rem;
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .sidebar-hamburger {
        display: block;
        top: 0.5rem;
        left: 0.5rem;
        font-size: 1.2rem;
        padding: 0.375rem 0.5rem;
      }

      .app-layout:not(.guest) .navbar .brand {
        margin-left: 3.5rem;
      }

      .sidebar-overlay.open {
        display: block;
        top: var(--navbar-height);
      }

      .sidebar-menu-toggle {
        display: flex;
        padding: 0.625rem;
        margin-bottom: 0.75rem;
      }

      .content-area {
        padding: 0.75rem 0.5rem;
      }

      .flash-container {
        top: calc(var(--navbar-height) + 0.75rem);
        right: 0.75rem;
        left: 0.75rem;
        max-width: none;
      }
    }

    /* SMALL TABLETS (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
      :root {
        --navbar-height: 60px;
        --content-padding: 1rem;
      }

      .app-layout {
        grid-template-columns: 0 1fr;
      }

      .navbar .nav-links {
        gap: 0.125rem;
      }

      .navbar .nav-links a {
        padding: 0.375rem 0.625rem;
      }

      .navbar .btn-login {
        padding: 0.5rem 1rem;
      }

      .sidebar {
        position: fixed;
        left: 0;
        top: var(--navbar-height);
        width: 17.5rem;
        height: calc(100vh - var(--navbar-height));
        z-index: 999;
        transform: translateX(-100%);
        transition: transform var(--transition-speed) cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 1.125rem 0.875rem;
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .sidebar-hamburger {
        display: block;
        top: 0.5rem;
        left: 0.5rem;
      }

      .app-layout:not(.guest) .navbar .brand {
        margin-left: 3.5rem;
      }

      .sidebar-overlay.open {
        display: block;
        top: var(--navbar-height);
      }

      .sidebar-menu-toggle {
        display: flex;
        margin-bottom: 0.75rem;
      }

      .content-area {
        padding: 0.875rem 0.625rem;
      }
    }

    /* TABLETS (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
      :root {
        --navbar-height: 64px;
        --content-padding: 1.125rem;
      }

      .app-layout {
        grid-template-columns: 0 1fr;
      }

      .navbar {
        height: var(--navbar-height);
        padding: 0 1rem;
      }

      .navbar .hamburger {
        display: none;
      }

      .sidebar-hamburger {
        display: block;
        position: fixed;
        top: 0.75rem;
        left: 0.75rem;
        z-index: 1001;
      }

      .app-layout:not(.guest) .navbar .brand {
        margin-left: 3.5rem;
      }

      .sidebar {
        position: fixed;
        left: 0;
        top: var(--navbar-height);
        width: 17.5rem;
        height: calc(100vh - var(--navbar-height));
        z-index: 999;
        transform: translateX(-100%);
        transition: transform var(--transition-speed) cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 1.125rem 0.875rem;
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .sidebar-overlay {
        top: var(--navbar-height);
      }

      .sidebar-overlay.open {
        display: block;
      }

      .sidebar-menu-toggle {
        display: none;
      }

      .content-area {
        padding: 1.125rem 0.875rem;
      }
    }

    /* SMALL DESKTOPS (992px - 1199px) */
    @media (min-width: 992px) {
      :root {
        --navbar-height: 60px;
        --sidebar-width: 280px;
        --content-padding: 1.75rem 1.5rem;
      }

      .navbar {
        padding: 0 1.5rem;
      }

      .sidebar {
        position: fixed;
        top: var(--navbar-height);
        left: 0;
        width: var(--sidebar-width);
        height: calc(100vh - var(--navbar-height));
        z-index: 100;
        transform: translateX(0) !important;
        padding: 1rem;
        overflow-y: auto;
        overflow-x: hidden;
      }

      /* Only apply sidebar margin for logged-in layout */
      .app-layout:not(.guest) .content-area {
        margin-left: var(--sidebar-width);
        padding: var(--content-padding);
      }

      .sidebar-hamburger {
        display: none !important;
      }

      .sidebar-overlay {
        display: none !important;
      }

      .sidebar-menu-toggle {
        display: none !important;
      }
    }

    /* LARGE DESKTOPS (1200px and above) */
    @media (min-width: 1200px) {
      :root {
        --content-padding: 1.75rem 1.5rem;
      }

      .navbar {
        padding: 0 2rem;
      }

      .content-area {
        padding: var(--content-padding);
      }
    }

    /* EXTRA LARGE DESKTOPS (1400px and above) */
    @media (min-width: 1400px) {
      :root {
        --content-padding: 2rem 1.75rem;
      }

      .navbar {
        padding: 0 2.5rem;
      }

      .content-area {
        padding: var(--content-padding);
      }
    }

    /* TOUCH DEVICE OPTIMIZATIONS */
    @media (hover: none) and (pointer: coarse) {
      .sidebar .nav-link {
        min-height: 3rem;
        padding: 0.875rem;
      }

      .sidebar-hamburger {
        min-width: 2.75rem;
        min-height: 2.75rem;
      }

      .sidebar-menu-toggle {
        min-height: 3rem;
        padding: 0.75rem;
      }
    }

    /* HIGH DPI DISPLAYS */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
      .sidebar .user-info .avatar {
        box-shadow: 0 0.125rem 0.5rem rgba(250, 234, 177, 0.4);
      }

      .sidebar-hamburger {
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.3);
      }
    }

    /* LANDSCAPE ORIENTATION ON MOBILE */
    @media (max-width: 767px) and (orientation: landscape) {
      .sidebar {
        width: 17.5rem;
      }

      .sidebar .user-info {
        padding: 0.5rem;
        margin-bottom: 0.375rem;
      }

      .sidebar .user-info .avatar {
        width: 2.25rem;
        height: 2.25rem;
        margin-bottom: 0.25rem;
      }

      .sidebar .nav-link {
        padding: 0.5rem 0.75rem;
        min-height: 2.25rem;
      }

      .sidebar .section-label {
        padding: 0.375rem 0.75rem 0.125rem;
      }
    }
  /* Quarry Business Icons */
.quarry-icon {
    display: inline-block;
    width: 1em;
    height: 1em;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    vertical-align: -0.125em;
}

.quarry-icon.dashboard { background-image: url('/app/public/assets/imgs/quarry-icons/dashboard.svg'); }
.quarry-icon.orders { background-image: url('/app/public/assets/imgs/quarry-icons/orders.svg'); }
.quarry-icon.materials { background-image: url('/app/public/assets/imgs/quarry-icons/materials.svg'); }
.quarry-icon.cart { background-image: url('/app/public/assets/imgs/quarry-icons/cart.svg'); }
.quarry-icon.settings { background-image: url('/app/public/assets/imgs/quarry-icons/settings.svg'); }
.quarry-icon.users { background-image: url('/app/public/assets/imgs/quarry-icons/users.svg'); }
.quarry-icon.sales { background-image: url('/app/public/assets/imgs/quarry-icons/sales.svg'); }
.quarry-icon.calendar { background-image: url('/app/public/assets/imgs/quarry-icons/calendar.svg'); }
.quarry-icon.login { background-image: url('/app/public/assets/imgs/quarry-icons/login.svg'); }
.quarry-icon.logout { background-image: url('/app/public/assets/imgs/quarry-icons/logout.svg'); }
.quarry-icon.add-to-cart { background-image: url('/app/public/assets/imgs/quarry-icons/add-to-cart.svg'); }
.quarry-icon.receipt { background-image: url('/app/public/assets/imgs/quarry-icons/receipt.svg'); }

/* Size variations */
.quarry-icon.lg { width: 1.5em; height: 1.5em; }
.quarry-icon.xl { width: 2em; height: 2em; }

</style>

<style>
  /* Prevent flash of unstyled content */
  body { opacity: 0; transition: opacity 0.15s ease; }
  body.loaded { opacity: 1; }

  /* Top loading bar */
  #page-loader {
    position: fixed;
    top: 0; left: 0;
    height: 3px;
    width: 0%;
    background: var(--accent, #FFD700);
    z-index: 99999;
    transition: width 0.3s ease;
    box-shadow: 0 0 8px rgba(255, 215, 0, 0.6);
  }
</style>
</head>

<body>
<div id="page-loader"></div>
<script>
  // Show loader on page load
  const loader = document.getElementById('page-loader');

  // Animate to 80% quickly on start
  loader.style.width = '80%';

  document.addEventListener('DOMContentLoaded', function() {
    // Complete the bar then fade out
    loader.style.width = '100%';
    setTimeout(() => {
      loader.style.opacity = '0';
      loader.style.transition = 'opacity 0.3s ease';
    }, 200);
    document.body.classList.add('loaded');
  });

  // Show loader on link clicks
  document.addEventListener('click', function(e) {
    const link = e.target.closest('a[href]');
    if (link && !link.href.startsWith('#') && !link.target && link.href !== window.location.href) {
      loader.style.transition = 'width 0.3s ease';
      loader.style.opacity = '1';
      loader.style.width = '70%';
    }
  });
</script>

<?php if (!$isLoggedIn): ?>

<!-- ========================
     GUEST LAYOUT
======================== -->
<div class="app-layout guest">
  <!-- NAVBAR -->
  <nav class="navbar" id="guestNav">
    <a href="?controller=page&action=home" class="brand">
      <img src="assets/imgs/logo.svg" alt="TerraForge Logo" class="brand-logo">
      <span>TERRAFORGE</span>
    </a>

    <ul class="nav-links">
      <li><a href="?controller=page&action=home"    class="<?= $currentPage === 'page/home'    ? 'active' : '' ?>">Home</a></li>
      <li><a href="?controller=page&action=about"   class="<?= $currentPage === 'page/about'   ? 'active' : '' ?>">About</a></li>
      <li><a href="?controller=page&action=contact" class="<?= $currentPage === 'page/contact' ? 'active' : '' ?>">Contact</a></li>
    </ul>

    <div class="nav-right">
      <a href="?controller=auth&action=index" class="btn-login">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </a>
    </div>

    <button class="hamburger" onclick="toggleMenu()" aria-label="Toggle menu">
      <i class="bi bi-list" id="hamburgerIcon"></i>
    </button>

    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobileMenu">
      <a href="?controller=page&action=home"    class="<?= $currentPage === 'page/home'    ? 'active' : '' ?>"><i class="bi bi-house-fill"></i> Home</a>
      <a href="?controller=page&action=about"   class="<?= $currentPage === 'page/about'   ? 'active' : '' ?>"><i class="bi bi-info-circle-fill"></i> About</a>
      <a href="?controller=page&action=contact" class="<?= $currentPage === 'page/contact' ? 'active' : '' ?>"><i class="bi bi-telephone-fill"></i> Contact</a>
      <a href="?controller=auth&action=index"><i class="bi bi-box-arrow-in-right"></i> Login</a>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="content-area">
    <?= $content ?>
  </div>
</div>

<?php else: ?>

<!-- ========================
     LOGGED-IN LAYOUT
======================== -->
<div class="app-layout">
  <!-- NAVBAR -->
  <nav class="navbar">
    <button class="sidebar-hamburger" onclick="toggleAdminMenu()" aria-label="Toggle admin menu">
      <i class="bi bi-list" id="adminHamburgerIcon"></i>
    </button>
    
    <a href="?controller=dashboard&action=index" class="brand">
      <img src="assets/imgs/logo.svg" alt="TerraForge Logo" class="brand-logo">
      <span>TerraForge</span>
    </a>
  </nav>

  <!-- SIDEBAR OVERLAY (Mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleAdminMenu()"></div>

  <!-- SIDEBAR -->
  <div class="sidebar" id="adminSidebar">
    <div class="sidebar-brand">
      <button class="sidebar-menu-toggle" onclick="toggleAdminMenu()" aria-label="Close menu" title="Close menu">
        <i class="bi bi-list" id="sidebarMenuIcon"></i>
        <span id="sidebarMenuLabel" style="font-size:0.75rem; margin-left:6px; font-weight:700;">Menu</span>
      </button>
    </div>

    <div class="user-info">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <p><?= htmlspecialchars($user['name'] ?? 'User') ?></p>
      <small style="color:rgba(255,255,255,0.4); font-size:0.78rem;">
        <?= !empty($user['is_admin']) ? '<i class="bi bi-patch-check-fill" style="color:var(--accent)"></i> Administrator' : 'Member' ?>
      </small>
    </div>

    <hr>

    <div class="nav-container">
      <?php if (empty($user['is_admin'])): ?>
      <!-- MAIN MENU - Only for regular users -->
      <div class="section-label">Main Menu</div>
      <ul class="nav flex-column">
        <li><a class="nav-link <?= $currentPage === 'dashboard/index' ? 'active' : '' ?>" href="?controller=dashboard&action=index"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a class="nav-link <?= $currentPage === 'dashboard/shop' ? 'active' : '' ?>" href="?controller=dashboard&action=shop"><i class="bi bi-bag"></i> Shop Materials</a></li>
        <li><a class="nav-link <?= $currentPage === 'dashboard/orders' ? 'active' : '' ?>" href="?controller=dashboard&action=orders"><i class="bi bi-box-seam"></i> My Orders</a></li>
        <li><a class="nav-link <?= $currentPage === 'dashboard/settings' ? 'active' : '' ?>" href="?controller=dashboard&action=settings"><i class="bi bi-gear"></i> Settings</a></li>
      </ul>

      <hr>

      <?php
      // Load cart count from DB for logged-in users so it's accurate after login
      $cartCount = 0;
      if (!empty($user['id'])) {
          try {
              require_once BASE_PATH . '/app/models/Material.php';
              $cartCount = (new Material())->getCartCount((int)$user['id']);
          } catch (Exception $e) {
              $cartCount = count($_SESSION['cart'] ?? []);
          }
      }
      ?>
      <a href="?controller=cart&action=index" class="nav-link" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:#ffffff;font-weight:700;justify-content:center;margin-bottom:12px;">
        <i class="bi bi-cart3"></i> My Cart
        <?php if ($cartCount > 0): ?>
        <span class="cart-badge">
          <?= $cartCount ?>
        </span>
        <?php endif; ?>
      </a>

      <hr>

      <!-- LOGOUT SECTION -->
      <div class="section-label">Account</div>
      <ul class="nav flex-column">
        <li><a class="nav-link logout-link" href="?controller=auth&action=logout" onclick="showLogoutModal(event)"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
      </ul>
      <?php endif; ?>

      <?php if (!empty($user['is_admin'])): ?>
      <!-- ADMIN PANEL - Only for admins -->
      <div class="section-label">Admin Menu</div>
      <ul class="nav flex-column">
        <li><a class="nav-link" href="?controller=admin&action=index"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a class="nav-link" href="?controller=admin&action=materials"><i class="bi bi-grid-3x3-gap"></i> Materials</a></li>
        <li><a class="nav-link" href="?controller=admin&action=stockManagement"><i class="bi bi-boxes"></i> Stock Management</a></li>
        <li><a class="nav-link" href="?controller=admin&action=orders"><i class="bi bi-box-seam"></i> Orders</a></li>
        <li><a class="nav-link" href="?controller=admin&action=sales"><i class="bi bi-graph-up"></i> Sales</a></li>
        <li><a class="nav-link" href="?controller=admin&action=users"><i class="bi bi-people"></i> Users</a></li>
        <li><a class="nav-link" href="?controller=admin&action=log"><i class="bi bi-clock-history"></i> Activity Log</a></li>
        <li><a class="nav-link" href="?controller=admin&action=calendar"><i class="bi bi-calendar3"></i> Calendar</a></li>
        <li><a class="nav-link" href="?controller=admin&action=settings"><i class="bi bi-gear"></i> Settings</a></li>
      </ul>

      <hr>

      <!-- LOGOUT SECTION -->
      <div class="section-label">Account</div>
      <ul class="nav flex-column">
        <li><a class="nav-link logout-link" href="?controller=auth&action=logout" onclick="showLogoutModal(event)"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
      </ul>
      <?php endif; ?>
    </div>

    <div class="sidebar-footer">
      <!-- Footer content removed since logout is now in the menu -->
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content-area">
    <?= $content ?>
  </div>
</div>

<?php endif; ?>

<!-- FLASH MESSAGES -->
<div class="flash-container">
  <?php foreach ((Flash::get('success') ?? []) as $msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endforeach; ?>
  <?php foreach ((Flash::get('error') ?? []) as $msg): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
  <?php endforeach; ?>
</div>

<script>
  // Auto-dismiss flash messages
  setTimeout(() => {
    document.querySelectorAll('.flash-container .alert').forEach(el => {
      el.style.transition = 'opacity 0.4s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 400);
    });
  }, 3500);

  // Mobile menu toggle (Guest navbar)
  function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const icon = document.getElementById('hamburgerIcon');
    menu.classList.toggle('open');
    icon.className = menu.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
  }

  // Admin sidebar toggle (Logged-in navbar)
  function toggleAdminMenu() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const navbarIcon = document.getElementById('adminHamburgerIcon');
    const sidebarIcon = document.getElementById('sidebarMenuIcon');
    const sidebarLabel = document.getElementById('sidebarMenuLabel');
    
    if (sidebar) {
      const isOpen = sidebar.classList.contains('open');
      
      if (isOpen) {
        // Close sidebar
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        if (navbarIcon) navbarIcon.className = 'bi bi-list';
        if (sidebarIcon) sidebarIcon.className = 'bi bi-list';
        if (sidebarLabel) sidebarLabel.textContent = 'Menu';
        
        // Remove focus trap
        document.body.style.overflow = '';
      } else {
        // Open sidebar
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('open');
        if (navbarIcon) navbarIcon.className = 'bi bi-x-lg';
        if (sidebarIcon) sidebarIcon.className = 'bi bi-x-lg';
        if (sidebarLabel) sidebarLabel.textContent = 'Close Menu';
        
        // Add focus trap for accessibility on mobile/tablet
        if (window.innerWidth < 992) {
          document.body.style.overflow = 'hidden';
          
          // Focus first nav link
          setTimeout(() => {
            const firstLink = sidebar.querySelector('.nav-link');
            if (firstLink) firstLink.focus();
          }, 300);
        }
      }
    }
  }

  // Keyboard navigation for accessibility
  document.addEventListener('keydown', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    
    // ESC key closes sidebar
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
      toggleAdminMenu();
    }
    
    // Tab navigation within sidebar when open on mobile/tablet
    if (sidebar && sidebar.classList.contains('open') && window.innerWidth < 992) {
      const focusableElements = sidebar.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
      const firstElement = focusableElements[0];
      const lastElement = focusableElements[focusableElements.length - 1];
      
      if (e.key === 'Tab') {
        if (e.shiftKey) {
          if (document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
          }
        } else {
          if (document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
          }
        }
      }
    }
  });

  // Handle window resize - close sidebar on desktop breakpoint
  window.addEventListener('resize', function() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth >= 992 && sidebar && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      if (overlay) overlay.classList.remove('open');
      document.body.style.overflow = '';
      
      // Reset icons
      const navbarIcon = document.getElementById('adminHamburgerIcon');
      const sidebarIcon = document.getElementById('sidebarMenuIcon');
      if (navbarIcon) navbarIcon.className = 'bi bi-list';
      if (sidebarIcon) sidebarIcon.className = 'bi bi-list';
    }
  });

  // Close mobile menu on outside click (Guest navbar)
  document.addEventListener('click', function(e) {
    const nav = document.getElementById('guestNav');
    if (nav && !nav.contains(e.target)) {
      const mobileMenu = document.getElementById('mobileMenu');
      if (mobileMenu) mobileMenu.classList.remove('open');
      const icon = document.getElementById('hamburgerIcon');
      if (icon) icon.className = 'bi bi-list';
    }
  });

  // Close admin sidebar when clicking on a link (Mobile/Tablet)
  document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    
    if (sidebar && sidebar.classList.contains('open') && window.innerWidth < 992) {
      // Close if clicking on a nav link
      if (e.target.closest('.nav-link')) {
        sidebar.classList.remove('open');
        const overlay = document.getElementById('sidebarOverlay');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
        
        // Reset both icons
        const navbarIcon = document.getElementById('adminHamburgerIcon');
        const sidebarIcon = document.getElementById('sidebarMenuIcon');
        if (navbarIcon) navbarIcon.className = 'bi bi-list';
        if (sidebarIcon) sidebarIcon.className = 'bi bi-list';
      }
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" defer></script>

<!-- LOGOUT CONFIRMATION MODAL -->
<div id="logoutModal" style="
  display:none; position:fixed; inset:0; z-index:99999;
  background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);
  align-items:center; justify-content:center;
" onclick="if(event.target===this) closeLogoutModal()">
  <div style="
    background:#1a1a1a; border:2px solid #FFD700; border-radius:16px;
    padding:32px 28px; width:90%; max-width:380px; text-align:center;
    animation:modalPop 0.2s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow:0 20px 60px rgba(0,0,0,0.8);
  ">
    <div style="width:56px;height:56px;background:rgba(239,68,68,0.15);border:2px solid rgba(239,68,68,0.4);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
      <i class="bi bi-box-arrow-right" style="font-size:1.5rem;color:#ef4444;"></i>
    </div>
    <h5 style="color:#ffffff;font-weight:900;margin:0 0 8px;font-size:1.1rem;">Sign Out</h5>
    <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;margin:0 0 24px;font-weight:600;">Are you sure you want to sign out of your account?</p>
    <div style="display:flex;gap:10px;">
      <button onclick="closeLogoutModal()" style="
        flex:1;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);
        color:#ffffff;padding:11px;border-radius:10px;font-weight:700;font-size:0.9rem;cursor:pointer;
        transition:0.2s ease;
      " onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
        Cancel
      </button>
      <a id="logoutConfirmBtn" href="?controller=auth&action=logout" style="
        flex:1;background:#ef4444;border:1px solid #dc2626;
        color:#ffffff;padding:11px;border-radius:10px;font-weight:700;font-size:0.9rem;cursor:pointer;
        transition:0.2s ease;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;
      " onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
        <i class="bi bi-box-arrow-right"></i> Sign Out
      </a>
    </div>
  </div>
</div>

<style>
@keyframes modalPop {
  from { opacity:0; transform:scale(0.88) translateY(16px); }
  to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
function showLogoutModal(e) {
  e.preventDefault();
  const modal = document.getElementById('logoutModal');
  modal.style.display = 'flex';
}
function closeLogoutModal() {
  document.getElementById('logoutModal').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeLogoutModal();
});
</script>

</body>
</html>
