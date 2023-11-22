<div class="fondo_blanco">
	<h1 class="titulo_pagina">Login</h1>
	<br>
	<?php
	if (esc($error)) {
		echo "<div class='error'>".esc($msg)."</div>";
	}
	?>
	<br>
	<div class="modal-content">
		<form id="inicio_Sesion" class="formulario_sesion" method="post">
			<input class="formulario" id="email" type="email" name="email" placeholder="tuemail@email.com"
			       onchange="validateEmail()" required>
			<input type="submit" id="enviar" class="enviar" value="Enviar" name="enviarCorreo">
		</form>
	</div>
</div>