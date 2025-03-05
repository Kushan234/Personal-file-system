<?php
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;

$query = "SELECT current_appo_date FROM users WHERE employee_id = $employee_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
} else {
    echo json_encode(['current_appo_date' => '']); 
}
?>
