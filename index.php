<?php require_once __DIR__ . '/includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AFTRIMS — BFP San Carlos City</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="citizen-shell">
  <header class="citizen-header">
    <div class="brand">BFP San Carlos City<span>AFTRIMS &middot; Automated Fire Truck Refill &amp; Incident Monitoring System</span></div>
    <div>
      <span class="badge badge-green" style="font-size:0.75rem;">● SYSTEM ONLINE</span>
    </div>
  </header>
  <main class="citizen-main">
    <div class="card" style="text-align:center; max-width:580px;">
      <div style="font-family:var(--font-mono); font-size:0.75rem; letter-spacing:0.18em; color:var(--cyber-cyan); margin-bottom:8px;">
        TACTICAL EMERGENCY RESPONSE INTERFACE
      </div>
      <h1 style="justify-content:center; font-size:2rem; margin-bottom:12px;">AFTRIMS COMMAND</h1>
      <p class="lede" style="margin-left:auto; margin-right:auto;">
        Automated Fire Truck Refill &amp; Incident Monitoring System (AFTRIMS) for BFP San Carlos City.
      </p>

      <div style="display:flex; flex-direction:column; gap:12px; margin-top:28px;">
        <a href="citizen/login.php" class="btn btn-primary" style="padding:14px 20px; font-size:1.02rem;">
          🚨 Resident Portal &middot; Report Incident
        </a>
        <a href="admin/login.php" class="btn btn-secondary" style="padding:14px 20px; font-size:1.02rem;">
          🛡️ BFP Personnel &middot; Admin Command
        </a>
      </div>

      <div style="margin-top:28px; padding-top:20px; border-top:1px solid rgba(255,255,255,0.08); font-family:var(--font-mono); font-size:0.75rem; color:var(--text-dim);">
        BFP SAN CARLOS CITY &middot; 24/7 EMERGENCY MONITORING
      </div>
    </div>
  </main>
  <p class="footer-note">BFP San Carlos City &middot; Negros Occidental &middot; Firmware v2.0</p>
</body>
</html>
