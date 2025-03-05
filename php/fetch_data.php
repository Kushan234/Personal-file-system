<?php

include 'database.php'; 


function searchProducts($query) {
    global $conn;
    $query = $conn->real_escape_string($query);
    $sql = "SELECT * FROM users WHERE name LIKE '%'";
    $result = $conn->query($sql);
    
    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    
    return $users;
}