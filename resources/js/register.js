document.getElementById('btn-register').addEventListener('click', function() {
    
    let input = {
        name: document.getElementById('register-name'),
        email: document.getElementById('register-email'),
        password: document.getElementById('register-password'),
        confirmPassword: document.getElementById('confirm-password'),
        register: document.getElementById('btn-register')
    }

    let span = {
        name: document.getElementById('span-name'),
        email: document.getElementById('span-email'),
        password: document.getElementById('span-password'),
        confirmPassword: document.getElementById('span-confirmPassword')
    }

    let formResgister = document.querySelector('form')

    if(input.name.value.length < 3) {
        span.name.style.visibility = 'visible'
    } else {
        span.name.style.visibility = 'hidden'
    }

    if(!validateEmail(input.email.value)) {
        span.email.style.visibility = 'visible'
    } else {
        span.email.style.visibility = 'hidden'
    }

    if(input.password.value.length < 6) {
        span.password.style.visibility = 'visible'
    } else {
        span.password.style.visibility = 'hidden'
    }

    if(input.confirmPassword.value !== input.password.value) {
        span.confirmPassword.style.visibility = 'visible'
    } else {
        span.confirmPassword.style.visibility = 'hidden'
    }

    if(
        input.name.value.length > 2 &&
        validateEmail(input.email.value) &&
        input.password.value.length > 5 &&
        input.password.value === input.confirmPassword.value
    ) {
        formResgister.submit()
    }
})

function validateEmail(input) {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    return input.match(validRegex)
}
