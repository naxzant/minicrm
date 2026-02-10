<?php
// Minimal admin layout. Expects $title and $content.
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($title ?? 'Admin'); ?></title>
  <link href="/assets/css/site.css" rel="stylesheet">
  <style>
    .admin-header{background:#222;color:#fff;padding:10px}
    .admin-layout{display:flex}
    .admin-aside{width:200px;padding:15px;background:#f1f1f1}
    .admin-content{flex:1;padding:15px}
    .admin-aside a{display:block;margin:6px 0}
  </style>
</head>
<body>
  <header class="admin-header d-flex justify-content-between align-items-center">
    <div><strong>Admin</strong></div>
    <div>
      <?php if (!empty($_SESSION['admin_authenticated'])): ?>
        <span style="margin-right:12px">Signed in as <?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?></span>
        <a href="admin.php?controller=auth&action=logout" style="color:#fff;background:transparent;border:1px solid #fff;padding:6px 8px;border-radius:4px;text-decoration:none">Logout</a>
      <?php endif; ?>
    </div>
  </header>

  <div class="admin-layout">
    <aside class="admin-aside">
      <a href="admin.php">Dashboard</a>
      <a href="admin.php?controller=product">Catalog</a>
      <a href="admin.php?controller=inventory">Inventory</a>
    </aside>
    <main class="admin-content">
      <?php echo $content ?? ''; ?>
    </main>
  </div>
</body>
</html>
