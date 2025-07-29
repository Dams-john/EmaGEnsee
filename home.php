<?php
session_start();

// Load language preference
$lang = $_SESSION['lang'] ?? 'en';
$langFile = __DIR__ . "/lang/$lang.json";
$langData = file_exists($langFile) ? json_decode(file_get_contents($langFile), true) : [];

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $langData['home_title'] ?? 'Home' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#1976d2">

  <style>
    body { font-family: Arial, sans-serif; 
           background: #fff; }
    .dark-mode { 
                background-color: #121212; 
                color: #eee; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; padding: 15px; }
    .top-bar .fa-bars, .top-bar .fa-arrow-left { font-size: 1.4rem; cursor: pointer; }
    .profile-section { text-align: center; margin-top: 10px; }
    .profile-section img { width: 90px; height: 90px; object-fit: cover; border-radius: 50%; }
    .profile-name { font-weight: bold; font-size: 1.1rem; margin-top: 10px; }
    .profile-role { font-size: 0.9rem; color: #555; }
    .profile-location { font-size: 0.9rem; color: #888; }
    .menu-list { margin-top: 20px; }
    .menu-item { display: flex; align-items: center; padding: 12px 20px; border-bottom: 1px solid #eee; font-size: 1rem; cursor: pointer; }
    .menu-item i { width: 25px; text-align: center; margin-right: 15px; font-size: 1.2rem; }
    .menu-item.active { background-color: #eee; }
    .menu-item:hover { background-color: #f2f2f2; }
    .dark-mode .menu-item.active { background-color: #2a2a2a;}
  </style>
<link rel="manifest" href="/manifest.json">

    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register('/service-worker.js');
        });
      }
    </script>
    
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
  <i class="fas fa-arrow-left"></i>
  <h6 class="fw-bold m-0"><?= $langData['home_title'] ?? 'Home' ?></h6>
  <i class="fas fa-bars"></i>
</div>

<!-- Profile Section -->
<div class="profile-section">
  <img src="https://i.pravatar.cc/150?img=12" alt="Profile Image">
  <div class="profile-name"><?= htmlspecialchars($username) ?></div>
  <div class="profile-role">Fire Station</div>
  <div class="profile-location">Oke Fia , Osogbo, Osun State</div>
</div>

<hr>

<!-- Menu List -->
<div class="menu-list">
  <div class="menu-item">
    <i class="fas fa-house"></i> <?= $langData['home_menu'] ?? 'Home' ?>
  </div>

  <div class="menu-item active">
    <i class="fas fa-user"></i> <a href="View_profile.php"><?= $langData['profile_menu'] ?? 'Profile' ?></a>
  </div>

  <div class="menu-item">
    <i class="fas fa-globe"></i> <a href="history.php"><?= $langData['history_menu'] ?? 'History' ?></a>
  </div>

  <div class="menu-item">
    <i class="fas fa-gear"></i> <a href="settings.php"><?= $langData['settings_menu'] ?? 'Settings' ?></a>
  </div>

  <div class="menu-item">
    <i class="fas fa-bolt"></i> <a href=""><?= $langData['active_incident'] ?? 'Active Incident' ?></a>
  </div>

  <div class="menu-item">
    <i class="fas fa-sign-out-alt"></i> <a href="logout.php"><?= $langData['logout_menu'] ?? 'Logout' ?></a>
  </div>
</div>

<script>
  // Dark Mode Toggle from localStorage
  if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js')
      .then(reg => console.log('Service Worker registered:', reg.scope))
      .catch(err => console.error('Service Worker error:', err));
  }
</script>

</body>
</html>
