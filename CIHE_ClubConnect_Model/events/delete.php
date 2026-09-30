<?php
require_once __DIR__.'/../includes/functions.php'; require_admin();
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method not allowed');}
verify_csrf();$id=(int)($_POST['id']??0);
$s=db()->prepare('SELECT title FROM events WHERE id=?');$s->execute([$id]);$ev=$s->fetch();
if($ev){$d=db()->prepare('DELETE FROM events WHERE id=?');$d->execute([$id]);audit('DELETE','event',$id,$ev['title']);flash('success','Event deleted.');}
redirect('/CIHE_ClubConnect_Model/events/index.php');
