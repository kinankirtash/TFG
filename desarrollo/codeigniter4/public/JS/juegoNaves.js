var canvas;
var ctx;
var naveX = 0;
var naveY = 0;
var nave = new Image();
var fondoNave = new Image();
var puntuacion = 0; // Variable para el sistema de puntuación
var estrellaDetectada = false; // Variable para evitar la detección repetida de estrellas
var puntosEstrella = 1; // Cantidad fija de puntos por colisión con estrella
var demoraEstrella = false; // Variable para controlar la demora
var stop;

function canvasFondo() {
    canvas = document.getElementById('dibujo');
    if (!canvas) {
        return
    }
    ;
    ctx = canvas.getContext('2d');
    pintarFondo();
    pintarNave();
    pintarBase();
    pintarEstrellas();
    pintarAsteroides();
    window.addEventListener('keydown', moverNave, true);
    temporizador();
}

document.addEventListener("DOMContentLoaded", function () {
    canvasFondo();
});

function pintarFondo() {
    ctx.fillStyle = "black";
    ctx.beginPath();
    ctx.rect(0, 0, 990, 600);
    ctx.closePath();
    ctx.fill();

    puntuacion = 0; // Reiniciar la puntuación
    fondoNave = ctx.getImageData(0, 0, 30, 30);
}

function pintarNave() {
    ctx.fillStyle = "#FFC0CB";
    ctx.beginPath();
    ctx.rect(0, 0, 25, 15);
    ctx.closePath();
    ctx.fill();
    nave = ctx.getImageData(0, 0, 25, 15);
}

function pintarBase() {
    ctx.fillStyle = "#800080";
    ctx.beginPath();
    ctx.rect(960, 570, 30, 30);
    ctx.closePath();
    ctx.fill();
}

function pintarEstrellas() {
    for (var i = 0; i < 100; i++) {
        var x = Math.random() * 960; // Ajustar límite izquierdo
        var y = Math.random() * 570; // Ajustar límite superior
        ctx.fillStyle = "white";
        ctx.beginPath();
        ctx.arc(x, y, 3, 0, Math.PI * 2);
        ctx.closePath();
        ctx.fill();
    }
}

function pintarAsteroides() {
    for (var i = 0; i < 30; i++) {
        var x = Math.random() * 960;
        var y = Math.random() * 570;

        if (x < 30 && y < 30) {
            x = x + 30;
            y = y + 30;
        }
        if (x > 960 && y > 570) {
            x = x - 30;
            y = y - 30;
        }
        ctx.fillStyle = "#D4AF37";
        ctx.beginPath();
        ctx.rect(x, y, 30, 30);
        ctx.closePath();
        ctx.fill();
    }
}

function moverNave(evento) {
    switch (evento.keyCode) {
        case 37:
        case 65:
            if (naveX == 0) {
                break;
            }
            // Borrar la nave (para ello, hay que pintar fondo encima)
            ctx.putImageData(fondoNave, naveX, naveY);
            naveX = naveX - 30;
            fondoNave = ctx.getImageData(naveX, naveY, 30, 30);
            ctx.putImageData(nave, naveX, naveY);
            if (!estrellaDetectada && !demoraEstrella) {
                detectarColision();
                estrellaDetectada = true; // Establecer a true para evitar la detección repetida de estrellas
                demoraEstrella = true; // Establecer a true para activar la demora
                setTimeout(function () {
                    demoraEstrella = false; // Restablecer la demora después de un tiempo
                }, 1000); // Establecer el tiempo de demora en milisegundos (1 segundos)
            }
            break;

        case 39:
        case 68:
            if (naveX == 960) {
                break;
            }
            ctx.putImageData(fondoNave, naveX, naveY);
            naveX = naveX + 30;
            fondoNave = ctx.getImageData(naveX, naveY, 30, 30);
            ctx.putImageData(nave, naveX, naveY);
            if (!estrellaDetectada && !demoraEstrella) {
                detectarColision();
                estrellaDetectada = true;
                demoraEstrella = true;
                setTimeout(function () {
                    demoraEstrella = false;
                }, 1000);
            }
            break;


        case 38:
        case 87:
            if (naveY == 0) {
                break;
            }
            ctx.putImageData(fondoNave, naveX, naveY);
            naveY = naveY - 30;
            fondoNave = ctx.getImageData(naveX, naveY, 30, 30);
            ctx.putImageData(nave, naveX, naveY);
            if (!estrellaDetectada && !demoraEstrella) {
                detectarColision();
                estrellaDetectada = true; // Establecer a true para evitar la detección repetida de estrellas
                demoraEstrella = true; // Establecer a true para activar la demora
                setTimeout(function () {
                    demoraEstrella = false; // Restablecer la demora después de un tiempo
                }, 1000); // Establecer el tiempo de demora en milisegundos (1 segundos)
            }
            break;

        case 40:
        case 83:
            if (naveY == 570) {
                break;
            }
            // Borrar la nave (para ello, hay que pintar fondo encima)
            ctx.putImageData(fondoNave, naveX, naveY);
            naveY = naveY + 30;
            fondoNave = ctx.getImageData(naveX, naveY, 30, 30);
            ctx.putImageData(nave, naveX, naveY);
            if (!estrellaDetectada && !demoraEstrella) {
                detectarColision();
                estrellaDetectada = true; // Establecer a true para evitar la detección repetida de estrellas
                demoraEstrella = true; // Establecer a true para activar la demora
                setTimeout(function () {
                    demoraEstrella = false; // Restablecer la demora después de un tiempo
                }, 1000); // Establecer el tiempo de demora en milisegundos (1 segundos)
            }
            break;
    }
    detectarColision();
}

