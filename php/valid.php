<?php
include 'database.php'; 

$employeeId = isset($_GET['employee-id']) ? $_GET['employee-id'] : '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE employee_id = ?");
$stmt->bind_param("s", $employeeId);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

$response = ['exists' => $count > 0];

$stmt->close();
$conn->close();

echo json_encode($response);
?>