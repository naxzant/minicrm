<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link href="/assets/css/site.css" rel="stylesheet">
  <style>

/* Background */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Login Card */
.login-container {
    width: 360px;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
    animation: fadeIn 0.8s ease-in-out;
}

/* Heading */
.login-container h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
}

/* Labels */
label {
    display: block;
    margin-top: 12px;
    font-weight: 600;
    color: #34495e;
}

/* Inputs */
input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s;
}

input:focus {
    border-color: #667eea;
    outline: none;
}

/* Button */
button {
    width: 100%;
    padding: 10px;
    margin-top: 18px;
    background: #667eea;
    border: none;
    color: #fff;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #5a67d8;
    transform: scale(1.03);
}

/* Error */
.error-message {
    background: #ffe6e6;
    color: #c0392b;
    padding: 8px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 10px;
    font-size: 14px;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 480px) {
    .login-container {
        width: 90%;
        padding: 20px;
    }
}

</style>

</head>
<body>
  <div class="login-container">
  <h1>Admin Login</h1>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="error-message">
      <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <form method="post" action="admin.php?controller=auth&action=login">
    <label for="username">Username</label>
    <input id="username" name="username" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
