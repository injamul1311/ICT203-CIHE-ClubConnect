<?php
require_once __DIR__.'/config/database.php';
$pdo=db();
$messages=[];
$accounts=[
 ['CIHE Club Admin','admin@clubconnect.test','Admin123!','admin'],
 ['Demo Member','member@clubconnect.test','Member123!','user']
];
foreach($accounts as [$name,$email,$password,$role]){
 $s=$pdo->prepare('SELECT id FROM users WHERE email=?');$s->execute([$email]);
 if(!$s->fetch()){
   $i=$pdo->prepare('INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,?)');
   $i->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT),$role]);
   $messages[]="Created $email";
 } else {$messages[]="$email already exists";}
}
$adminId=(int)$pdo->query("SELECT id FROM users WHERE email='admin@clubconnect.test'")->fetchColumn();
if((int)$pdo->query('SELECT COUNT(*) FROM events')->fetchColumn()===0){
 $s=$pdo->prepare("INSERT INTO events(title,description,category,location,event_date,created_by,updated_by) VALUES(?,?,?,?,DATE_ADD(NOW(), INTERVAL 7 DAY),?,?)");
 $s->execute(['Cyber Security Workshop','A practical introduction to secure web development, input validation and common web security risks.','Academic','Computer Lab 2',$adminId,$adminId]);
}
if((int)$pdo->query('SELECT COUNT(*) FROM announcements')->fetchColumn()===0){
 $s=$pdo->prepare('INSERT INTO announcements(title,body,created_by,updated_by) VALUES(?,?,?,?)');
 $s->execute(['Welcome to ClubConnect','Welcome to the model university club portal. Check Events for upcoming activities and Smart Help for application guidance.',$adminId,$adminId]);
}
?><!doctype html><meta charset="utf-8"><title>ClubConnect Setup</title><style>body{font:16px system-ui;max-width:700px;margin:50px auto;padding:20px}div{background:#eef5ff;padding:20px;border-radius:12px}</style><h1>Setup complete</h1><div><?php foreach($messages as $m): ?><p><?= htmlspecialchars($m) ?></p><?php endforeach; ?><p>Sample content checked/created.</p></div><p><strong>Delete or rename setup.php before deployment.</strong></p><p><a href="login.php">Go to login</a></p>