function detectarColision() {
    var pixel = 900;
    var elementos = 900 * 4;
    var estrellasDetectadas = {}; // Objeto para llevar un seguimiento de estrellas detectadas

    for (var i = 0; i < elementos; i += 4) {
        var r = fondoNave.data[i]; // Componente rojo del color del píxel
        var g = fondoNave.data[i + 1]; // Componente verde del color del píxel
        var b = fondoNave.data[i + 2]; // Componente azul del color del píxel

        if (r == 212 && g == 175 && b == 55) {
            var spanPuntuacion = document.getElementById('puntuacion');
            spanPuntuacion.innerHTML = 0;
            var mensaje = "Has chocado con un asteroide. Pulsa AQUI para reintentar";
            var victoria = false;
            finalizar(victoria, mensaje);
            break;
        }

        if (r == 255 && g == 255 && b == 255) {
            // Colisión con una estrella (color blanco)
            var estrellaIndex = i / 4; // Índice de la estrella basado en los datos del píxel
            if (!estrellasDetectadas[estrellaIndex]) {
                // Si la estrella no ha sido detectada previamente, suma los puntos
                estrellasDetectadas[estrellaIndex] = true;
                puntuacion += puntosEstrella; // Sumar 10 puntos por estrella
                var spanPuntuacion = document.getElementById('puntuacion');
                spanPuntuacion.innerHTML = puntuacion;
            }
        }

        if (r == 128 && g == 0 && b == 128) {
            var victoria = true;
            var mensaje = "Felicidades has llegado. Pulsa AQUI para volver a jugar";
            finalizar(victoria, mensaje);
            break;
        }
    }
}

function finalizar(victoria, mensaje) {
    var spanMensaje = document.getElementById("mensaje");
    if (victoria) {
        spanMensaje.style.color = "green";
    } else {
        spanMensaje.style.color = "red";
    }
    spanMensaje.innerHTML = mensaje;
    window.removeEventListener("keydown", moverNave, true);
    clearTimeout(stop);
}

function temporizador() {
    var spanTiempo = document.getElementById('tiempo');
    var tiempoActual = parseInt(spanTiempo.innerHTML);

    if (tiempoActual <= 0) {
        var mensaje = "Se ha acabado el tiempo. Pulsa AQUI para reintentar";
        var victoria = false;
        finalizar(victoria, mensaje);
    } else {
        tiempoActual--;
        spanTiempo.innerHTML = tiempoActual;

        if (tiempoActual < 11) {
            spanTiempo.style.color = 'orange';
        } else if (tiempoActual < 6) {
            spanTiempo.style.color = 'red';
        } else {
            spanTiempo.style.color = '#0f0';
        }

        stop = setTimeout(temporizador, 1000);
    }
}


function rellenarCero(numero) {
    if (numero < 10) {
        return "0" + numero;
    } else {
        return numero;
    }
}

//reiniciar el juego
function reiniciar() {
    window.location.reload();
}