<?php
require_once __DIR__.'/../includes/functions.php';require_admin();
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method not allowed');}verify_csrf();
$id=(int)($_POST['id']??0);$s=db()->prepare('SELECT title FROM announcements WHERE id=?');$s->execute([$id]);$a=$s->fetch();
if($a){$d=db()->prepare('DELETE FROM announcements WHERE id=?');$d->execute([$id]);audit('DELETE','announcement',$id,$a['title']);flash('success','Announcement deleted.');}
redirect('/CIHE_ClubConnect_Model/announcements/index.php');
