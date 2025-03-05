<?php
include 'database.php';

if (isset($_GET['employee_id'])) {
    $employee_id = filter_var($_GET['employee_id'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("SELECT increment_date FROM users WHERE employee_id = ?");
    if ($stmt === false) {
        echo json_encode(['error' => $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['exists' => true, 'increment_date' => $row['increment_date']]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No employee ID provided']);
}

$conn->close();
?>