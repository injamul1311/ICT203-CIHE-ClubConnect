<?php
require_once __DIR__.'/includes/functions.php';require_login();
$question='';$answer='';$matched=[];
$rules=[
 ['keywords'=>['event','events','join','register'],'answer'=>'Open Events from the navigation, search for an activity and open its details. Participation instructions are shown with the event information.'],
 ['keywords'=>['announcement','news','update'],'answer'=>'Open Announcements to see the latest club updates, ordered with the newest first.'],
 ['keywords'=>['login','password','account'],'answer'=>'Use the login page with your registered email and password. If access fails, contact the club administrator; this model does not provide password reset by email.'],
 ['keywords'=>['admin','create','edit','delete'],'answer'=>'Create, edit and delete controls are restricted to the Admin role. Standard Users can browse content but cannot perform administrative changes.'],
 ['keywords'=>['search','filter','category'],'answer'=>'On Events, enter a search term and optionally select a category. Results are paginated when the dataset is larger than one page.'],
 ['keywords'=>['privacy','ai','data'],'answer'=>'Smart Help runs with local keyword rules and predefined responses. It does not send your question or personal information to an external AI service.']
];
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();$question=trim((string)($_POST['question']??''));
 if($question===''){$answer='Please enter a question.';}
 else{
   $lower=mb_strtolower($question);$bestScore=0;$best=null;
   foreach($rules as $rule){$score=0;$hits=[];foreach($rule['keywords'] as $kw){if(str_contains($lower,$kw)){$score++;$hits[]=$kw;}}if($score>$bestScore){$bestScore=$score;$best=$rule;$matched=$hits;}}
   if($best){$answer=$best['answer'];}else{$answer="I couldn't match that question to the local help topics. Try asking about events, announcements, login, admin access, search, privacy or AI.";}
   audit('SMART_HELP','assistant',null,'Matched keywords: '.implode(', ',$matched));
 }
}
$pageTitle='Smart Help';require __DIR__.'/includes/header.php';
?>
<main id="main" class="container page">
<section class="help-layout">
<div><span class="eyebrow">RESPONSIBLE INTELLIGENT FEATURE</span><h1>Smart Help Assistant</h1><p class="lead">Ask a question about using ClubConnect. This assistant uses transparent local keyword matching—not an external AI service.</p>
<div class="principles"><div><strong>Local</strong><span>No public AI API</span></div><div><strong>Reviewable</strong><span>You decide what to do</span></div><div><strong>Limited</strong><span>Only predefined topics</span></div></div>
</div>
<div class="chat-card"><div class="chat-head"><span class="online-dot"></span> Smart Help</div>
<?php if($question!==''): ?><div class="bubble user"><?= e($question) ?></div><div class="bubble bot"><?= e($answer) ?><?php if($matched): ?><small>Matched: <?= e(implode(', ',$matched)) ?></small><?php endif; ?></div><?php else: ?><div class="bubble bot">Hi! Try: “How do I search events?” or “Does Smart Help send my data to AI?”</div><?php endif; ?>
<form method="post" class="chat-form"><?= csrf_field() ?><label class="sr-only" for="question">Question</label><input id="question" name="question" maxlength="250" required placeholder="Ask about ClubConnect…" value=""><button class="btn primary" type="submit">Ask</button></form>
</div></section>
<section class="limitation"><h2>Limitations & responsible use</h2><p>The assistant does not understand every possible question, does not make decisions for users, and does not automatically create or change records. If no rule matches, it gives a safe fallback instead of inventing an answer.</p></section>
</main>
<?php require __DIR__.'/includes/footer.php'; ?>
