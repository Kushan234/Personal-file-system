<?php
include 'database.php';

header('Content-Type: application/json');

$sql = "SELECT COUNT(*) as permanent_count FROM users WHERE permanent = 'ස්ථීර'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['permanent_count' => $row['permanent_count']]);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>