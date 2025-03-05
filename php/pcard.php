<?php
include 'database.php';

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

$profiles = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $profiles[] = $row;
    }
    echo json_encode($profiles);
} else {
    echo json_encode([]);
}
?>
