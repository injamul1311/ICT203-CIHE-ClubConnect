<?php
require_once __DIR__.'/../includes/functions.php';require_admin();
$stmt=db()->query('SELECT l.*,u.name user_name FROM activity_logs l JOIN users u ON u.id=l.user_id ORDER BY l.created_at DESC LIMIT 100');$logs=$stmt->fetchAll();
$pageTitle='Audit Log';require __DIR__.'/../includes/header.php';
?>
<main id="main" class="container page"><section class="section-head"><div><span class="eyebrow">ADMINISTRATION</span><h1>Activity audit log</h1><p>Recent authenticated actions for accountability.</p></div></section>
<div class="table-wrap"><table><thead><tr><th>Time</th><th>User</th><th>Action</th><th>Entity</th><th>Record</th><th>Details</th></tr></thead><tbody>
<?php foreach($logs as $l): ?><tr><td><?= e($l['created_at']) ?></td><td><?= e($l['user_name']) ?></td><td><span class="badge"><?= e($l['action']) ?></span></td><td><?= e($l['entity_type']) ?></td><td><?= e((string)$l['entity_id']) ?></td><td><?= e($l['details']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></main>
<?php require __DIR__.'/../includes/footer.php'; ?>
