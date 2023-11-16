<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<?php if (isset($usuario["profile_image"]) && isset($usuario["url"])): ?>
			<img class="img_wiki" src="<?=$usuario["url"]?>">
		<?php else: ?>
			<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
		<?php endif; ?>
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Perfil</h2></div>
		<div class="tituloInfoForm"></div>
		<?php
		if (esc($error)) {
			echo "<div class='error'>".esc($msg)."</div>";
		}
		?>
		<div class="datos">
			<div>
				<label>Nickname : </label>
				<input class="dato" type="text"
				       value='<?php echo $usuario["nickname"]; ?>'
				       placeholder="Nick"
				       name="nick" id="nick" readonly>
			</div>
			<div>
				<label>Nombre : </label>
				<input class="dato" type="text" value='<?php echo $usuario["nombre"]; ?>'
				       placeholder="Nombre" name="nombre" id="nombre" readonly>
			</div>
			<div>
				<label>Apellidos : </label>
				<input class="dato" type="text"
				       value='<?php echo $usuario["apellido1"]." ".$usuario["apellido2"]; ?>'
				       placeholder="Apellido 1" name="apellido1" id="apellido1" readonly>

			</div>
			<div>
				<label>Edad : </label>
				<input class="dato" type="number" value="<?php echo $usuario["edad"]; ?>" placeholder="edad"
				       id="edad"
				       name="edad" min="7" readonly>
			</div>
		</div>
		<br>
		<form class="datos" action="http://localhost/denunciarUsuario" method="post">
			<div class="botones">
				<input name="usuario" type="hidden" value="<?=$usuario['nickname'];?>">
				<input name="id" type="hidden" value="<?=$usuario['id'];?>">
				<input class="boton" type="submit" name="update" value="Denunciar"
				       onclick="return confirm('¿Realmente desea denunciar este Usuario?');">
			</div>
		</form>
		<form class="datos" action="http://localhost/bloquearUsuario" method="post">
			<div class="botones">
				<input name="id" type="hidden" value="<?=$usuario['id'];?>">
				<input class="boton" type="submit" name="update" value="Bloquear"
				       onclick="return confirm('¿Realmente desea bloquear este Usuario?');">
			</div>
		</form>
	</div>
</div>
