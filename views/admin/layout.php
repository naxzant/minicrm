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

/* Reset */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}

/* Header */
.admin-header {
    background: linear-gradient(90deg, #667eea, #764ba2);
    color: #fff;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: slideDown 0.6s ease;
}

.admin-header strong {
    font-size: 18px;
    letter-spacing: 1px;
}

/* Layout */
.admin-layout {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.admin-aside {
    width: 220px;
    background: #1f2937;
    padding: 20px;
    color: #fff;
    transition: 0.3s;
}

.admin-aside a {
    display: block;
    color: #cbd5e1;
    text-decoration: none;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 8px;
    transition: 0.3s;
}

.admin-aside a:hover {
    background: #374151;
    color: #fff;
    transform: translateX(5px);
}

/* Content */
.admin-content {
    flex: 1;
    padding: 25px;
    animation: fadeIn 0.8s ease;
}

/* Logout Button */
.admin-header a {
    color: #e895e9;
    border: 1px solid #fff;
    padding: 6px 10px;
    border-radius: 4px;
    text-decoration: none;
    transition: 0.3s;
}

.admin-header a:hover {
    background: #fff;
    color: #dfcdf0;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .admin-layout {
        flex-direction: column;
    }

    .admin-aside {
        width: 100%;
        display: flex;
        justify-content: space-around;
    }

    .admin-aside a {
        margin: 0;
        padding: 8px;
        font-size: 14px;
    }
}

</style>

</head>
<body>
  <header class="admin-header d-flex justify-content-between align-items-center">
    <div><strong>Admin</strong></div>
    <div>
      <?php if (!empty($_SESSION['admin_authenticated'])): ?>
        <a href="admin.php?controller=auth&action=logout" style="color:#fff;background:transparent;border:1px solid #fff;padding:6px 8px;border-radius:4px;text-decoration:none">Logout</a>
      <?php endif; ?>
    </div>
  </header>

  <div class="admin-layout">
    <aside class="admin-aside">
      <a href="admin.php">Dashboard</a>
     
      <a href="admin.php?controller=course">course</a>
    </aside>
    <main class="admin-content">
      <?php echo $content ?? ''; ?>
    </main>
  </div>
</body>
</html>
