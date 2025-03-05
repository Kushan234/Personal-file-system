<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT id, user_type, name, can_edit_profiles FROM login WHERE user_type = 'User'";
    $result = $conn->query($sql);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $buttonClass = ($row['can_edit_profiles'] == 1) ? 'btn-danger' : 'btn-success';
            $buttonText = ($row['can_edit_profiles'] == 1) ? 'Revoke Permission' : 'Give Permission';

            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['user_type']) . "</td>
                    <td>
                        <button class='btn btn-sm $buttonClass give-permission' data-id='" . htmlspecialchars($row['id']) . "'>" . 
                            $buttonText . 
                        "</button>
                    </td>
                    <td>
                        <button class='btn btn-sm btn-danger delete-user' data-id='" . htmlspecialchars($row['id']) . "'>Delete</button>
                    </td>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No users found.</td></tr>";
    }

    $conn->close();
}
?>
