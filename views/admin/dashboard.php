<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = 'Dashboard';
ob_start();
?>
<h2>Admin Dashboard</h2>
<p>Welcome <?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?>.</p>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
