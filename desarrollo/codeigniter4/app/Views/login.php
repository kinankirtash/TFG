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
			<input class="formulario" id="nick" type="text" name="nick" placeholder="Nickname">
			<input class="formulario" id="contrasenia" type="password" name="password" placeholder="Password">
			<input type="submit" id="enviar" class="enviar" value="login" name="logueo">
		</form>
	</div>
</div>