const menuIcon = document.querySelector('.menu-icon');
const menu = document.querySelector('.menu');


menuIcon.addEventListener('click', () => {
    menu.classList.toggle('active');
});

function submitForm() {
    // Obtener el formulario padre del elemento clicado
    const form = event.target.closest('form');

    // Enviar el formulario si se encuentra
    if (form) {
        form.submit();
    }
}

