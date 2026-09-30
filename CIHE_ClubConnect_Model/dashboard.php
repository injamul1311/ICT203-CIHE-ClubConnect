<?php
require_once __DIR__ . '/includes/functions.php'; require_login();
$eventCount = (int)db()->query('SELECT COUNT(*) FROM events')->fetchColumn();
$announcementCount = (int)db()->query('SELECT COUNT(*) FROM announcements')->fetchColumn();
$upcoming = db()->query('SELECT id,title,event_date,location,category FROM events WHERE event_date >= NOW() ORDER BY event_date ASC LIMIT 4')->fetchAll();
$pageTitle='Dashboard'; require __DIR__ . '/includes/header.php'; $user=current_user();
?>
<main id="main" class="container page">
<div class="page-heading"><div><span class="eyebrow">DASHBOARD</span><h1>Hello, <?= e($user['name']) ?>.</h1><p>Your role: <span class="badge"><?= e(ucfirst($user['role'])) ?></span></p></div></div>
<div class="stats-grid">
<div class="metric"><span>Events</span><strong><?= $eventCount ?></strong><a href="events/index.php">Browse events →</a></div>
<div class="metric"><span>Announcements</span><strong><?= $announcementCount ?></strong><a href="announcements/index.php">View news →</a></div>
<div class="metric accent"><span>Smart Help</span><strong>24/7</strong><a href="help.php">Ask a question →</a></div>
</div>
<section class="section-head"><div><h2>Upcoming events</h2><p>Next activities across the club.</p></div><?php if($user['role']==='admin'): ?><a class="btn secondary" href="events/create.php">+ Create event</a><?php endif; ?></section>
<div class="card-grid">
<?php if(!$upcoming): ?><div class="empty">No upcoming events yet.</div><?php endif; ?>
<?php foreach($upcoming as $ev): ?><article class="card event-card"><span class="tag"><?= e($ev['category']) ?></span><h3><?= e($ev['title']) ?></h3><p><?= e(date('D, j M Y g:i A',strtotime($ev['event_date']))) ?></p><p>📍 <?= e($ev['location']) ?></p><a href="events/view.php?id=<?= (int)$ev['id'] ?>">View details →</a></article><?php endforeach; ?>
</div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
