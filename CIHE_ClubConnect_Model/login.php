<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) redirect('/CIHE_ClubConnect_Model/dashboard.php');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $errors[] = 'Enter a valid email address and password.';
    } else {
        $stmt = db()->prepare('SELECT id, name, email, password_hash, role, active FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && (int)$user['active'] === 1 && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            audit('LOGIN', 'user', (int)$user['id'], 'Successful login');
            redirect('/CIHE_ClubConnect_Model/dashboard.php');
        }
        $errors[] = 'Email or password is incorrect.';
    }
}
$pageTitle='Login'; require __DIR__ . '/includes/header.php';
?>
<main id="main" class="container auth-layout">
<section class="auth-copy">
<span class="eyebrow">SECURE MEMBER ACCESS</span>
<h1>Welcome back.</h1>
<p>Sign in to explore the model university club management system.</p>
<div class="demo-note"><strong>Demo accounts</strong><br>Admin: admin@clubconnect.test / Admin123!<br>User: member@clubconnect.test / Member123!</div>
</section>
<section class="form-card">
<h2>Sign in</h2>
<?php foreach($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" novalidate>
<?= csrf_field() ?>
<label>Email<input type="email" name="email" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>"></label>
<label>Password<input type="password" name="password" required autocomplete="current-password"></label>
<button class="btn primary full" type="submit">Sign in</button>
</form>
</section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
