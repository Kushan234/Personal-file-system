<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = isset($_POST['employee_id']) ? mysqli_real_escape_string($conn, $_POST['employee_id']) : '';
    $name1 = mysqli_real_escape_string($conn, $_POST['name1']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $app_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $status1 = mysqli_real_escape_string($conn, $_POST['status1']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $current_appo_date = mysqli_real_escape_string($conn, $_POST['current_appo_date']);
    $permanent = mysqli_real_escape_string($conn, $_POST['permanent']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $salary_code = mysqli_real_escape_string($conn, $_POST['salary_code']);
    $increment_date = mysqli_real_escape_string($conn, $_POST['increment_date']);
    $efficiency_bar = mysqli_real_escape_string($conn, $_POST['efficiency_bar']);
    $Diciplinary_investigations = mysqli_real_escape_string($conn, $_POST['Diciplinary_investigations']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $dob_date = new DateTime($dob);
    $dob_date->modify('+60 years');
    $retirement_date = $dob_date->format('Y-m-d');

    $current_appo_date_obj = new DateTime($current_appo_date);
    $current_appo_date_obj->modify('+5 years');
    $date_transfer = $current_appo_date_obj->format('Y-m-d');

    $query = "SELECT photo FROM users WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $employee_id);
    $stmt->execute();
    $stmt->bind_result($current_photo);
    $stmt->fetch();
    $stmt->close();

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        if (!empty($current_photo) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/Personnel-File-Management-System/' . $current_photo)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/Personnel-File-Management-System/' . $current_photo); // Remove old photo
        }

        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/Personnel-File-Management-System/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); 
        }

        $photo_name = time() . '_' . basename($_FILES['photo']['name']);
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_folder = $upload_dir . $photo_name;

        if (move_uploaded_file($photo_tmp_name, $photo_folder)) {
            $relative_path = 'uploads/' . $photo_name;
        } else {
            throw new Exception("Failed to upload new photo.");
        }
    } else {
        $relative_path = $current_photo;
    }

    $stmt = $conn->prepare("UPDATE users SET 
                name1 = ?, position = ?, nic = ?, appointment_date = ?, 
                address1 = ?, gender = ?, status1 = ?, whatsapp = ?, 
                appointment_date = ?, current_appo_date = ?, permanent = ?, 
                grade = ?, salary_code = ?, increment_date = ?, 
                efficiency_bar = ?, Diciplinary_investigations = ?, 
                retirement_date = ?, date_transfer = ?, photo = ? 
                WHERE employee_id = ?");

    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssssss", 
        $name1, $position, $nic, $app_date, $address1, $gender, $status1, 
        $whatsapp, $appointment_date, $current_appo_date, $permanent, 
        $grade, $salary_code, $increment_date, $efficiency_bar, 
        $Diciplinary_investigations, $retirement_date, $date_transfer, 
        $relative_path, $employee_id
    );

    if ($stmt->execute()) {
        header("Location: /Personnel-File-Management-System/php/profile.php?employee_id=" . urlencode($employee_id) . "&success=1");
        exit();
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
?>
