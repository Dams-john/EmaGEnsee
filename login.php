<?php
session_start();
include 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) $errors['username'] = 'Username is required.';
    if (empty($password)) $errors['password'] = 'Password is required.';

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM medical WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: home.php");
                exit;
            } else {
                $errors['login'] = 'Invalid password.';
            }
        } else {
            $errors['login'] = 'User not found.';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; }

    .login-container {
      max-width: 400px;
      margin: auto;
      padding: 20px;
    }
    .btn-dark{ width: 100%; 
                font-weight: bold; 
                padding: 10px; 
              }

    .signup-link { text-align: center; 
                   margin-top: 10px; 
                   font-size: 0.9rem;
                 }

    .signup-link a {font-weight: bold; 
                    text-decoration: none; 
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

<div class="login-container">
  <div class="back-arrow mb-3">&larr;</div>
  <h4 class="text-center mb-4 fw-bold">Login</h4>

  <?php if (isset($errors['login'])): ?>
    <div class="alert alert-danger"><?= $errors['login'] ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">User Name</label>
      <input type="text" name="username" class="form-control" placeholder="Enter username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
      <?php if (isset($errors['username'])): ?><small class="text-danger"><?= $errors['username'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="********">
      <?php if (isset($errors['password'])): ?><small class="text-danger"><?= $errors['password'] ?></small><?php endif; ?>
    </div>

    <div class="form-check mb-4">
      <input class="form-check-input" type="checkbox" id="rememberMe">
      <label class="form-check-label" for="rememberMe">
        Remember Me
      </label>
    </div>

    <button type="submit" class="btn btn-dark">Login</button>

    <div class="signup-link mt-3">
      Don’t have an account? <a href="signup.php">SignUp</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
