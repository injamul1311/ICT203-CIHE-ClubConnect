<?php
require_once __DIR__.'/../includes/functions.php'; require_admin();
$id=(int)($_GET['id']??0); $editing=$id>0; $errors=[];
$data=['title'=>'','description'=>'','category'=>'Academic','location'=>'','event_date'=>''];
if($editing){$s=db()->prepare('SELECT * FROM events WHERE id=?');$s->execute([$id]);$data=$s->fetch();if(!$data){http_response_code(404);exit('Event not found');}$data['event_date']=date('Y-m-d\TH:i',strtotime($data['event_date']));}
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 $data=['title'=>trim((string)($_POST['title']??'')),'description'=>trim((string)($_POST['description']??'')),'category'=>trim((string)($_POST['category']??'')),'location'=>trim((string)($_POST['location']??'')),'event_date'=>trim((string)($_POST['event_date']??''))];
 $errors=validate_event($data);
 if(!$errors){
   $dt=date('Y-m-d H:i:s',strtotime($data['event_date']));
   if($editing){$s=db()->prepare('UPDATE events SET title=?,description=?,category=?,location=?,event_date=?,updated_by=? WHERE id=?');$s->execute([$data['title'],$data['description'],$data['category'],$data['location'],$dt,$_SESSION['user_id'],$id]);audit('UPDATE','event',$id,$data['title']);flash('success','Event updated successfully.');}
   else{$s=db()->prepare('INSERT INTO events(title,description,category,location,event_date,created_by,updated_by) VALUES(?,?,?,?,?,?,?)');$s->execute([$data['title'],$data['description'],$data['category'],$data['location'],$dt,$_SESSION['user_id'],$_SESSION['user_id']]);$id=(int)db()->lastInsertId();audit('CREATE','event',$id,$data['title']);flash('success','Event created successfully.');}
   redirect('/CIHE_ClubConnect_Model/events/view.php?id='.$id);
 }
}
$pageTitle=$editing?'Edit Event':'Create Event';require __DIR__.'/../includes/header.php';
?>
<main id="main" class="container page narrow">
<a class="back" href="index.php">← Back to events</a>
<section class="form-card wide"><span class="eyebrow">ADMIN</span><h1><?= $editing?'Edit event':'Create event' ?></h1>
<?php foreach($errors as $er): ?><div class="alert error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" data-validate>
<?= csrf_field() ?>
<label>Event title<input name="title" required minlength="3" maxlength="120" value="<?= e($data['title']) ?>"></label>
<div class="two-col"><label>Category<select name="category" required><?php foreach(['Academic','Social','Sports','Career','Community'] as $c): ?><option <?= $data['category']===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select></label>
<label>Date and time<input type="datetime-local" name="event_date" required value="<?= e($data['event_date']) ?>"></label></div>
<label>Location<input name="location" required maxlength="150" value="<?= e($data['location']) ?>"></label>
<label>Description<textarea name="description" rows="7" required maxlength="2000"><?= e($data['description']) ?></textarea></label>
<button class="btn primary" type="submit"><?= $editing?'Save changes':'Create event' ?></button>
</form></section></main>
<?php require __DIR__.'/../includes/footer.php'; ?>