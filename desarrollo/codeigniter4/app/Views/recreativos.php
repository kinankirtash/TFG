<?php
if (! session("user")) {
	$data['error'] = false;

	return template('login', $data);
} else { ?>
	<div class="fondo_blanco">
	<div class="seccion_ayuda" style="width: 30%">
		<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
		<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nickname"]; ?>'
		       placeholder="Nick"
		       name="nick" id="nick" readonly>
	</div>
	<div class="seccion_principal" style="width: 70%">
		<div class="fondoNaves">
			<h1>STELLAR GAME</h1>
			<span id="mensaje" onclick="reiniciar()">Intenta llegar al punto azul, sin chocar</span>
			<br> puntuación: <span id="puntuacion">0</span> <br> tiempo: <span id="tiempo">50</span> <br>
		</div>
		<canvas id="dibujo" width="990" height="600"></canvas>
	</div>

<?php } ?>