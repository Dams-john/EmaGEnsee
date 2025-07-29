<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$current_username = $_SESSION['username'];
$errors = [];
$success = '';

// Get user data
$stmt = $conn->prepare("SELECT * FROM medical WHERE username = ?");
$stmt->bind_param("s", $current_username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$profile_pic = $user['profile_picture'] ?? 'default.png';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);

  // Validate
  if (!$username) $errors['username'] = 'Username is required';
  if (!$first_name) $errors['first_name'] = 'First name is required';
  if (!$last_name) $errors['last_name'] = 'Last name is required';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email';
  if (!preg_match('/^\d{7,15}$/', $phone)) $errors['phone'] = 'Invalid phone number';

  // Check if username exists (but not the current one)
  if ($username !== $current_username) {
    $stmt = $conn->prepare("SELECT id FROM medical WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors['username'] = "Username already taken";
    $stmt->close();
  }

  if (empty($errors)) {
    $stmt = $conn->prepare("UPDATE medical SET username=?, first_name=?, last_name=?, email=?, phone_number=? WHERE username=?");
    $stmt->bind_param("ssssss", $username, $first_name, $last_name, $email, $phone, $current_username);
    if ($stmt->execute()) {
      $_SESSION['username'] = $username; // update session
      header("Location: home.php");
      exit;
    } else {
      $errors['db'] = "Database error.";
    }
    $stmt->close();
  }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
    }
    .edit-container {
      max-width: 450px;
      margin: auto;
      padding: 20px;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
    .divider {
      border-top: 1px solid #ccc;
      margin-bottom: 20px;
    }
    .profile-pic {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
    }
    .form-control {
      border-radius: 10px;
      font-size: 14px;
    }
    .save-btn {
      background-color: #666;
      color: white;
      font-weight: bold;
      border-radius: 10px;
    }
    small.text-danger {
      font-size: 12px;
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
  <div class="edit-container">
    <!-- Top Bar -->
    <div class="top-bar">
      <i class="fas fa-arrow-left" onclick="history.back()" style="cursor:pointer;"></i>
      <h6 class="mb-0">Edit Profile</h6>
      <!-- <i class="fas fa-pen-to-square"></i> -->
    </div>

    <div class="divider"></div>

    <!-- Profile Image -->
    <div class="text-start mb-4">
      <img src="uploads/<?= htmlspecialchars($profile_pic) ?>" alt="Profile" class="profile-pic" />
    </div>

    <!-- Edit Form -->
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>">
        <?php if (isset($errors['username'])): ?><small class="text-danger"><?= $errors['username'] ?></small><?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>">
        <?php if (isset($errors['first_name'])): ?><small class="text-danger"><?= $errors['first_name'] ?></small><?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>">
        <?php if (isset($errors['last_name'])): ?><small class="text-danger"><?= $errors['last_name'] ?></small><?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
        <?php if (isset($errors['email'])): ?><small class="text-danger"><?= $errors['email'] ?></small><?php endif; ?>
      </div>

      <div class="mb-4">
        <label class="form-label">Phone No.</label>
        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone_number']) ?>">
        <?php if (isset($errors['phone'])): ?><small class="text-danger"><?= $errors['phone'] ?></small><?php endif; ?>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn save-btn">Save</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
