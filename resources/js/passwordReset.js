document.getElementById('btn-updatePassword').addEventListener('click', function() {
    
    let input = {
        password: document.getElementById('new-password'),
        confirmPassword: document.getElementById('confirm-password')
    }

    let span = {
        password: document.getElementById('span-password'),
        confirmPassword: document.getElementById('span-confirmPassword')
    }

    let formUpdatePassword = document.querySelector('form')

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
        input.password.value.length > 5 &&
        input.password.value === input.confirmPassword.value
    ) {
        formUpdatePassword.submit()
    }
})
