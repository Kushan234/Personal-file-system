<?php
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST['employee-id'];
    $acom1 = $_POST['acom1'];
    $acom2 = $_POST['acom2'];
    $acom3 = $_POST['acom3'];
    $alan = $_POST['alan'];

    $stmt = $conn->prepare("INSERT INTO activity (employee_id, acom1, acom2, acom3, alan) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $employeeId, $acom1, $acom2, $acom3, $alan);

    if ($stmt->execute()) {
        header("Location: /Personnel-File-Management-System/activity.html?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
