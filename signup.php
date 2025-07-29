<?php
include 'db.php';

$errors = [];
$first_name = $last_name = $username = $email = $password = $phone = $gender = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);
    $phone      = trim($_POST['phone']);
    $gender     = $_POST['gender'] ?? '';


    
    if (empty($first_name)) $errors['first_name'] = 'First name is required.';
    if (empty($last_name)) $errors['last_name'] = 'Last name is required.';
    if (empty($username)) $errors['username'] = 'Username is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email address.';
    if (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters.';
    if (!preg_match('/^[0-9]{7,15}$/', $phone)) $errors['phone'] = 'Enter a valid phone number.';
    if (!in_array($gender, ['Male', 'Female'])) $errors['gender'] = 'Select a valid gender.';

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO medical (first_name, last_name, username, email, password, phone_number, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $hashedPassword, $phone, $gender);

        if ($stmt->execute()) {
            $success = "Sign up successful!";
            // clear form values
            $first_name = $last_name = $username = $email = $password = $phone = $gender = '';
        } else {
            $errors['db'] = "Database error: " . $stmt->error;
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
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; }
    .signup-container {
      max-width: 400px;
      margin: auto;
      padding: 20px;
    }
    .form-label { font-weight: 600; font-size: 0.9rem; }
    .btn-dark { width: 100%; font-weight: bold; padding: 10px; }
    .login-link { text-align: center; margin-top: 10px; font-size: 0.9rem; }
    .login-link a { font-weight: bold; text-decoration: none; }
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

<div class="signup-container">
  <div class="back-arrow mb-3">&larr;</div>
  <h4 class="text-center mb-4 fw-bold">Sign Up</h4>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <?php if (isset($errors['db'])): ?>
    <div class="alert alert-danger"><?= $errors['db'] ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label class="form-label">First Name</label>
      <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($first_name) ?>">
      <?php if (isset($errors['first_name'])): ?><small class="text-danger"><?= $errors['first_name'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Last Name</label>
      <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($last_name) ?>">
      <?php if (isset($errors['last_name'])): ?><small class="text-danger"><?= $errors['last_name'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>">
      <?php if (isset($errors['username'])): ?><small class="text-danger"><?= $errors['username'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
      <?php if (isset($errors['email'])): ?><small class="text-danger"><?= $errors['email'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control">
      <?php if (isset($errors['password'])): ?><small class="text-danger"><?= $errors['password'] ?></small><?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone no.*</label>
      <div class="input-group">
        <span class="input-group-text">+234</span>
        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
      </div>
      <?php if (isset($errors['phone'])): ?><small class="text-danger"><?= $errors['phone'] ?></small><?php endif; ?>
    </div>

    <div class="mb-4">
      <label class="form-label">Gender*</label>
      <select class="form-select" name="gender">
        <option disabled <?= $gender == '' ? 'selected' : '' ?>>Choose gender</option>
        <option <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
        <option <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
      </select>
      <?php if (isset($errors['gender'])): ?><small class="text-danger"><?= $errors['gender'] ?></small><?php endif; ?>
    </div>

    <button type="submit" class="btn btn-dark">Sign Up</button>

    <div class="login-link mt-3">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
