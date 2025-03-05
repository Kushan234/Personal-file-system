<?php
include 'database.php';

$stmt = $conn->prepare("INSERT INTO salary_increments (employee_id, increment_date, increment_active, increment_reduction, reduction_duration, temporary_suspension, permanent_suspension, suspension_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssssss", $employee_id, $increment_date, $increment_active, $increment_reduction, $reduction_duration, $temporary_suspension, $permanent_suspension, $suspension_duration);

$employee_id = $_POST['employee-id'];
$increment_date = $_POST['sinc'];
$increment_active = $_POST['salarys'];
$increment_reduction = $_POST['salaryr'];
$reduction_duration = $_POST['timep'];
$temporary_suspension = $_POST['timetp'];
$permanent_suspension = $_POST['salarysp'];
$suspension_duration = $_POST['timesp'];

if ($stmt->execute()) {

    header("Location: /Personnel-File-Management-System/salary.html?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
