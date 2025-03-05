<?php
require 'database.php';

if (isset($_GET['employee_id']) && isset($_GET['table_name'])) {
    $employee_id = $_GET['employee_id'];
    $table_name = $_GET['table_name'];

    $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);

    $stmt = $conn->prepare("SELECT employee_id FROM $table_name WHERE employee_id = ?");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
}
?>
