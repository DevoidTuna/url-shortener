import switchModal from "./modal";

/* 
|   Set var, let and const
*/
const button = {
    modal: document.querySelector('#buttonModal'),
    close: document.querySelectorAll('.closeButton'),
    copy: document.querySelector('#copyButton'),
    generateUrl: document.querySelector('#generateUrlButton'),
}
const field = {
    generateUrl: document.querySelector('#generateUrl'),
    shortenedUrl: document.querySelector('.field-shortenedUrl'),
}
const container = {
    modal: document.querySelector('#idModal'),
}
const input = {
    destinationUrl: document.querySelector('#destinationUrl'),
    shortenedUrl: document.querySelector('#shortenedUrl'),
}

/* 
|   Button to open modal
*/
button.modal.addEventListener('click', function () {
    switchModal(container.modal)
    if(container.modal.style.display == 'flex') {
        field.generateUrl.style.display = 'block'
        field.shortenedUrl.style.display = 'none'
    }

})

button.close.forEach(button => button.addEventListener('click', function () {
    switchModal(container.modal)
    if(container.modal.style.display == 'flex') {
        field.generateUrl.style.display = 'block'
        field.shortenedUrl.style.display = 'none'
    }
}))


/* 
|   Clear the inputs to new URL
*/
function resetModal() {

}


/* 
|   Copy button
*/
button.copy.addEventListener('click', function () {

    input.shortenedUrl.select();
    input.shortenedUrl.setSelectionRange(0, 99999)

    navigator.clipboard.writeText(input.shortenedUrl.value)

    button.copy.innerHTML = 'copied!'
    button.copy.style.backgroundColor = 'white'
    button.copy.style.color = 'black'
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
|   button.generateUrl hides the creation screen and returns the 
|   field-shortenedUrl
*/
button.generateUrl.addEventListener('click', function () {
    field.generateUrl.style.display = 'none'
    field.shortenedUrl.style.display = 'block'
})


/* 
|   Validade URL
|   checking later this function to insert in program
*/
function isValidUrl (urlString) {
    var urlPattern = new RegExp('^(https?:\\/\\/)?'+ // validate protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // validate domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // validate OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // validate port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // validate query string
    '(\\#[-a-z\\d_]*)?$','i'); // validate fragment locator
    return !!urlPattern.test(urlString);
}

