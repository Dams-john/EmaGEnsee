<?php
include 'conn/conn.php';
$result = $conn->query("SELECT latitude, longitude, address FROM history WHERE remark = 'Active'");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
