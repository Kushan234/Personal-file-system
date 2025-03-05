<?php

include 'database.php';

if (isset($_GET['employee_id'])) {
    $employeeId = $_GET['employee_id'];

    $query = "SELECT grade FROM users WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['grade' => $row['grade']]);
    } else {
        echo json_encode(['grade' => '']);
    }

    $stmt->close();
}
?>
