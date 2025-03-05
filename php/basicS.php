<?php
include 'database.php';

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $stmt = $conn->prepare("
        SELECT name1, position, current_appo_date, increment_date, grade, efficiency_bar 
        FROM users 
        WHERE name1 LIKE ? 
        OR employee_id LIKE ?");
    
    $searchTerm = "%" . $search . "%"; 
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name1']) . "</td>";
            echo "<td>" . htmlspecialchars($row['position']) . "</td>";
            echo "<td>" . htmlspecialchars($row['current_appo_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['increment_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
            echo "<td>" . htmlspecialchars($row['efficiency_bar']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No results found</td></tr>";
    }
    
    $stmt->close();
}
?>
