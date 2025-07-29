<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title data-text="settings_title">Settings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      transition: background-color 0.3s, color 0.3s;
    }
    .dark-mode {
      background-color: #121212;
      color: #e4e4e4;
    }
    .container { max-width: 450px; margin: auto; padding: 20px; }
    .divider { border-top: 1px solid #ccc; margin: 10px 0 20px 0; }
    .section-title { font-size: 13px; font-weight: bold; margin-bottom: 10px;}
    .option-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; cursor: pointer; }
    .option-row:hover { background: #f8f9fa; }
    select.form-select { width: 100%; }
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
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="home.php"><i class="fas fa-arrow-left"></i></a>
    <h6 class="m-0" data-text="settings">Settings</h6>
    <i class="fas fa-pen-to-square"></i>
  </div>

  <div class="divider"></div>

  <div class="section-title" data-text="security">SECURITY</div>
  <div class="option-row" onclick="window.location='change_password.php'">
    <span data-text="change_password">Change Password</span>
    <i class="fas fa-chevron-right"></i>
  </div>
  <div class="option-row">
    <span data-text="reset_pin">Reset Pin</span>
    <i class="fas fa-chevron-right"></i>
  </div>

  <div class="divider"></div>

  <div class="section-title" data-text="preference">PREFERENCE</div>
  <div class="option-row">
    <span data-text="opt_sms">Opt-sms for Notification</span>
    <div class="form-check form-switch m-0">
      <input class="form-check-input" type="checkbox" role="switch" checked />
    </div>
  </div>
  <div class="option-row">
    <span data-text="change_theme">Dark Mode</span>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="themeToggle">
    </div>
  </div>

  <div class="mt-3 mb-3">
    <label for="languageSelect" class="form-label" data-text="select_language">Select Language</label>
    <select id="languageSelect" class="form-select">
      <option value="en">English</option>
      <option value="ha">Hausa</option>
      <option value="ig">Igbo</option>
    </select>
  </div>

  <div class="divider"></div>

  <div class="section-title" data-text="others">OTHERS</div>
  <div class="option-row">
    <span data-text="contact_support">Contact Support</span>
    <i class="fas fa-chevron-right"></i>
  </div>
  <div class="option-row">
    <span data-text="about_us">About Us</span>
    <i class="fas fa-chevron-right"></i>
  </div>
</div>

<script>
  function applyDarkMode(state) {
    document.body.classList.toggle('dark-mode', state);
  }

  async function loadLanguage(lang) {
    try {
      const res = await fetch(`lang/${lang}.json`);
      const data = await res.json();
      document.querySelectorAll('[data-text]').forEach(el => {
        const key = el.getAttribute('data-text');
        if (data[key]) el.innerText = data[key];
      });
    } catch (e) {
      console.error("Translation error:", e);
    }
  }

  const savedLang = localStorage.getItem('lang') || 'en';
  const savedDark = localStorage.getItem('darkMode') === 'true';

  document.getElementById('languageSelect').value = savedLang;
  loadLanguage(savedLang);
  applyDarkMode(savedDark);
  document.getElementById('themeToggle').checked = savedDark;

  document.getElementById('languageSelect').addEventListener('change', e => {
    localStorage.setItem('lang', e.target.value);
    loadLanguage(e.target.value);
  });

  document.getElementById('themeToggle').addEventListener('change', e => {
    localStorage.setItem('darkMode', e.target.checked);
    applyDarkMode(e.target.checked);
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
