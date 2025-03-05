document.addEventListener('DOMContentLoaded', () => {
    const employeeIdInput = document.getElementById('employee-id');
    const nextButton = document.querySelector('.btn-next'); 


    nextButton.disabled = true;

    function checkEmployeeId(employeeId) {
        return fetch(`php/valid.php?employee-id=${encodeURIComponent(employeeId)}`)
            .then(response => response.json());
    }

  
    function updateNextButtonState(isValid) {
        nextButton.disabled = !isValid; 
    }

   
    employeeIdInput.addEventListener('input', () => {
        const employeeId = employeeIdInput.value.trim();

       
        if (employeeId.length === 0) {
            employeeIdInput.style.borderColor = ''; 
            updateNextButtonState(false); 
            return; 
        }

        
        checkEmployeeId(employeeId)
            .then(data => {
                const errorMessage = document.getElementById('error-message');
                
                if (data.exists) {
                    employeeIdInput.style.borderColor = 'blue'; 
                    errorMessage.style.display = 'none';
                    updateNextButtonState(true); 
                } else {
                    employeeIdInput.style.borderColor = 'red'; 
                    errorMessage.style.display = 'block';
                    errorMessage.style.color = 'red';
                    errorMessage.textContent = 'ID not found';
                    updateNextButtonState(false); 
                }
            })
            .catch(error => {
                console.error('Error checking employee ID:', error);
                alert('An error occurred while checking the Employee ID');
                updateNextButtonState(false); 
            });
        });

    
    employeeIdInput.addEventListener('mousedown', () => {
        const employeeId = employeeIdInput.value.trim();

     t
        if (employeeId.length > 0) {
            checkEmployeeId(employeeId)
                .then(data => {
                    if (!data.exists) {
                        employeeIdInput.style.borderColor = 'red'; 
                        updateNextButtonState(false); 
                    } else {
                        employeeIdInput.style.borderColor = 'green'; 
                        updateNextButtonState(true); 
                    }
                });
        }
    });
});