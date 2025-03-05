<?php

include 'database.php'; 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS user_count FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['user_count' => $row['user_count']]);
} else {
    echo json_encode(['user_count' => 0]);
}

$conn->close();
?>