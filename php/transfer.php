<?php
include 'database.php'; 

$stmt = $conn->prepare("INSERT INTO transfers (employee_id, transfer_date, post, previous_workplace) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ssss", $employee_id, $transfer_date, $post, $previous_workplace);

$employee_id = $_POST['employee-id'];
$transfer_date = $_POST['current_appo_date'];
$post = $_POST['posts'];
$previous_workplace = $_POST['earlywp'];


if ($stmt->execute()) {
    header("Location: /Personnel-File-Management-System/transfer.html?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
