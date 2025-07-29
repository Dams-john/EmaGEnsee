<?php
session_start();
include 'db.php';

// Protect page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$success = '';
$error = '';

// Fetch user
$stmt = $conn->prepare("SELECT * FROM medical WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($ext, $allowed)) {
        $error = "Only JPG, PNG, GIF files allowed.";
    } elseif ($file['size'] > 2 * 1024 * 1024) {
        $error = "Max file size is 2MB.";
    } else {
        $filename = uniqid('profile_') . '.' . $ext;
        move_uploaded_file($file['tmp_name'], 'uploads/' . $filename);

        // Save filename in DB
        $stmt = $conn->prepare("UPDATE medical SET profile_picture = ? WHERE username = ?");
        $stmt->bind_param("ss", $filename, $username);
        if ($stmt->execute()) {
            $success = "Profile picture updated.";
            $user['profile_picture'] = $filename;
        } else {
            $error = "Database error.";
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
  <title>Profile Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body { background-color: #fff; font-family: Arial, sans-serif; }
    .profile-container { max-width: 400px; margin: auto; padding: 20px; }
    .profile-img { width: 100%; height: auto; object-fit: cover; border-radius: 10px; }
    .upload-btn {
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(0, 0, 0, 0.6);
      color: white;
      padding: 5px 15px;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
    }
    .info-icon { width: 20px; }
    .divider { border-bottom: 1px solid #ccc; margin: 10px 0; }
    .profile-header { position: relative; width: 100%; }
    .text-info-custom { font-size: 14px; }
    form input[type="file"] { display: none; }
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
  <div class="profile-container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
      <i class="fas fa-arrow-left"></i>
      <h6 class="m-0">Profile</h6>
      <a href="edit_profile.php"><i class="fas fa-pen-to-square"></i>
</a>
    </div>

    <!-- Feedback -->
    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Profile Picture Section -->
    <div class="profile-header mb-3">
      <img src="uploads/<?= $user['profile_picture'] ?? 'default.png' ?>" alt="Profile" class="profile-img">
      <form method="POST" enctype="multipart/form-data">
        <label class="upload-btn">
          Upload Picture
          <input type="file" name="profile_image" onchange="this.form.submit()">
        </label>
      </form>
    </div>

    <!-- Profile Info -->
    <div>
 
         <div class="d-flex align-items-center mb-1">
        <i class="fa fa-profile me-2"></i>
        <span class="text-info-custom">Username: <?= htmlspecialchars($user['username']) ?></span>
      </div>

      <div class="d-flex align-items-center mb-1">
        <i class="fas fa-envelope me-2"></i>
        <span class="text-info-custom"><?= htmlspecialchars($user['email']) ?></span>
      </div>
      <div class="divider"></div>

      <div class="d-flex align-items-center mb-1">
        <i class="fas fa-phone me-2"></i>
        <a class="text-info-custom" href="">+234<?= htmlspecialchars($user['phone_number']) ?></a>
      </div>
      <div class="divider"></div>

      <div class="d-flex align-items-start">
        <i class="fas fa-location-dot me-2 pt-1"></i>
        <span class="text-info-custom">Idi Seke, Osogbo, Osun State.</span>
      </div>
      <div class="divider"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
