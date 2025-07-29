<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EmaGENsee</title>

  <!-- Poppins Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  
  <!-- Font Awesome for Bell Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    html, body {
      width: 100%;
      height: 100%;
    }

    body {
      background-color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 2rem 1rem;
      min-height: 100vh;
      text-align: center;
    }

    #mobile-content, #desktop-message {
      width: 100%;
      max-width: 400px;
    }

    img {
      width: 100%;
      max-width: 200px;
      height: auto;
      margin: 0 auto 1rem;
    }

    h1 {
      font-size: 1.6rem;
      margin-bottom: 0.5rem;
    }

    p {
      font-size: 0.95rem;
      color: #333;
      margin-bottom: 2rem;
      padding: 0 1rem;
      line-height: 1.4;
    }

    .button-container {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    button {
      width: 100%;
      padding: 1rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
    }

    .sign {
      background-color: grey;
      color: white;
    }

    .log {
      background-color: #D9D9D9;
      color: #000;
    }

    #desktop-message {
      display: none;
      color: red;
      font-weight: bold;
      padding-top: 4rem;
    }

    /* Bell Button */
    .bell-wrapper {
      margin-top: 2rem;
      display: flex;
      justify-content: center;
    }

    .bell-button {
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 50px;
      padding: 1.2rem;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .bell-button i {
      color: black;
    }

    /* Responsive text size on very small screens */
    @media (max-width: 350px) {
      h1 {
        font-size: 1.3rem;
      }

      p {
        font-size: 0.85rem;
      }

      button {
        font-size: 0.9rem;
        padding: 0.8rem;
      }
    }
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

  <div id="mobile-content">
    <img src="logo.png" alt="App Logo" />

    <h1>EmaGENsee.</h1>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas libero recusandae, alias placeat quae ad illum expedita reiciendis.</p>

    <div class="button-container">
      <a href="signup.php" class="sign">Sign Up</a>
      <a href="login.php"class="log">Log in</a>
    </div>

    <!-- Bell Icon Button -->
    <div class="bell-wrapper">
      <button class="bell-button">
        <i class="fas fa-bell"></i>
      </button>
    </div>
  </div>

  <!-- Desktop Message -->
  <div id="desktop-message"> 
    <h2>Not Supported</h2>
    <p>This app only works on mobile devices.</p>
  </div>

  <script src="script.js"></script>

</body>
</html>
