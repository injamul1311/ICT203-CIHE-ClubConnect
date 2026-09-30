<?php
require_once __DIR__ . '/../includes/functions.php'; require_login();
$q=trim((string)($_GET['q']??'')); $category=trim((string)($_GET['category']??''));
$page=max(1,(int)($_GET['page']??1)); $perPage=6; $offset=($page-1)*$perPage;
$where=[];$params=[];
if($q!==''){ $where[]='(e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?)'; $like="%$q%"; array_push($params,$like,$like,$like); }
if(in_array($category,['Academic','Social','Sports','Career','Community'],true)){ $where[]='e.category=?'; $params[]=$category; }
$whereSql=$where?'WHERE '.implode(' AND ',$where):'';
$count=db()->prepare("SELECT COUNT(*) FROM events e $whereSql"); $count->execute($params); $total=(int)$count->fetchColumn();
$pages=max(1,(int)ceil($total/$perPage));
$stmt=db()->prepare("SELECT e.*,u.name creator_name FROM events e JOIN users u ON u.id=e.created_by $whereSql ORDER BY e.event_date ASC LIMIT $perPage OFFSET $offset");
$stmt->execute($params); $events=$stmt->fetchAll();
$pageTitle='Events'; require __DIR__.'/../includes/header.php'; $user=current_user();
?>
<main id="main" class="container page">
<section class="section-head"><div><span class="eyebrow">EVENTS</span><h1>Discover club activities</h1><p>Search, filter and browse upcoming or past events.</p></div><?php if($user['role']==='admin'): ?><a class="btn primary" href="create.php">+ New event</a><?php endif; ?></section>
<form class="filter-bar" method="get">
<label><span>Search</span><input name="q" value="<?= e($q) ?>" placeholder="Title, description or location"></label>
<label><span>Category</span><select name="category"><option value="">All categories</option><?php foreach(['Academic','Social','Sports','Career','Community'] as $c): ?><option <?= $category===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select></label>
<button class="btn secondary" type="submit">Apply</button><a class="btn ghost" href="index.php">Reset</a>
</form>
<p class="result-count"><?= $total ?> event<?= $total===1?'':'s' ?> found</p>
<div class="card-grid">
<?php if(!$events): ?><div class="empty">No events match your search.</div><?php endif; ?>
<?php foreach($events as $ev): ?><article class="card event-card"><span class="tag"><?= e($ev['category']) ?></span><h2><?= e($ev['title']) ?></h2><p><?= e(date('D, j M Y g:i A',strtotime($ev['event_date']))) ?></p><p>📍 <?= e($ev['location']) ?></p><p class="muted">Created by <?= e($ev['creator_name']) ?></p><a href="view.php?id=<?= (int)$ev['id'] ?>">View details →</a></article><?php endforeach; ?>
</div>
<?php if($pages>1): ?><nav class="pagination" aria-label="Event pages"><?php for($i=1;$i<=$pages;$i++): ?><a class="<?= $i===$page?'active':'' ?>" href="?q=<?= urlencode($q) ?>&category=<?= urlencode($category) ?>&page=<?= $i ?>"><?= $i ?></a><?php endfor; ?></nav><?php endif; ?>
</main>
<?php require __DIR__.'/../includes/footer.php'; ?>
