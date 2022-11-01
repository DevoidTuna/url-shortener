export default function switchModal(container) {
    const actualStyle = container.style.display
    if(actualStyle == 'flex') {
        container.style.display = 'none'
    } else {
        container.style.display = 'flex'
    }
}