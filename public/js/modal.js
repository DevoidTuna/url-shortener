const modal = document.querySelector('.modal')
const content = document.querySelector('.content')
const container = document.querySelector('.container')

const switchModal = () => {
    const actualStyle = container.style.display
    if(actualStyle == 'flex') {
        container.style.display = 'none'
    }
    else {
        container.style.display = 'flex'
    }
}
  
document.querySelector('#modalChangeBtn').addEventListener('click', switchModal)

window.onclick = function(event) {
    if (event.target == container) {
        switchModal()
    }
}
