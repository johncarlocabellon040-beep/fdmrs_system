<?php
require_once __DIR__ . '/includes/auth.php';
http_response_code(403);
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Access Denied — BFP San Carlos City</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
  .denied-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    text-align: center;
    padding: 40px 20px;
  }
  .denied-code {
    font-family: var(--font-mono);
    font-size: 7rem;
    font-weight: 900;
    line-height: 1;
    color: var(--laser-red);
    text-shadow: 0 0 40px rgba(255, 50, 50, 0.7), 0 0 80px rgba(255, 50, 50, 0.3);
    letter-spacing: -4px;
    margin-bottom: 12px;
    animation: glitch 3s infinite;
  }
  @keyframes glitch {
    0%, 94%, 100% { transform: none; text-shadow: 0 0 40px rgba(255,50,50,0.7), 0 0 80px rgba(255,50,50,0.3); }
    95% { transform: skewX(-3deg); text-shadow: -3px 0 var(--cyber-cyan), 3px 0 var(--laser-red); }
    97% { transform: skewX(3deg); text-shadow: 3px 0 var(--cyber-cyan), -3px 0 var(--laser-red); }
  }
  .denied-label {
    font-family: var(--font-mono);
    font-size: 0.8rem;
    letter-spacing: 0.25em;
    color: var(--laser-red);
    margin-bottom: 24px;
    text-transform: uppercase;
  }
  .denied-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text);
  }
  .denied-desc {
    font-size: 0.95rem;
    color: var(--text-muted);
    max-width: 440px;
    margin: 0 auto 32px;
    line-height: 1.6;
  }
  .denied-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
  }
  .shield-icon {
    font-size: 4rem;
    margin-bottom: 16px;
    filter: drop-shadow(0 0 16px rgba(255,50,50,0.5));
    animation: pulse-shield 2s ease-in-out infinite;
  }
  @keyframes pulse-shield {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.07); }
  }
  .scan-line {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--laser-red), transparent);
    animation: scan 4s linear infinite;
    opacity: 0.4;
    pointer-events: none;
  }
  @keyframes scan {
    0%   { top: 0; }
    100% { top: 100%; }
  }
</style>
</head>
<body class="citizen-shell">
  <div class="scan-line"></div>
  <div class="denied-wrap">
    <div class="shield-icon">🛡️</div>
    <div class="denied-code">403</div>
    <div class="denied-label">⚠ Access Denied &middot; Unauthorized Zone</div>
    <h1 class="denied-title">You don't have permission to enter this area.</h1>
    <p class="denied-desc">
      <?php if ($user): ?>
        Your account (<strong><?= h($user['username']) ?></strong>) does not have the required role to access this page. This area is restricted to authorized personnel only.
      <?php else: ?>
        This page is restricted to authorized BFP San Carlos City personnel. Please log in with an administrator account to proceed.
      <?php endif; ?>
    </p>
    <div class="denied-actions">
      <?php if ($user && $user['role'] === 'citizen'): ?>
        <a href="citizen/dashboard.php" class="btn btn-primary">← Back to Citizen Portal</a>
        <a href="citizen/logout.php"    class="btn btn-secondary">Log Out</a>
      <?php else: ?>
        <a href="index.php"         class="btn btn-primary">Go to Home Page</a>
        <a href="admin/login.php"   class="btn btn-secondary">Admin Login</a>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
