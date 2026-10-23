<?php
/**
 * Run this ONCE in your browser after importing database/schema.sql
 * to create your first administrator account, then DELETE this file.
 *
 * Example: http://localhost/fdmrs_system/setup_admin.php
 */
require_once __DIR__ . '/config/database.php';

$message = '';
$done = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $fullName === '' || strlen($password) < 6) {
        $message = 'Please fill all fields; password must be at least 6 characters.';
    } else {
        $conn = get_db_connection();
        $stmt = $conn->prepare('SELECT user_id FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        if ($stmt->get_result()->fetch_assoc()) {
            $message = 'That username already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare('INSERT INTO users (username, password_hash, role, full_name) VALUES (?, ?, "admin", ?)');
            $stmt->bind_param('sss', $username, $hash, $fullName);
            $stmt->execute();
            $done = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>First-Time Admin Setup</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="citizen-shell">
  <main class="citizen-main">
    <div class="card">
      <h1>Create the first admin account</h1>
      <p class="lede">Run this once, then delete this file for security.</p>

      <?php if ($done): ?>
        <div class="alert alert-success">Admin account created. You can now <a href="admin/login.php">log in</a>. Please delete <code>setup_admin.php</code> now.</div>
      <?php else: ?>
        <?php if ($message): ?><div class="alert alert-error"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <form method="post">
          <label for="full_name">Full name</label>
          <input type="text" id="full_name" name="full_name" required>
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required minlength="6">
          <button type="submit" class="btn btn-primary btn-block">Create admin account</button>
        </form>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
