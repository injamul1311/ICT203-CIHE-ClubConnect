<?php
require_once __DIR__ . '/functions.php';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? APP_NAME) ?> | <?= e(APP_NAME) ?></title>
<link rel="stylesheet" href="/CIHE_ClubConnect_Model/assets/css/style.css">
<script defer src="/CIHE_ClubConnect_Model/assets/js/app.js"></script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="brand" href="/CIHE_ClubConnect_Model/index.php">CIHE <span>ClubConnect</span></a>
    <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">☰</button>
    <nav class="nav" aria-label="Main navigation">
      <?php if ($user): ?>
        <a href="/CIHE_ClubConnect_Model/dashboard.php">Dashboard</a>
        <a href="/CIHE_ClubConnect_Model/events/index.php">Events</a>
        <a href="/CIHE_ClubConnect_Model/announcements/index.php">Announcements</a>
        <a href="/CIHE_ClubConnect_Model/help.php">Smart Help</a>
        <?php if ($user['role'] === 'admin'): ?><a href="/CIHE_ClubConnect_Model/admin/logs.php">Audit Log</a><?php endif; ?>
        <form class="inline" method="post" action="/CIHE_ClubConnect_Model/logout.php">
          <?= csrf_field() ?><button class="link-button" type="submit">Logout</button>
        </form>
      <?php else: ?>
        <a href="/CIHE_ClubConnect_Model/login.php">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<?php if (!empty($_SESSION['flash'])): ?>
<div class="container flash-area" aria-live="polite">
<?php foreach ($_SESSION['flash'] as $f): ?>
<div class="alert <?= e($f['type']) ?>"><?= e($f['message']) ?></div>
<?php endforeach; unset($_SESSION['flash']); ?>
</div>
<?php endif; ?>
