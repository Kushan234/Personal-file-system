const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const subButton = document.querySelector('.btn-submit')
const steps = document.querySelectorAll('.step');
const form_steps = document.querySelectorAll('.form-step');
let active = 1;

nextButton.addEventListener('click', () => {
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateprogress();
});

prevButton.addEventListener('click', () => {
    active--;
    if (active < 1) {
        active = 1;
    }
    updateprogress();
});

const updateprogress = () => {
    console.log('steps.length => ' + steps.length);
    console.log('active => ' + active);

    steps.forEach((step, i) => {
        if (i == (active - 1)) {
            step.classList.add('active');
            form_steps[i].classList.add('active');
            console.log('i => ' + i);
        } else {
            step.classList.remove('active');
            form_steps[i].classList.remove('active');
        }
    });

    if (active === 1) {
        prevButton.disabled = true;
        nextButton.disabled=false;
        subButton.disabled=true;
    } else if (active === steps.length) {
        nextButton.disabled = true;
        prevButton.disabled=false;
        subButton.disabled=false;
    } else {
        prevButton.disabled = false;
        nextButton.disabled = false;
    }
}

$(document).ready(function() {
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        
        let username = $('#username').val();
        let password = $('#password').val();
        let userType = $('#user_type').val();

        $.ajax({
            url: 'php/add_user.php',
            type: 'POST',
            data: { name: username, password: password, user_type: userType },
            success: function(response) {
                alert(response);
                $('#addUserForm')[0].reset();
                loadUsers();
            }
        });
    });

    function loadUsers() {
        $.ajax({
            url: 'php/get_user.php',
            type: 'GET',
            success: function(data) {
                $('#userTable').html(data);
            }
        });
    }

    $(document).on('click', '.give-permission', function() {
        let userId = $(this).data('id');
        
        $.ajax({
            url: 'php/give_permission.php',
            type: 'POST',
            data: { user_id: userId },
            success: function(response) {
                alert(response);
                loadUsers();
            }
        });
    });

    $(document).on('click', '.delete-user', function() {
        if (confirm('Are you sure you want to delete this user?')) {
            let userId = $(this).data('id');

            $.ajax({
                url: 'php/delete_user.php',
                type: 'POST',
                data: { user_id: userId },
                success: function(response) {
                    alert(response);
                    loadUsers();
                }
            });
        }
    });

    loadUsers();
});

$(document).ready(function() {
$('#changePasswordForm').on('submit', function(e) {
e.preventDefault();

let username = $('#change_username').val();
let currentPassword = $('#old_password').val(); 
let newPassword = $('#new_password').val();

$.ajax({
    url: 'php/change_password.php',
    type: 'POST',
    data: {
        username: username,
        current_password: currentPassword,
        new_password: newPassword 
    },
    success: function(response) {
        alert(response);
        $('#changePasswordForm')[0].reset();
    }
});
});
});