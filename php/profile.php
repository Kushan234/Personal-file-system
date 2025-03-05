<?php
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? mysqli_real_escape_string($conn, $_GET['employee_id']) : '';

$query = "SELECT * FROM users WHERE employee_id = '$employee_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .edit-container-header img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }
       
        .form-control {
            border: none;
            background-color: transparent;
            color: #000;
            outline: none;
            pointer-events: none; 
        }
        
        .form-control.enabled {
            border: 1px solid #ced4da;
            background-color: #fff;
            pointer-events: auto; 
        }
        
        .image-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
        
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .change-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            display: none;
            cursor: pointer;
        }
        
        .image-container:hover .change-icon {
            display: block;
        }
        
        @media print {
            button {
                display: none !important;
            }
        
            button, select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none; 
            }
        }
        </style>
</head>
<body>
    <div class="container">
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="employee_id" value="<?php echo $user['employee_id']; ?>">
        <input type="hidden" name="appointment_date" value="<?php echo $user['appointment_date']; ?>">
        <div class="row edit-container">
            <div class="col-md-4 text-center edit-container-header my-5">
                <div class="image-container">
                    <img src="/Personnel-File-Management-System/<?php echo $user['photo']; ?>" alt="Profile Image" class="img-fluid mt-2" id="currentPhoto">
                    <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                    <div class="change-icon" id="changeIcon">
                        <img src="/Personnel-File-Management-System/img/pic.png" class="">
                    </div>
                </div>

                    <div class="form-group">
                        <label for="name1" class="mt-3">නම</label>
                        <input type="text" class="form-control" id="name1" name="name1" value="<?php echo $user['name1']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="position">තනතුර</label>
                            <input class="form-control" list="positions" id="position" name="position" 
                            value="<?php echo htmlspecialchars($user['position']); ?>" required>
                        
                        
                        <datalist id="positions">
                            <option value="ශ්‍රි ලංකා පරිපාලන සේවය විශේෂ පන්තිය"></option>
                            <option value="ශ්‍රි ලංකා පරිපාලන සේවය"></option>
                            <option value="ක්‍රමසම්පාදන සේවය"></option>
                            <option value="ශ්‍රි ලංකා ගණකාධිකාරි සේවය"></option>
                            <option value="කළමනාකරණ අධිශ්‍රේණිය"></option>
                            <option value="කළමනාකරණ සේවා නිලධාරී"></option>
                            <option value="සංවර්ධන නිලධාරී"></option>
                            <option value="තොරතුරු හා සංනිවේදන නිලධාරී"></option>
                            <option value="සංස්කෘතික නිලධාරී"></option>
                        </datalist>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-warning mt-2 mx-2" id="editButton">Edit</button>
                        <button type="submit" class="btn btn-info mt-2 mx-2" id="saveButton" disabled>Save</button>
                        <button type="button" class="btn btn-danger mt-2 mx-2" id="deleteButton">Delete</button>
                        <button type="button" class="btn btn-secondary mt-2 mx-2" id="printButton" onclick="window.print();"><img src="/Personnel-File-Management-System/img/print.png" alt="icon" style= "width:24px; height:24px;"></button>
                        <button type="button" class="btn btn-danger mt-2 mx-2" id="reqButton">Request</button>
                    </div>
            </div>
                <div class="col-md-8 edit-container-details my-5">
                    <div class="form-group">
                        <label for="nic">ජා.හැ.අංකය</label>
                        <input type="text" class="form-control" id="nic" name="nic" value="<?php echo $user['nic']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address1">ලිපිනය</label>
                        <input type="text" class="form-control" id="address1" name="address1" value="<?php echo $user['address1']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="dob">උපන් දිනය</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $user['dob']; ?>" disabled>
                    </div>
                    <div class="form-group">
                    <label for="gender">ස්ත්‍රී / පුරුෂ</label>
                      <select class="form-control" id="gender" name="gender" disabled>
                     <option value="ස්ත්‍රී" <?php if($user['gender'] == 'ස්ත්‍රී') echo 'selected'; ?>>ස්ත්‍රී</option>
                      <option value="පුරුෂ" <?php if($user['gender'] == 'පුරුෂ') echo 'selected'; ?>>පුරුෂ</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="status1">විවාහක / අවිවාහක</label>
                        <select class="form-control" id="status1" name="status1" disabled>
                            <option value="විවාහක" <?php if($user['status1'] == 'විවාහක') echo 'selected'; ?>>විවාහක</option>
                            <option value="අවිවාහක" <?php if($user['status1'] == 'අවිවාහක') echo 'selected'; ?>>අවිවාහක</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">දුරකථන අංකය</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $user['whatsapp']; ?>" disabled>
                    </div>
                    <!-- <div class="form-group">
                        <label for="appointment_date">APPOINTMENT DATE:</label>
                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo $user['appointment_date']; ?>" disabled>
                    </div> -->
                    <div class="form-group">
                        <label for="current_appo_date">අමාත්‍යාංශයට පත්වූ දිනය</label>
                        <input type="date" class="form-control" id="current_appo_date" name="current_appo_date" value="<?php echo $user['current_appo_date']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="permanent">ස්ථීර ද නැද්ද යන්න</label>
                        <select class="form-control" id="permanent" name="permanent" disabled>
                            <option value="ස්ථීර" <?php if($user['permanent'] == 'ස්ථීර') echo 'selected'; ?>>ස්ථීර</option>
                            <option value="ස්ථීර නැත" <?php if($user['permanent'] == 'ස්ථීර නැත') echo 'selected'; ?>>ස්ථීර නැත</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="grade">ශ්‍රේණිය</label>
                        <select class="form-control" id="grade" name="grade" disabled>
                            <option value="𝐈 ශ්‍රේණිය" <?php if($user['grade'] == '𝐈 ශ්‍රේණිය') echo 'selected'; ?>>𝐈 ශ්‍රේණිය</option>
                            <option value="𝐈𝐈 ශ්‍රේණිය" <?php if($user['grade'] == '𝐈𝐈 ශ්‍රේණිය') echo 'selected'; ?>>𝐈𝐈 ශ්‍රේණිය</option>
                            <option value="𝐈𝐈𝐈 ශ්‍රේණිය" <?php if($user['grade'] == '𝐈𝐈𝐈 ශ්‍රේණිය') echo 'selected'; ?>>𝐈𝐈𝐈 ශ්‍රේණිය</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="salary_code">වැටුප් කේතය</label>
                        <select class="form-control" id="salary_code" name="salary_code" disabled>
                            <option value="SL-1" <?php if($user['salary_code'] == 'SL-1') echo 'selected'; ?>>SL-1</option>
                            <option value="MN-7" <?php if($user['salary_code'] == 'MN-7') echo 'selected'; ?>>MN-7</option>
                            <option value="MN-5" <?php if($user['salary_code'] == 'MN-5') echo 'selected'; ?>>MN-5</option>
                            <option value="MN-4" <?php if($user['salary_code'] == 'MN-4') echo 'selected'; ?>>MN-4</option>
                            <option value="MN-2" <?php if($user['salary_code'] == 'MN-2') echo 'selected'; ?>>MN-2</option>
                            <option value="MT-1" <?php if($user['salary_code'] == 'MT-1') echo 'selected'; ?>>MT-1</option>
                            <option value="PL-1" <?php if($user['salary_code'] == 'PL-1') echo 'selected'; ?>>PL-1</option>
                            <option value="PL-2" <?php if($user['salary_code'] == 'PL-2') echo 'selected'; ?>>PL-2</option>
                            <option value="PL-3" <?php if($user['salary_code'] == 'PL-3') echo 'selected'; ?>>PL-3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="increment_date">වැටුප් වර්ධක දිනය</label>
                        <input type="date" class="form-control" id="increment_date" name="increment_date" value="<?php echo $user['increment_date']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="efficiency_bar">කාර්යක්ෂමතාව</label>
                        <select class="form-control" id="efficiency_bar" name="efficiency_bar" disabled>
                            <option value="𝐈" <?php if($user['efficiency_bar'] == '𝐈') echo 'selected'; ?>>𝐈</option>
                            <option value="𝐈𝐈" <?php if($user['efficiency_bar'] == '𝐈𝐈') echo 'selected'; ?>>𝐈𝐈</option>
                            <option value="𝐈𝐈𝐈" <?php if($user['efficiency_bar'] == '𝐈𝐈𝐈') echo 'selected'; ?>>𝐈𝐈𝐈</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Diciplinary_investigations">විනය පරීක්ෂණ විගනන පරීක්ෂණ පවතිනවාද නැද්ද යන වග</label>
                        <select class="form-control" id="Diciplinary_investigations" name="Diciplinary_investigations" disabled>
                            <option value="ඔව්" <?php if($user['Diciplinary_investigations'] == 'ඔව්') echo 'selected'; ?>>ඔව්</option>
                            <option value="නැත" <?php if($user['Diciplinary_investigations'] == 'නැත') echo 'selected'; ?>>නැත</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_transfer">ස්ථානමාරුවට යටත්වන දිනය</label>
                        <input type="date" class="form-control" id="date_transfer" name="date_transfer" value="<?php echo $user['date_transfer']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="retirement_date">විශ්‍රාම යන දිනය</label>
                        <input type="date" class="form-control" id="retirement_date" name="retirement_date" value="<?php echo $user['retirement_date']; ?>" disabled>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
    <script>


        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === '1') {
            alert('Profile updated successfully!');

            const currentUrl = window.location.href.split('?')[0]; 
            window.history.replaceState({}, document.title, currentUrl);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const canEditProfiles = localStorage.getItem('can_edit_profiles');
            const userType = localStorage.getItem('user_type');
            
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const deleteButton = document.getElementById('deleteButton');
            const reqButton = document.getElementById('reqButton');
            const printButton = document.getElementById('printButton');

            if (userType === 'Admin' || canEditProfiles === '1') {
                editButton.style.display = 'inline-block';
                saveButton.style.display = 'inline-block';
                deleteButton.style.display = 'inline-block';
                reqButton.style.display = 'none';
                printButton.style.display = 'inline-block';
            } else if (canEditProfiles === '1') {
                editButton.style.display = 'inline-block';
                saveButton.style.display = 'inline-block';
                deleteButton.style.display = 'inline-block';
                reqButton.style.display = 'none';
                printButton.style.display = 'inline-block';
            } else {
                editButton.style.display = 'none';
                saveButton.style.display = 'none';
                deleteButton.style.display = 'none';
                reqButton.style.display = 'inline-block';
                printButton.style.display = 'inline-block';
            }
        });

        document.getElementById('changeIcon').style.pointerEvents = 'none'; 
        document.getElementById('changeIcon').style.opacity = '0';

        document.getElementById('editButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('.form-control');
            inputs.forEach(function(input) {
                input.disabled = false;
                input.classList.add('enabled');
            });
            document.getElementById('saveButton').disabled = false;
            document.getElementById('photo').disabled = false;
            document.getElementById('changeIcon').style.pointerEvents = 'auto';
            document.getElementById('changeIcon').style.opacity = '1';
        });

        document.getElementById('deleteButton').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete_profile.php';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'employee_id';
                input.value = '<?php echo $employee_id; ?>';

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });

        document.getElementById('reqButton').addEventListener('click', function() {
            var username = localStorage.getItem('name');
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_alert.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert('Request sent to admin.');
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            };
            xhr.send('username=' + encodeURIComponent(username));
        });

        document.getElementById("changeIcon").addEventListener("click", function () {
            document.getElementById("photo").click();
        });

        document.getElementById("photo").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("currentPhoto").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

    </script>
</body>
</html>
