<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "SELECT can_edit_profiles FROM login WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($can_edit_profiles);
    $stmt->fetch();
    $stmt->close();

    $new_permission_status = !$can_edit_profiles; // Toggle permission status

    $sql_update = "UPDATE login SET can_edit_profiles = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $new_permission_status, $user_id);

    if ($stmt_update->execute()) {
        $message = $new_permission_status ? "Permission granted!" : "Permission revoked!";
        echo json_encode(['status' => 'success', 'message' => $message, 'can_edit_profiles' => $new_permission_status]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error: Could not update permission."]);
    }
    $stmt_update->close();
    $conn->close();
}
?>