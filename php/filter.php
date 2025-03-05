<?php
include 'database.php';

$increment_date = isset($_GET['increment_date']) ? $_GET['increment_date'] : '';
$report_date = isset($_GET['report_date']) ? $_GET['report_date'] : '';
$efficiency_bar = isset($_GET['rank']) ? $_GET['rank'] : '';
$pos = isset($_GET['pos']) ? $_GET['pos'] : ''; 

$query = "SELECT  name1, position, current_appo_date,increment_date, grade,efficiency_bar FROM users WHERE 1=1";

if (!empty($increment_date)) {
    $query .= " AND DATE_FORMAT(increment_date, '%Y-%m') = ?";
}
if (!empty($report_date)) {
    $query .= " AND DATE_FORMAT(appointment_date, '%Y-%m') = ?";
}
if (!empty($efficiency_bar)) {
    $query .= " AND efficiency_bar = ?";
}
if (!empty($pos)) {
    $query .= " AND position = ?"; 
}

$stmt = $conn->prepare($query);

$params = [];
$types = "";

if (!empty($increment_date)) {
    $types .= "s";
    $params[] = $increment_date; 
}
if (!empty($report_date)) {
    $types .= "s";
    $params[] = $report_date;
}
if (!empty($efficiency_bar)) {
    $types .= "s";
    $params[] = $efficiency_bar;
}
if (!empty($pos)) {
    $types .= "s";
    $params[] = $pos;
}

if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

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
    echo "<tr><td colspan='7'>No results found</td></tr>";
}

$stmt->close();
?>
