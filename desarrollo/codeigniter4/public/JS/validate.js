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
}


// Agrega un evento de cambio al campo "Repite la contraseña"
repitePasswordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const repitePassword = repitePasswordInput.value;

    // Comprueba si las contraseñas coinciden
    if (password === repitePassword) {
        passwordMatchError.textContent = ''; // Las contraseñas coinciden, borra cualquier mensaje de error
    } else {
        passwordMatchError.textContent = 'Las contraseñas no coinciden'; // Muestra un mensaje de error
    }
});

