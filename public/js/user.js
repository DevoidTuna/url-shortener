import switchModal from "./modal";

window.onload = function() {

    const button = document.getElementById("teste")
    const backModal = document.getElementsByClassName('container')

    console.log(
        button.addEventListener('click', switchModal(backModal)),
        backModal.addEventListener('click', switchModal(backModal))
    )

}
