<?php
include 'database.php';

if (isset($_GET['employee-id'])) {
    $employee_id = filter_var($_GET['employee-id'], FILTER_SANITIZE_STRING);

    $sql = "SELECT increment_date FROM users WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $stmt->bind_result($increment_date);
    $stmt->fetch();

    echo json_encode(['increment_date' => $increment_date]);

    $stmt->close();
}

$conn->close();
?>