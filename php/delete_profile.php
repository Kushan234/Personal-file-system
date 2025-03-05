<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = isset($_POST['employee_id']) ? mysqli_real_escape_string($conn, $_POST['employee_id']) : '';

    if (!empty($employee_id)) {
        $query = "DELETE FROM users WHERE employee_id = ?";

        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $employee_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Record deleted successfully!');
                    window.location.href = '/Personnel-File-Management-System/pcard.html'; // Redirect to the profile list page or wherever appropriate
                </script>";
            } else {
                echo "<script>
                    alert('Error deleting record. Please try again.');
                    window.history.back(); // Redirect back to the previous page
                </script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing the delete query.";
        }
    } else {
        echo "<script>
            alert('No employee ID provided.');
            window.history.back(); // Redirect back to the previous page
        </script>";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
