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

    form_steps.forEach((formStep, i) => {
        if (i === (active - 1)) {
            formStep.style.display = 'block'; 
        } else {
            formStep.style.display = 'none'; 
        }
    });

    if (active === 1) {
        prevButton.disabled = true;
    
    } else if (active === steps.length) {
        nextButton.disabled = true;
        

    } else {
        prevButton.disabled = false;
        nextButton.disabled = false;
    }
}
function previewPhoto() {
    var file = document.getElementById('photo').files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        var photoThumbnail = document.getElementById('photo-thumbnail');
        photoThumbnail.src = e.target.result;
        photoThumbnail.style.display = 'block';
        photoThumbnail.style.width = '150px';  
        photoThumbnail.style.height = '150px'; 
    };
    reader.readAsDataURL(file);
}
