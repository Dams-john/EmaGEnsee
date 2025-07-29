<?php
include 'db.php';
$latest = $conn->query("SELECT * FROM history ORDER BY id DESC LIMIT 1");
$row = $latest->fetch_assoc();
$lat = $row['latitude'];
$lng = $row['longitude'];
$address = $row['address'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Active Incident</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    #map { height: 450px; width: 100%; border-radius: 8px; margin-top: 10px; }
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
<body class="bg-light">
  <div class="d-flex align-items-center px-3 py-2 border-bottom bg-white">
    <h6 class="mb-0 fw-bold flex-grow-1">Active Incident</h6>
  </div>
  <div class="container mt-3">
    <div class="mb-2"><strong>Address:</strong> <?= htmlspecialchars($address) ?></div>
    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const lat = <?= $lat ?>;
    const lng = <?= $lng ?>;

    const map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);
    L.marker([lat, lng]).addTo(map)
      .bindPopup("🚨 Emergency reported here")
      .openPopup();
  </script>
</body>
</html>

