<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

    $query = "SELECT * FROM login WHERE name = '$username' AND password = '$current_password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $update_query = "UPDATE login SET password = '$new_password' WHERE name = '$username'";
        if (mysqli_query($conn, $update_query)) {
            echo "Password successfully updated!";
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid username or current password!";
    }
}
?>
