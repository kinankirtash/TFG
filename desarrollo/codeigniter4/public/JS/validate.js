const email = document.getElementById('email');
const phone = document.getElementById('tlf');
const password = document.getElementById('password');
const repitePasswordInput = document.getElementById('repitePassword');
const passwordMatchError = document.getElementById('passwordMatchError');
const currentUrl = window.location.href;
const currentDir = currentUrl.substring(0, currentUrl.lastIndexOf('/'));
const phpAdmin = currentDir + "/APP/php/config.php";
console.log(phpAdmin)

function validateEmail() {
    let validEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
    let emailInput = document.getElementById('email');

    if (emailInput.value != "") {
        if (!validEmail.test(emailInput.value)) {
            alert('El email no es válido.');
            emailInput.value = "";
        }
    }
}

function validateTlf() {
    let validPhone = /^(\+?\d{1,2})?(\d{10})$/;
    let phoneInput = document.getElementById('tlf');

    if (phoneInput.value != "") {
        if (!validPhone.test(phoneInput.value)) {
            alert('El número de teléfono no es válido.');
            phoneInput.value = "";
        }
    }
}

function addPrefixNumber() {
    if (!phone.value.match(/\+/)) {
        phone.value = "+" + phone.value;
    }
}

function validatePassword(passwordField) {
    let validPassword = /^(?=.*[a-zA-Z])(?=.*\d).{6,}$/;
    let passwordInput = document.getElementById(passwordField);

    if (!validPassword.test(passwordInput.value)) {
        alert('La contraseña debe contener al menos una letra, un número y tener un mínimo de 6 caracteres.');
        passwordInput.value = "";
    }
    // Agrega un evento de cambio al campo "Repite la contraseña"
    repitePasswordInput.addEventListener('input', () => {
        const password = document.getElementById(passwordField).value;
        const repitePassword = repitePasswordInput.value;

        // Comprueba si las contraseñas coinciden
        if (password === repitePassword) {
            passwordMatchError.textContent = ''; // Las contraseñas coinciden, borra cualquier mensaje de error
        } else {
            passwordMatchError.textContent = 'Las contraseñas no coinciden'; // Muestra un mensaje de error
        }
    });
}

// Obtén una referencia al botón
var botonMostrarOcultarVentana = document.getElementById("botonMostrarVentana");
var ventanaFlotante = document.getElementById("mensajeFlotante");

// Agrega un controlador de eventos al botón para alternar la ventana flotante
botonMostrarOcultarVentana.addEventListener("click", function () {
    if (ventanaFlotante.style.display === "flex") {
        ventanaFlotante.style.display = "none"; // Oculta la ventana flotante
    } else {
        ventanaFlotante.style.display = "flex"; // Muestra la ventana flotante
    }
});

/*
function enviarMensaje(event) {
    event.preventDefault(); // Prevenir la recarga de la página por defecto

    // Obtener el mensaje del formulario
    var mensaje = document.getElementById("mensaje").value;

    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append("mensaje", mensaje);

    // Realizar la solicitud AJAX
    fetch("/guardarmensajes", {
        method: "POST",
        body: formData,
    })
        .then(function (response) {
            if (response.ok) {
                // La solicitud fue exitosa
                // Puedes mostrar un mensaje de éxito o realizar alguna otra acción
                alert("Mensaje enviado con éxito");
            } else {
                // La solicitud no fue exitosa
                // Puedes mostrar un mensaje de error o realizar alguna otra acción
                alert("Error al enviar el mensaje");
            }
        })
        .catch(function (error) {
            // Manejar errores de red u otros
            alert("Error al enviar el mensaje: " + error);
        });
}
*/


