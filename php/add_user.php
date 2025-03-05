<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $sql = "INSERT INTO login (user_type, name, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_type, $username, $password);

    try {
        if ($stmt->execute()) {
            echo "User added successfully!";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { 
            echo "Username already exists!";
        } else {
            echo "Error: Could not add user.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
