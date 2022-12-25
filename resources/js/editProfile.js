document.getElementById('btn-updateProfile').addEventListener('click', function() {
    
    let input = {
        name: document.getElementById('edit-name'),
        email: document.getElementById('edit-email'),
        updateProfilleBtn: document.getElementById('btn-updateProfile')
    }

    let span = {
        name: document.getElementById('span-name'),
        email: document.getElementById('span-email'),
        successMessage: document.querySelector('.successMessage')
    }

    let formUpdateProfile = document.querySelector('#formEditUser')

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

    if(
        input.name.value.length > 2 &&
        validateEmail(input.email.value)
    ) {
        span.successMessage.style.display = 'block'
        window.setTimeout(function(){ formUpdateProfile.submit() }, 1500)
    }
})

document.getElementById('btn-updatePassword').addEventListener('click', function() {
    let inputPassword = document.getElementById('edit-password')
    let spanPassword = document.getElementById('span-password')

    let formUpdatePassword = document.querySelector('#formUpdatePassword')

    if(inputPassword.value.length < 6 && inputPassword.value !== '') {
        spanPassword.style.visibility = 'visible'
    } else {
        spanPassword.style.visibility = 'hidden'
    }

    if(inputPassword.value.length > 5) {
        document.getElementById('btn-updatePassword').setAttribute('disabled', 1)
        formUpdatePassword.submit()
    }
})

function validateEmail(input) {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return input.match(validRegex)
}
