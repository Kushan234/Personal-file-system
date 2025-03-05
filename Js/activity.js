const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const subButton = document.querySelector('.btn-submit');
const steps = document.querySelectorAll('.step');
const form_steps = document.querySelectorAll('.form-step');
let active = 1;

prevButton.style.display = 'none';
subButton.style.display = 'none';

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
    steps.forEach((step, i) => {
        if (i === (active - 1)) {
            step.classList.add('active');
            form_steps[i].classList.add('active');
        } else {
            step.classList.remove('active');
            form_steps[i].classList.remove('active');
        }
    });

    

    if (active === 1) {
        prevButton.style.display = 'none';
        nextButton.style.display = 'inline-block'; 
        subButton.style.display = 'none';  
    } else if (active === steps.length) {
        nextButton.style.display = 'none'; 
        prevButton.style.display = 'inline-block'; 
        prevButton.disabled = false; 
        subButton.style.display = 'inline-block';  
        subButton.disabled = false; 
    } else {
        prevButton.style.display = 'inline-block';  
        nextButton.style.display = 'inline-block';  
        subButton.style.display = 'none';  
        prevButton.disabled = false; 
        nextButton.disabled = false; 
    }
};

updateprogress();