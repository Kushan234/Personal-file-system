<?php
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST['employee-id'];
    $class = $_POST['classi'];
    $class1 = $_POST['class1'];
    $class2 = $_POST['class2'];
    $class3 = $_POST['classp'];

    $stmt = $conn->prepare("INSERT INTO promotions (employee_id, class, class1_date, class2_date, class3_date) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $employeeId, $class, $class1, $class2, $class3);

    if ($stmt->execute()) {
        header("Location: /Personnel-File-Management-System/promotions.html?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
