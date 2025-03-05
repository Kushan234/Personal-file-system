<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'database.php'; 


$sql = "SELECT employee_id, name1, position, appointment_date, nic, dob, address1, email, whatsapp FROM users";


$result = $conn->query($sql);


$employees = [];

if ($result && $result->num_rows > 0) {
   
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($employees);

$conn->close();
?>