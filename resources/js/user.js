import switchModal from "./modal";

const buttonModal = document.querySelector('#buttonModal')
const containerModal = document.querySelector('#idModal')

buttonModal.addEventListener('click', function() {
    switchModal(containerModal)
})
