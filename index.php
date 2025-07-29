<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Splash</title>

  <link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#0d6efd">
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
  <style>
    body, html {
      height: 100%;
      margin: 0;
    }
    .main {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    img {
      width: 200px;
    }
  </style>
  <script>
     setTimeout(function () {
      window.location.href = "signup_home.php";  
    }, 4000);

    
    
  </script>

  <button id="installBtn" style="display:none;">Install App</button>

  <div class="main">
    <img src="logo.png" alt="Logo">
  </div>

  <script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('service-worker.js')
        .then(reg => console.log('Service Worker registered', reg))
        .catch(err => console.log('Service Worker failed', err));
    });
  }
</script>

</body>
</html>
