<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) redirect('/CIHE_ClubConnect_Model/dashboard.php');
$pageTitle = 'Welcome';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
<section class="hero">
<div class="container hero-grid">
  <div>
    <span class="eyebrow">UNIVERSITY CLUB PLATFORM</span>
    <h1>One place for events, announcements and club support.</h1>
    <p>CIHE ClubConnect demonstrates a secure PHP/MySQL workflow with role-based access, CRUD, search, pagination, audit logging and a responsible Smart Help assistant.</p>
    <a class="btn primary" href="login.php">Open model application</a>
  </div>
  <div class="hero-card">
    <div class="stat"><strong>2</strong><span>User roles</span></div>
    <div class="stat"><strong>2</strong><span>CRUD modules</span></div>
    <div class="stat"><strong>1</strong><span>Smart assistant</span></div>
    <div class="stat"><strong>100%</strong><span>Local rule logic</span></div>
  </div>
</div>
</section>
<section class="container feature-grid">
<div class="card"><span class="icon">🔐</span><h2>Secure access</h2><p>Hashed passwords, sessions, role checks, CSRF protection and prepared statements.</p></div>
<div class="card"><span class="icon">📅</span><h2>Club workflow</h2><p>Manage events and announcements with validation, search, filters and pagination.</p></div>
<div class="card"><span class="icon">✨</span><h2>Smart Help</h2><p>Useful keyword-based assistance with transparent limitations and user control.</p></div>
</section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
