function check() {
    var input = {
        name: document.getElementById('register-name'),
        email: document.getElementById('register-email'),
        password: document.getElementById('register-password'),
        confirmPassword: document.getElementById('confirm-password'),
        register: document.getElementById('btn-register')
    }

    var span = {
        name: document.getElementById('span-name'),
        email: document.getElementById('span-email'),
        password: document.getElementById('span-password'),
        confirmPassword: document.getElementById('span-confirmPassword')
    }

    var form = document.querySelector('#form-register')

    //     if(input.email.value.length > 1) {
    //         span.email.style.visibility = 'visible'
    //     } else {
    //         span.email.style.visibility = 'hidden'
    //     }

    //     if(input.password.value.length < 6) {
    //         span.password.style.visibility = 'visible'
    //     } else {
    //         span.password.style.visibility = 'hidden'
    //     }

    //     if(input.confirmPassword.value !== input.password.value) {
    //         span.confirmPassword.style.visibility = 'visible'
    //     } else {
    //         span.confirmPassword.style.visibility = 'hidden'
    //     }

    //     if(
    //         input.name.value.length > 2 &&
    //         // validateEmail(input.email.value) &&
    //         input.confirmPassword.value === input.password.value
    //     ) {
    //         form.submit()
    //     }
    // })

    // function validateEmail(input) {

    // var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  
    // // if (input.value.match(validRegex)) {
    // //   return true;
    // // } else {
    // //   return false;
    // // }
    // input.value.match(validRegex) ?  true : false
    // }
}

input.register.addEventListener('click', function() {

    console.log(
        input.name,          
        input.email,
        input.password,
        input.confirmPassword
    )
})