<?php
session_start();
include 'db.php';

$errors = [];
$success = '';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old_password = $_POST['old_password'] ?? '';
  $new_password = $_POST['new_password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
    $errors['fields'] = "All fields are required.";
  } elseif ($new_password !== $confirm_password) {
    $errors['match'] = "New passwords do not match.";
  } elseif (strlen($new_password) < 6) {
    $errors['length'] = "New password must be at least 6 characters.";
  } else {
    // Get current hashed password
    $stmt = $conn->prepare("SELECT password FROM medical WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($old_password, $hashed_password)) {
      $errors['old'] = "Old password is incorrect.";
    } else {
      // Update to new password
      $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
      $update = $conn->prepare("UPDATE medical SET password = ? WHERE id = ?");
      $update->bind_param("si", $new_hashed, $user_id);
      if ($update->execute()) {
        $success = "Password changed successfully!";
      } else {
        $errors['db'] = "Something went wrong.";
      }
      $update->close();
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { font-family: Arial; background-color: #fff; }
    .container { max-width: 400px; margin: auto; padding: 20px; }
    .form-label { font-size: 0.9rem; font-weight: bold; }
    .btn-save { background-color: #444; color: white; font-weight: bold; }
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
  <div class="container mt-4">
    <div class="mb-3 d-flex justify-content-between align-items-center">
      <a href="settings.php" class="text-dark">&larr;</a>
      <h6 class="m-0">Change Password</h6>
      <i class="fas fa-lock"></i>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endforeach; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Old Password</label>
        <input type="password" name="old_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="mb-4">
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-save w-100">Save Password</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
