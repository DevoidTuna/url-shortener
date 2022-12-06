document.getElementById('btn-updateProfile').addEventListener('click', function() {
    
    let input = {
        name: document.getElementById('edit-name'),
        email: document.getElementById('edit-email'),
        password: document.getElementById('edit-password'),
        updateProfilleBtn: document.getElementById('btn-updateProfile')
    }

    let span = {
        name: document.getElementById('span-name'),
        email: document.getElementById('span-email'),
        password: document.getElementById('span-password'),
        successMessage: document.querySelector('.successMessage')
    }

    let formUpdateProfile = document.querySelector('form')

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

    if(input.password.value.length < 6 && input.password.value !== '') {
        span.password.style.visibility = 'visible'
    } else {
        span.password.style.visibility = 'hidden'
    }

    if(
        input.name.value.length > 2 &&
        validateEmail(input.email.value) &&
        (input.password.value.length > 5 ||
        input.password.value === '')
    ) {
        span.successMessage.style.display = 'block'
        
        window.setTimeout(function(){ formUpdateProfile.submit() }, 1500)
    }
})

function validateEmail(input) {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    return input.match(validRegex)
}
