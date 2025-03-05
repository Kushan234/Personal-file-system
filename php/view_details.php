<?php
include 'database.php';

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    } else {
        $action = 'view';
    }

    if ($action === 'view') {
        $employeeId = sanitize_input($_POST['employee-id']);
        $option = sanitize_input($_POST['option1']);

        $employeeQuery = "SELECT name1 FROM users WHERE employee_id = ?";
        $employeeStmt = $conn->prepare($employeeQuery);
        $employeeStmt->bind_param("s", $employeeId);
        $employeeStmt->execute();
        $employeeResult = $employeeStmt->get_result();

        if ($employeeResult->num_rows > 0) {
            $employeeRow = $employeeResult->fetch_assoc();
            $employeeName = $employeeRow['name1'];
        } else {
            die("<p>No employee found with ID: $employeeId.</p>");
        }

        switch ($option) {
            case 'salary_increment':
                $table = 'salary_increments';
                $primaryKey = 'id'; 
                break;
            case 'promotion':
                $table = 'promotions';
                $primaryKey = 'id'; 
                break;
            case 'efficiency':
                $table = 'activity';
                $primaryKey = 'id'; 
                break;
            case 'transfer':
                $table = 'transfers';
                $primaryKey = 'id'; 
                break;
            default:
                die("Invalid option selected.");
        }

        $stmt = $conn->prepare("SELECT * FROM $table WHERE employee_id = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $employeeId);
        $stmt->execute();
        $result = $stmt->get_result();
    } elseif ($action === 'save') {
        $option = sanitize_input($_POST['option']);
        $employeeId = sanitize_input($_POST['employee_id']);
        $recordId = sanitize_input($_POST['record_id']);

        switch ($option) {
            case 'salary_increment':
                $fields = [
                    'increment_date' => sanitize_input($_POST['increment_date']),
                    'increment_active' => sanitize_input($_POST['increment_active']),
                    'reduction_duration' => sanitize_input($_POST['reduction_duration']),
                    'temporary_suspension' => sanitize_input($_POST['temporary_suspension']),
                    'permanent_suspension' => sanitize_input($_POST['permanent_suspension']),
                    'suspension_duration' => sanitize_input($_POST['suspension_duration']),
                    'increment_reduction' => sanitize_input($_POST['increment_reduction']),
                ];
                $sql = "UPDATE salary_increments SET increment_date = ?, increment_active = ?, reduction_duration = ?, temporary_suspension = ?, permanent_suspension = ?, suspension_duration = ?, increment_reduction = ? WHERE id = ? AND employee_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssssss", 
                    $fields['increment_date'], 
                    $fields['increment_active'], 
                    $fields['reduction_duration'], 
                    $fields['temporary_suspension'], 
                    $fields['permanent_suspension'], 
                    $fields['suspension_duration'], 
                    $fields['increment_reduction'], 
                    $recordId, 
                    $employeeId
                );
                break;

            case 'promotion':
                $fields = [
                    'class' => sanitize_input($_POST['class']),
                    'class1_date' => sanitize_input($_POST['class1_date']),
                    'class2_date' => sanitize_input($_POST['class2_date']),
                    'class3_date' => sanitize_input($_POST['class3_date']),
                ];
                $sql = "UPDATE promotions SET class = ?, class1_date = ?, class2_date = ?, class3_date = ? WHERE id = ? AND employee_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", 
                    $fields['class'], 
                    $fields['class1_date'], 
                    $fields['class2_date'], 
                    $fields['class3_date'], 
                    $recordId, 
                    $employeeId
                );
                break;

            case 'efficiency':
                $fields = [
                    'acom1' => sanitize_input($_POST['acom1']),
                    'acom2' => sanitize_input($_POST['acom2']),
                    'acom3' => sanitize_input($_POST['acom3']),
                    'alan' => sanitize_input($_POST['alan']),
                ];
                $sql = "UPDATE activity SET acom1 = ?, acom2 = ?, acom3 = ?, alan = ? WHERE id = ? AND employee_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", 
                    $fields['acom1'], 
                    $fields['acom2'], 
                    $fields['acom3'], 
                    $fields['alan'], 
                    $recordId, 
                    $employeeId
                );
                break;

            case 'transfer':
                $fields = [
                    'transfer_date' => sanitize_input($_POST['transfer_date']),
                    'post' => sanitize_input($_POST['op']),
                    'previous_workplace' => sanitize_input($_POST['previous_workplace']),
                ];
                $sql = "UPDATE transfers SET transfer_date = ?, post = ?, previous_workplace = ? WHERE id = ? AND employee_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", 
                    $fields['transfer_date'], 
                    $fields['post'], 
                    $fields['previous_workplace'], 
                    $recordId, 
                    $employeeId
                );
                break;

            default:
                die("Invalid option selected for update.");
        }

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record updated successfully.');
                    window.location.href = '/Personnel-File-Management-System/Additional.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to update record: " . $stmt->error . "');
                    window.location.href = '/Personnel-File-Management-System/Additional.html';
                  </script>";
        }

    } elseif ($action === 'delete') {
        $option = sanitize_input($_POST['option']);
        $employeeId = sanitize_input($_POST['employee_id']);
        $recordId = sanitize_input($_POST['record_id']);

        switch ($option) {
            case 'salary_increment':
                $table = 'salary_increments';
                break;
            case 'promotion':
                $table = 'promotions';
                break;
            case 'efficiency':
                $table = 'activity';
                break;
            case 'transfer':
                $table = 'transfers';
                break;
            default:
                die("Invalid option selected for deletion.");
        }

        $sql = "DELETE FROM $table WHERE id = ? AND employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $recordId, $employeeId);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record deleted successfully.');
                    window.location.href = '/Personnel-File-Management-System/Additional.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to delete record: " . $stmt->error . "');
                    window.location.href = '/Personnel-File-Management-System/Additional.html';
                  </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assests/bootstrap/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Employee Information</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0px auto;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h4 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .info-card h3 {
            color: #007BFF;
            margin-bottom: 25px;
            font-size: 26px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group label {
            flex: 0 0 260px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input[type='text'],
        .form-group input[type='date'],
        .op {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input[type='text']:focus,
        .form-group input[type='date']:focus, 
        .op:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .input-edit {
            background-color: #fff8e1;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            color: #fff;
        }

        .btn-edit {
            background-color: #007BFF;
        }

        .btn-save {
            background-color: #28a745;
            cursor: not-allowed;
        }

        .btn-del {
            background-color: #dc3545;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-save.enabled {
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-group label {
                flex: none;
                width: 100%;
                margin-bottom: 8px;
            }

            .form-group input[type='text'],
            .form-group input[type='date'] {
                width: 100%;
            }

            .btn-container {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
        .input-edit {
            background-color: #e8f0fe; 
            transition: border 0.3s, background-color 0.3s;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($employeeName)): ?>
            <h4>සේවක තොරතුරු</h4>
            <p>සේවකයාගේ නම: <span><?php echo htmlspecialchars($employeeName); ?></span></p>
            <?php if ($result->num_rows > 0) {
            } else {
                echo "<p>No data to show</p>";
            }?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $recordId = $row['id']; 
                ?>
                <form method="POST" class="info-card">
                    <input type="hidden" name="action" value="view"> 
                    <input type="hidden" name="employee-id" value="<?php echo htmlspecialchars($employeeId); ?>">
                    <input type="hidden" name="option1" value="<?php echo htmlspecialchars($option); ?>">

                    <input type="hidden" name="record_id" value="<?php echo htmlspecialchars($recordId); ?>">
                    <input type="hidden" name="option" value="<?php echo htmlspecialchars($option); ?>">
                    <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employeeId); ?>">

                    <?php
                    switch ($option) {
                        case 'salary_increment':
                            ?>
                            <h3>වැටුප් වර්ධක තොරතුරු</h3>
                            <div class="form-group">
                                <label for="increment_date">වැටුප් වර්ධක දිනය:</label>
                                <input type="date" name="increment_date" value="<?php echo htmlspecialchars($row['increment_date']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="increment_active">වැටුප් වර්ධක නවතා තිබේද:</label>
                                <select id="increment_active" name="increment_active" class="op form-control" required disabled>
                                    <option value="ඔව්" <?php if ($row['increment_active'] == "ඔව්") echo 'selected'; ?>>ඔව්</option>
                                    <option value="නැත" <?php if ($row['increment_active'] == "නැත") echo 'selected'; ?>>නැත</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="increment_active">වැටුප් වර්ධක අඩු කිරීම:</label>
                                <input type="text" name="increment_reduction" value="<?php echo htmlspecialchars($row['increment_reduction']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="reduction_duration">වැටුප් වර්ධක නවතා ඇති කාල සීමාව:</label>
                                <input type="text" name="reduction_duration" value="<?php echo htmlspecialchars($row['reduction_duration']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="temporary_suspension">වැටුප් වර්ධක තාවකාලිකව නතර කිරීම:</label>
                                <input type="text" name="temporary_suspension" value="<?php echo htmlspecialchars($row['temporary_suspension']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="permanent_suspension">වැටුප් වර්ධක ස්ථීරව නවතා තිබේද:</label>
                                <select id="permanent_suspension" name="permanent_suspension" class="op" required disabled>
                                    <option value="ඔව්" <?php if ($row['permanent_suspension'] == "ඔව්") echo 'selected'; ?>>ඔව්</option>
                                    <option value="නැත" <?php if ($row['permanent_suspension'] == "නැත") echo 'selected'; ?>>නැත</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="suspension_duration">ස්ථීරව නවතා ඇති කාල සීමාව:</label>
                                <input type="text" name="suspension_duration" value="<?php echo htmlspecialchars($row['suspension_duration']); ?>" disabled>
                            </div>
                            <?php
                            break;

                        case 'promotion':
                            ?>
                            <h3>උසස්වීම් තොරතුරු</h3>
                            <div class="form-group">
                                <label for="class">ශ්‍රේණිය:</label>
                                <select id="class" name="class" class="op" required disabled>
                                    <option value="𝐈 ශ්‍රේණිය" <?php if ($row['class'] == "𝐈 ශ්‍රේණිය") echo 'selected'; ?>>𝐈 ශ්‍රේණිය</option>
                                    <option value="𝐈𝐈 ශ්‍රේණිය" <?php if ($row['class'] == "𝐈𝐈 ශ්‍රේණිය") echo 'selected'; ?>>𝐈𝐈 ශ්‍රේණිය</option>
                                    <option value="𝐈𝐈𝐈 ශ්‍රේණිය" <?php if ($row['class'] == "𝐈𝐈𝐈 ශ්‍රේණිය") echo 'selected'; ?>>𝐈𝐈𝐈 ශ්‍රේණිය</option>
                                    <option value="විශේෂ ශ්‍රේණිය" <?php if ($row['class'] == "විශේෂ ශ්‍රේණිය") echo 'selected'; ?>>විශේෂ ශ්‍රේණිය</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="class1_date">𝐈 ශ්‍රේණියට උසස් කල දිනය:</label>
                                <input type="date" name="class1_date" value="<?php echo htmlspecialchars($row['class1_date']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="class2_date">𝐈𝐈 ශ්‍රේණියට උසස් කල දිනය:</label>
                                <input type="date" name="class2_date" value="<?php echo htmlspecialchars($row['class2_date']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="class3_date">විශේෂ ශ්‍රේණියට උසස් කල දිනය:</label>
                                <input type="date" name="class3_date" value="<?php echo htmlspecialchars($row['class3_date']); ?>" disabled>
                            </div>
                            <?php
                            break;

                        case 'efficiency':
                            ?>
                            <h3>කාර්යක්ෂමතා කඩඉම තොරතුරු</h3>
                            <div class="form-group">
                                <label for="acom1">𝐈 කාර්යක්ෂමතාව සම්පූර්ණ කල දිනය:</label>
                                <input type="date" name="acom1" value="<?php echo htmlspecialchars($row['acom1']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="acom2">𝐈𝐈 කාර්යක්ෂමතාව සම්පූර්ණ කල දිනය:</label>
                                <input type="date" name="acom2" value="<?php echo htmlspecialchars($row['acom2']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="acom3">𝐈𝐈𝐈 කාර්යක්ෂමතාව සම්පූර්ණ කල දිනය:</label>
                                <input type="date" name="acom3" value="<?php echo htmlspecialchars($row['acom3']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="alan">භාෂා ප්‍රවීණතාවය සම්පූර්ණ කල දිනය:</label>
                                <input type="date" name="alan" value="<?php echo htmlspecialchars($row['alan']); ?>" disabled>
                            </div>
                            <?php
                            break;

                        case 'transfer':
                            ?>
                            <h3>ස්ථාන මාරු තොරතුරු</h3>
                            <div class="form-group">
                                <label for="transfer_date">ක්‍රීඩා අමාත්‍යාංශයට පැමිණි දිනය:</label>
                                <input type="date" name="transfer_date" value="<?php echo htmlspecialchars($row['transfer_date']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="op">තනතුර:</label>
                                <select id="op" name="op" class="op" required disabled>
                                    <option value="ශ්‍රි ලංකා පරිපාලන සේවය විශේෂ පන්තිය" <?php if ($row['post'] == "ශ්‍රි ලංකා පරිපාලන සේවය විශේෂ පන්තිය") echo 'selected'; ?>>ශ්‍රි ලංකා පරිපාලන සේවය විශේෂ පන්තිය</option>
                                    <option value="ශ්‍රි ලංකා පරිපාලන සේවය" <?php if ($row['post'] == "ශ්‍රි ලංකා පරිපාලන සේවය") echo 'selected'; ?>>ශ්‍රි ලංකා පරිපාලන සේවය</option>
                                    <option value="ක්‍රමසම්පාදන සේවය" <?php if ($row['post'] == "ක්‍රමසම්පාදන සේවය") echo 'selected'; ?>>ක්‍රමසම්පාදන සේවය</option>
                                    <option value="ශ්‍රි ලංකා ගණකාධිකාරි සේවය" <?php if ($row['post'] == "ශ්‍රි ලංකා ගණකාධිකාරි සේවය") echo 'selected'; ?>>ශ්‍රි ලංකා ගණකාධිකාරි සේවය</option>
                                    <option value="කළමනාකරණ අධිශ්‍රේණිය" <?php if ($row['post'] == "කළමනාකරණ අධිශ්‍රේණිය") echo 'selected'; ?>>කළමනාකරණ අධිශ්‍රේණිය</option>
                                    <option value="කළමනාකරණ සේවා නිලධාරී" <?php if ($row['post'] == "කළමනාකරණ සේවා නිලධාරී") echo 'selected'; ?>>කළමනාකරණ සේවා නිලධාරී</option>
                                    <option value="සංවර්ධන නිලධාරී" <?php if ($row['post'] == "සංවර්ධන නිලධාරී") echo 'selected'; ?>>සංවර්ධන නිලධාරී</option>
                                    <option value="තොරතුරු හා සංනිවේදන නිලධාරී" <?php if ($row['post'] == "තොරතුරු හා සංනිවේදන නිලධාරී") echo 'selected'; ?>>තොරතුරු හා සංනිවේදන නිලධාරී</option>
                                    <option value="සංස්කෘතික නිලධාරී" <?php if ($row['post'] == "සංස්කෘතික නිලධාරී") echo 'selected'; ?>>සංස්කෘතික නිලධාරී</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="previous_workplace">පෙර සේවා ස්ථානය:</label>
                                <input type="text" name="previous_workplace" value="<?php echo htmlspecialchars($row['previous_workplace']); ?>" disabled>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                    <div class="btn-container">
                        <button id="editBtn" type="button" class="btn btn-edit" onclick='enableInputs(this)'>Edit</button>
                        <button id="saveBtn" type="submit" name="action" value="save" class="btn btn-save" disabled>Save</button>
                        <button id="delBtn" type="submit" name="action" value="delete" class="btn btn-del" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                    </div>
                </form>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canEditProfiles = localStorage.getItem('can_edit_profiles');
            const userType = localStorage.getItem('user_type');
            
            const editButton = document.getElementById('editBtn');
            const saveButton = document.getElementById('saveBtn');
            const deleteButton = document.getElementById('delBtn');

            if (userType === 'Admin') {
                editButton.style.display = 'inline-block';
                saveButton.style.display = 'inline-block';
                deleteButton.style.display = 'inline-block';
            } else if (canEditProfiles === '1') {
                editButton.style.display = 'inline-block';
                saveButton.style.display = 'inline-block';
                deleteButton.style.display = 'inline-block';
            } else {
                editButton.style.display = 'none';
                saveButton.style.display = 'none';
                deleteButton.style.display = 'none';
            }
        });

        function enableInputs(editBtn) {
            var card = editBtn.closest('.info-card');
            var inputs = card.querySelectorAll('input[type=text], input[type=date],select');
            var saveBtn = card.querySelector('.btn-save');

            inputs.forEach(function(input) {
                input.disabled = false;
                input.classList.add('input-edit'); 
            });

            saveBtn.disabled = false;
            saveBtn.classList.add('enabled'); 
        }
    </script>
</body>
</html>
