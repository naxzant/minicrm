<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link href="/assets/css/site.css" rel="stylesheet">
  <style>body{padding:20px}form{max-width:360px;margin:40px auto}label{display:block;margin-top:8px}input{width:100%;padding:8px}</style>
</head>
<body>
  <h1>Admin Login</h1>
  <?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form method="post" action="admin.php?controller=auth&action=login">
    <label for="username">Username</label>
    <input id="username" name="username" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <p><button type="submit">Login</button></p>
  </form>
</body>
</html>
