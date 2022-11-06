const container = document.querySelector('.container')

export default function switchModal(container) {
    if(container.style.display == 'flex') {
        container.style.display = 'none'
    } else {
        container.style.display = 'flex'
    }
}

window.onclick = function(event) {
    if(event.target == container) {
        switchModal(container)
    }
}
