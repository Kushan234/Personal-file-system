<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = filter_var($_POST['employee-id'], FILTER_SANITIZE_STRING);
    $new_increment_date = filter_var($_POST['sinc'], FILTER_SANITIZE_STRING);

    // Prepare SQL query to update increment_date
    $stmt = $conn->prepare("UPDATE users SET increment_date = ? WHERE employee_id = ?");
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $new_increment_date, $employee_id);

    if ($stmt->execute()) {
        header("Location: /Personnel-File-Management-System/salary_form.html?success=1");
        exit();
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>