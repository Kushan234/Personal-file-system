<?php
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;

if ($employee_id) {
    $query = "SELECT grade FROM users WHERE employee_id = $employee_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['grade' => $row['grade']]);
    } else {
        echo json_encode(['grade' => '']);
    }
} else {
    echo json_encode(['grade' => '']);
}
?>
