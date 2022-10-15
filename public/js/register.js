let nameInput = document.getElementById('register-name').value
let emailInput = document.getElementById('register-email').value
let passwordInput = document.getElementById('register-password').value
let confirmPasswordInput = document.getElementById('confirm-password').value
let registerButton = document.getElementById('btn-register')



function check() {
    while(
        nameInput.length > 3 &&
        emailInput.length > 0 &&
        passwordInput.length > 5 &&
        confirmPasswordInput.length > 5
    ) {
        registerButton.style.backgroundColor = 'blue'
    }
}