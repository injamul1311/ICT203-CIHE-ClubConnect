<?php
require_once __DIR__.'/../includes/functions.php'; require_login();
$id=(int)($_GET['id']??0);
$stmt=db()->prepare('SELECT e.*,u.name creator_name FROM events e JOIN users u ON u.id=e.created_by WHERE e.id=?');$stmt->execute([$id]);$ev=$stmt->fetch();
if(!$ev){http_response_code(404);$pageTitle='Not found';require __DIR__.'/../includes/header.php';echo '<main class="container page"><div class="empty">Event not found.</div></main>';require __DIR__.'/../includes/footer.php';exit;}
$pageTitle=$ev['title'];require __DIR__.'/../includes/header.php';$user=current_user();
?>
<main id="main" class="container page narrow">
<a class="back" href="index.php">← Back to events</a>
<article class="detail-card"><span class="tag"><?= e($ev['category']) ?></span><h1><?= e($ev['title']) ?></h1><div class="detail-meta"><span>🗓 <?= e(date('l, j F Y g:i A',strtotime($ev['event_date']))) ?></span><span>📍 <?= e($ev['location']) ?></span></div><p class="lead"><?= nl2br(e($ev['description'])) ?></p><hr><p class="muted">Created by <?= e($ev['creator_name']) ?> • Updated <?= e(date('j M Y g:i A',strtotime($ev['updated_at']))) ?></p>
<?php if($user['role']==='admin'): ?><div class="actions"><a class="btn secondary" href="edit.php?id=<?= $id ?>">Edit</a><form method="post" action="delete.php" onsubmit="return confirm('Delete this event?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>"><button class="btn danger" type="submit">Delete</button></form></div><?php endif; ?></article>
</main>
<?php require __DIR__.'/../includes/footer.php'; ?>
