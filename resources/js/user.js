import switchModal from "./modal";

/* 
|   Set var and const
*/
const button = {
    openModalCreateUrl: document.querySelector('#buttonModal'),
    closeModalCreateUrl: document.querySelector('.closeModalButton'),
    copyShortUrl: document.querySelectorAll('.button-copyUrl'),
    generateUrl: document.querySelector('#generateUrlButton'),
}
const container = {
    modalCreateUrl: document.querySelector('#modalCreateUrl'),
}
const input = {
    destinationUrl: document.querySelector('#destinationUrl'),
    nameUrl: document.querySelector('#nameUrl'),
    radioVisibilityPublic: document.querySelector('#visibility-public'),
    radioAvaliableTime_NoExpiration: document.querySelector('#avaliableTime-noExpiration'),
}


/* 
|   Button to open modal
*/
button.openModalCreateUrl.addEventListener('click', function () {
    resetInputsCreateUrl()
    switchModal(container.modalCreateUrl)

})

button.closeModalCreateUrl.addEventListener('click', function () {
    resetInputsCreateUrl()
    switchModal(container.modalCreateUrl)
})


/* 
|   Enable/disable button Generate URL
*/
input.destinationUrl.addEventListener('input', function () {
    if (input.destinationUrl.value.length > 0) {
        button.generateUrl.removeAttribute('disabled')
    } else {
        button.generateUrl.setAttribute('disabled', 1)
    }
})


/* 
|   Function to reset the inputs of creation URL
*/
function resetInputsCreateUrl() {
    input.radioVisibilityPublic.checked = 'true'
    input.radioAvaliableTime_NoExpiration.checked = 'true'
    input.nameUrl.value = ''
    input.destinationUrl.value = ''
    button.generateUrl.setAttribute('disabled', 1)
}


/* 
|   Validade URL
|   checking later this function to insert in program
*/
function isValidUrl (urlString) {
    var urlPattern = new RegExp('((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // validate domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // validate OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // validate port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // validate query string
    '(\\#[-a-z\\d_]*)?$','i'); // validate fragment locator
    return !!urlPattern.test(urlString);
}


/* 
|   Function to copy button work
*/

const field = document.querySelectorAll('div.field-shortened-url > button')

for (let i = 0; i < field.length; i++) {
    let url = document.querySelectorAll('.goToUrl')

    button.copyShortUrl[i].addEventListener('click', function() {
        navigator.clipboard.writeText(url[i].getAttribute('value')).then(
            () => {
                field[i].style.backgroundColor = 'white'
                window.setTimeout(function(){ field[i].style.backgroundColor = '#ff5100' }, 1000)
            },
            () => {
                console.log("can't copy the url")
            })})
}
