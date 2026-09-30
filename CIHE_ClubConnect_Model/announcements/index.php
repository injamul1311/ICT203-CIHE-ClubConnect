<?php
require_once __DIR__.'/../includes/functions.php';require_login();
$stmt=db()->query('SELECT a.*,u.name creator_name FROM announcements a JOIN users u ON u.id=a.created_by ORDER BY a.published_at DESC');$items=$stmt->fetchAll();
$pageTitle='Announcements';require __DIR__.'/../includes/header.php';$user=current_user();
?>
<main id="main" class="container page">
<section class="section-head"><div><span class="eyebrow">ANNOUNCEMENTS</span><h1>Club news</h1><p>Important updates for members.</p></div><?php if($user['role']==='admin'): ?><a class="btn primary" href="create.php">+ New announcement</a><?php endif; ?></section>
<div class="stack">
<?php if(!$items): ?><div class="empty">No announcements yet.</div><?php endif; ?>
<?php foreach($items as $a): ?><article class="announcement"><div><span class="tag">Update</span><h2><?= e($a['title']) ?></h2><p><?= nl2br(e($a['body'])) ?></p><small>Published <?= e(date('j M Y g:i A',strtotime($a['published_at']))) ?> by <?= e($a['creator_name']) ?></small></div>
<?php if($user['role']==='admin'): ?><div class="actions"><a class="btn ghost" href="edit.php?id=<?= (int)$a['id'] ?>">Edit</a><form method="post" action="delete.php" onsubmit="return confirm('Delete this announcement?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><button class="btn danger" type="submit">Delete</button></form></div><?php endif; ?></article><?php endforeach; ?>
</div></main>
<?php require __DIR__.'/../includes/footer.php'; ?>
