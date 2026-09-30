<?php
require_once __DIR__.'/../includes/functions.php';require_admin();
$id=(int)($_GET['id']??0);$editing=$id>0;$errors=[];$data=['title'=>'','body'=>''];
if($editing){$s=db()->prepare('SELECT * FROM announcements WHERE id=?');$s->execute([$id]);$data=$s->fetch();if(!$data){http_response_code(404);exit('Announcement not found');}}
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$data=['title'=>trim((string)($_POST['title']??'')),'body'=>trim((string)($_POST['body']??''))];$errors=validate_announcement($data);if(!$errors){
if($editing){$s=db()->prepare('UPDATE announcements SET title=?,body=?,updated_by=? WHERE id=?');$s->execute([$data['title'],$data['body'],$_SESSION['user_id'],$id]);audit('UPDATE','announcement',$id,$data['title']);flash('success','Announcement updated.');}
else{$s=db()->prepare('INSERT INTO announcements(title,body,created_by,updated_by) VALUES(?,?,?,?)');$s->execute([$data['title'],$data['body'],$_SESSION['user_id'],$_SESSION['user_id']]);$id=(int)db()->lastInsertId();audit('CREATE','announcement',$id,$data['title']);flash('success','Announcement published.');}
redirect('/CIHE_ClubConnect_Model/announcements/index.php');}}
$pageTitle=$editing?'Edit Announcement':'Create Announcement';require __DIR__.'/../includes/header.php';
?>
<main id="main" class="container page narrow"><a class="back" href="index.php">← Back to announcements</a><section class="form-card wide"><span class="eyebrow">ADMIN</span><h1><?= $editing?'Edit announcement':'New announcement' ?></h1>
<?php foreach($errors as $er): ?><div class="alert error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" data-validate><?= csrf_field() ?><label>Title<input name="title" required minlength="3" maxlength="120" value="<?= e($data['title']) ?>"></label><label>Announcement<textarea name="body" rows="9" required maxlength="3000"><?= e($data['body']) ?></textarea></label><button class="btn primary" type="submit"><?= $editing?'Save changes':'Publish announcement' ?></button></form></section></main>
<?php require __DIR__.'/../includes/footer.php'; ?>