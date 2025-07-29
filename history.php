<?php
session_start();
include 'db.php';  

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all emergency records, latest first
$stmt = $conn->prepare("SELECT * FROM history ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
    }

    .container-custom {
      max-width: 500px;
      margin: auto;
      padding: 15px;
    }

    .top-bar {
      justify-content: space-between;
      align-items: center;
      margin-bottom: 70px;
    }

    .history-card {
      background-color: #eaeaea;
      border-radius: 8px;
      padding: 10px 15px;
      margin-bottom: 15px;
    }

    .history-card p {
      margin: 2px 0;
      font-size: 14px;
    }

    .solved {
      color: green;
      font-weight: bold;
    }

    .divider {
      border-top: 1px solid #ccc;
      margin-bottom: 15px;
    }

    .timestamp {
      font-size: 12px;
      color: #555;
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
  <div class="container-custom">
    <div class="top-bar d-flex align-items-center justify-content-between">
      <a href="home.php" class="text-dark"><i class="fas fa-arrow-left"></i></a>
      <h6 class="mb-0"><b>History</b></h6>
      <span></span>
    </div>

    <div class="divider"></div>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="history-card">
          <p><strong>Emergency ID:</strong> <?= htmlspecialchars($row['emergency_id']) ?></p>
          <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
          <p><strong>Distance:</strong> <?= htmlspecialchars($row['distance']) ?></p>
          <p><strong>Remark:</strong> <span class="solved"><?= htmlspecialchars($row['remark']) ?></span></p>
          <p class="timestamp"><i class="fas fa-clock"></i> <?= date("M d, Y - h:i A", strtotime($row['created_at'])) ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-warning text-center">No emergency history found.</div>
    <?php endif; ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
