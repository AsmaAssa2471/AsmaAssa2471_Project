<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Verdant Tech Farms';
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/AsmaAssa2471_Project/');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#064e3b">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES); ?> - Verdant Tech Farms</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom brand styles -->
  <style>
    :root {
      --vt-emerald: #008060; /* primary emerald */
      --vt-emerald-dark: #046a4b;
      --vt-slate: #111827; /* slate dark */
      --vt-accent: #f5f7f6;
      --vt-radius: .5rem;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    }
    body { background: #ffffff; color: var(--vt-slate); font-family: 'Inter', sans-serif; }
    .brand { font-family: 'Poppins', sans-serif; font-weight:700; color: var(--vt-emerald); }
    .navbar-custom { background: linear-gradient(180deg, #ffffff, var(--vt-accent)); }
    .nav-link { color: rgba(17,24,39,.85) !important; }
    .btn-emerald { background: var(--vt-emerald); color: #fff; border: 1px solid var(--vt-emerald-dark); }
    .btn-emerald:hover { background: var(--vt-emerald-dark); color: #fff; }
    .admin-navbar {
      background: #1e293b;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
    }
    .admin-navbar .nav-link {
      color: rgba(255,255,255,.85);
      margin-right: 0.5rem;
    }
    .admin-navbar .nav-link.active,
    .admin-navbar .nav-link:hover {
      color: #ffffff;
    }
    .admin-navbar .btn-outline-light {
      border-color: rgba(255,255,255,.35);
    }
    .admin-navbar .btn-outline-light.active,
    .admin-navbar .btn-outline-light:hover {
      background-color: rgba(255,255,255,.12);
      color: #ffffff;
    }
    footer.site-footer { background: #0f1724; color: #cbd5e1; padding: 2rem 0; }
    .footer-link { color: #e6eef0; text-decoration: none; }
    .container-main { padding-top: 1.25rem; padding-bottom: 1.25rem; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>index.php">
      <span class="brand">Verdant Tech Farms</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>contact.php">Contact</a></li>
        <li class="nav-item ms-3">
          <a class="btn btn-emerald" href="<?= BASE_URL ?>admin/" role="button">Admin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container container-main">
<!-- Page content starts here -->
