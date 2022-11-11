import switchModal from "./modal";

// Button to open modal

const buttonModal = document.querySelector('#buttonModal')
const containerModal = document.querySelector('#idModal')

buttonModal.addEventListener('click', function() {
    switchModal(containerModal)
})

// Copy button
const copyButton = document.querySelector('#copyButton')
const shortenedUrl = document.querySelector('#shortenedUrl')

copyButton.addEventListener('click', function() {
    if(shortenedUrl.value.length > 0) {
        let copyText = document.querySelector("#shortenedUrl")

        copyText.select();
        copyText.setSelectionRange(0, 99999)

        navigator.clipboard.writeText(copyText.value)

        copyButton.innerHTML = 'copied!'
        copyButton.style.backgroundColor = 'white'
        copyButton.style.color = 'black'
    }
})

// additional functions
const destinationUrl = document.querySelector('#destinationUrl')
const generateUrlButton = document.querySelector('#generateUrlButton')

const check = () => {
    console.log('abcd')
    if(destinationUrl.value.length > 0) {
        generateUrlButton.removeAttribute('disabled')
    }
}
// function enableOrDisableButton(button) {
//     if(button.hasAttribute('disabled')) {
//         button.removeAttribute('disabled')
//     } else {
//         button.setAttribute('disabled')
//     }
// }