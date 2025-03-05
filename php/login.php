<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE name=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userType = $row['user_type'];
        $canEditProfiles = $row['can_edit_profiles'];
        $Id = $row['Id']; 
        $name = $row['name']; 

        if ($userType === 'Admin' || $userType === 'User') {
            echo "<script>
                    localStorage.setItem('loggedIn', 'true');
                    localStorage.setItem('user_type', '{$userType}');
                    localStorage.setItem('can_edit_profiles', '{$canEditProfiles}');
                    localStorage.setItem('Id', '{$Id}');
                    localStorage.setItem('name', '{$name}');
                    window.location.href = '/Personnel-File-Management-System/index.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid User Type');
                    window.location.href = '/Personnel-File-Management-System/login.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid Username or Password');
                window.location.href = '/Personnel-File-Management-System/login.html';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
