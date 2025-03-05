document.addEventListener('DOMContentLoaded', function () {
    function nextStep(step) {
        console.log(`Navigating to step: ${step}`);
        
        document.querySelectorAll('.form-step').forEach(function (stepDiv) {
            stepDiv.classList.remove('active');
        });

        document.getElementById('step-' + step).classList.add('active');

        if (step === 4) {
            var employeeId = document.getElementById('employee-id');
            var nic = document.getElementById('nic');
            var name = document.getElementById('name');
            var option1 = document.getElementById('option1');
            var option2 = document.getElementById('option2');
            var option3 = document.getElementById('option3');
            var option4 = document.getElementById('option4');
            var input1 = document.getElementById('input1');
            var input2 = document.getElementById('input2');
            var input3 = document.getElementById('input3');
            var input4 = document.getElementById('input4');
            var dob = document.getElementById('dob');
            var address = document.getElementById('address');
            var gender = document.getElementById('gender');
            var status = document.getElementById('status');
            var email = document.getElementById('email');
            var whatsapp = document.getElementById('whatsapp');
            var photo = document.getElementById('photo');
            

            if (employeeId) document.getElementById('review-employee-id').textContent = employeeId.value;
            if (nic) document.getElementById('review-nic').textContent = nic.value;
            if (name) document.getElementById('review-name').textContent = name.value;
            if (option1) document.getElementById('review-option1').textContent = option1.selectedOptions[0].text;
            if (option2) document.getElementById('review-option2').textContent = option2.selectedOptions[0].text;
            if (option3) document.getElementById('review-option3').textContent = option3.selectedOptions[0].text;
            if (option4) document.getElementById('review-option4').textContent = option4.selectedOptions[0].text;
            if (input1) document.getElementById('review-input1').textContent = input1.value;
            if (input2) document.getElementById('review-input2').textContent = input2.value;
            if (input3) document.getElementById('review-input3').textContent = input3.value;
            if (input4) document.getElementById('review-input4').textContent = input4.value;
            if (dob) document.getElementById('review-dob').textContent = dob.value;
            if (address) document.getElementById('review-address').textContent = address.value;
            if (gender) document.getElementById('review-gender').textContent = gender.selectedOptions[0].text;
            if (status) document.getElementById('review-status').textContent = status.selectedOptions[0].text;
            if (email) document.getElementById('review-email').textContent = email.value;
            if (whatsapp) document.getElementById('review-whatsapp').textContent = whatsapp.value;

            if (photo && photo.files && photo.files[0]) {
                var reader = new FileReader();
                var thumbnail = document.getElementById('review-photo-thumbnail');
                
                reader.onload = function (e) {
                    thumbnail.src = e.target.result;
                    thumbnail.style.display = 'block';
                    console.log('Photo preview loaded successfully.');
                };
    
                reader.readAsDataURL(photo.files[0]);
            } else {
                console.warn('No photo uploaded or photo element is missing.');
            }
        }
    }

    function previousStep(step) {
        console.log(`Returning to step: ${step}`);
        
        document.querySelectorAll('.form-step').forEach(function (stepDiv) {
            stepDiv.classList.remove('active');
        });

        document.getElementById('step-' + step).classList.add('active');
    }

    function previewPhoto() {
        console.log('Previewing photo.');
        
        var photo = document.getElementById('photo');
        var thumbnail = document.getElementById('photo-thumbnail');

        if (photo && photo.files && photo.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                thumbnail.src = e.target.result;
                thumbnail.style.display = 'block';
                console.log('Photo thumbnail displayed successfully.');
            };
    
            reader.readAsDataURL(photo.files[0]);
        } else {
            console.warn('No photo selected or photo element is missing.');
        }
    }

    function submitForm() {
        console.log('Form submission initiated.');
        alert('Form submitted!');
    }

    window.nextStep = nextStep;
    window.previousStep = previousStep;
    window.previewPhoto = previewPhoto;
    window.submitForm = submitForm;
});
