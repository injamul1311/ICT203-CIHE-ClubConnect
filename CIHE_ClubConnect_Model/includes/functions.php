<?php
require_once __DIR__ . '/../config/database.php';

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): never {
    header("Location: $path");
    exit;
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function current_user(): ?array {
    if (!is_logged_in()) return null;
    return [
        'id' => (int)$_SESSION['user_id'],
        'name' => (string)$_SESSION['name'],
        'email' => (string)$_SESSION['email'],
        'role' => (string)$_SESSION['role'],
    ];
}

function require_login(): void {
    if (!is_logged_in()) redirect('/CIHE_ClubConnect_Model/login.php');
}

function require_admin(): void {
    require_login();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        require __DIR__ . '/header.php';
        echo '<main class="container"><div class="alert error"><h2>Access denied</h2><p>Administrator permission is required.</p></div></main>';
        require __DIR__ . '/footer.php';
        exit;
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Invalid or expired CSRF token.');
    }
}

function flash(string $type, string $message): void {
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function audit(string $action, string $entityType, ?int $entityId = null, ?string $details = null): void {
    if (!is_logged_in()) return;
    $stmt = db()->prepare(
        'INSERT INTO activity_logs (user_id, action, entity_type, entity_id, details, ip_address)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $_SESSION['user_id'], $action, $entityType, $entityId, $details,
        $_SERVER['REMOTE_ADDR'] ?? null
    ]);
}

function validate_event(array $data): array {
    $errors = [];
    $title = trim((string)($data['title'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));
    $location = trim((string)($data['location'] ?? ''));
    $category = trim((string)($data['category'] ?? ''));
    $eventDate = trim((string)($data['event_date'] ?? ''));

    if ($title === '' || mb_strlen($title) < 3 || mb_strlen($title) > 120)
        $errors[] = 'Title must be between 3 and 120 characters.';
    if ($description === '' || mb_strlen($description) > 2000)
        $errors[] = 'Description is required and must be at most 2000 characters.';
    if ($location === '' || mb_strlen($location) > 150)
        $errors[] = 'Location is required and must be at most 150 characters.';
    if (!in_array($category, ['Academic','Social','Sports','Career','Community'], true))
        $errors[] = 'Choose a valid category.';
    if ($eventDate === '' || strtotime($eventDate) === false)
        $errors[] = 'Enter a valid event date and time.';
    return $errors;
}

function validate_announcement(array $data): array {
    $errors = [];
    $title = trim((string)($data['title'] ?? ''));
    $body = trim((string)($data['body'] ?? ''));
    if ($title === '' || mb_strlen($title) < 3 || mb_strlen($title) > 120)
        $errors[] = 'Title must be between 3 and 120 characters.';
    if ($body === '' || mb_strlen($body) > 3000)
        $errors[] = 'Announcement text is required and must be at most 3000 characters.';
    return $errors;
}
