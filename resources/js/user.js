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
const span = {
    destinationUrl: document.querySelector('#span-destinationUrl')
}
const form = {
    formCreateUrl: document.querySelector('#formCreateUrl')
}

if (button.openModalCreateUrl != null) {
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
    |   Enable/disable button Generate URL
    */
    button.generateUrl.addEventListener('click', function() {
        if(isValidUrl(input.destinationUrl.value) == false) {
            span.destinationUrl.style.display = 'inline-block'
        } else {
            span.destinationUrl.style.display = 'none'
            form.formCreateUrl.submit()
        }
    })
}

/* 
|   Function to reset the inputs of creation URL
*/
function resetInputsCreateUrl() {
    input.radioVisibilityPublic.checked = 'true'
    input.radioAvaliableTime_NoExpiration.checked = 'true'
    input.nameUrl.value = ''
    input.destinationUrl.value = ''
    button.generateUrl.setAttribute('disabled', 1)
    span.destinationUrl.style.display = 'none'
}

/* 
|   Validade URL
|   checking later this function to insert in program
*/
const isValidUrl = urlString=> {
    var urlPattern = new RegExp('^(https?:\\/\\/)?'+ 
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ 
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ 
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ 
    '(\\?[;&a-z\\d%_.~+=-]*)?'+  
    '(\\#[-a-z\\d_]*)?$','i')
    return urlPattern.test(urlString);
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
                window.setTimeout(function(){ field[i].style.backgroundColor = '#ff5e00' }, 1000)
            },
            () => {
                console.log("can't copy the url")
            })})
}
