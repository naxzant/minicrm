<?php
require_once __DIR__ . '/../core/Database.php';

function e($msg) { echo $msg . PHP_EOL; }

$username = $argv[1] ?? 'admin';
$password = $argv[2] ?? 'admin@123';
$generated = false;
if (!$password) {
    try {
        $password = bin2hex(random_bytes(6)); // 12 hex chars
        $generated = true;
    } catch (Exception $ex) {
        // fallback
        $password = 'changeme';
        $generated = true;
    }
}

try {
    $db = Database::getConnection();

    $stmt = $db->prepare('SELECT id FROM admin_user WHERE username = ?');
    $stmt->execute([$username]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($exists) {
        e("User '{$username}' already exists. Aborting.");
        exit(0);
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $insert = $db->prepare('INSERT INTO admin_user (username, password, email, role) VALUES (?, ?, ?, ?)');
    $insert->execute([$username, $hash, null, 'admin']);

    e("Inserted admin user: {$username}");
    if ($generated) {
        e("Generated password: {$password}");
        e("Please store this password securely and change it after first login.");
    } else {
        e("Password set from argument (not shown).");
    }

} catch (PDOException $e) {
    e('Database error: ' . $e->getMessage());
    exit(1);
} catch (Exception $e) {
    e('Error: ' . $e->getMessage());
    exit(1);
}

?>
