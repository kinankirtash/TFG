<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<?php if (isset($_SESSION["user"]["profile_image"]) && isset($_SESSION["user"]["url"])): ?>
			<img class="img_wiki" src="<?=$_SESSION["user"]["url"]?>">
		<?php else: ?>
			<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
		<?php endif; ?>
		<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nickname"]; ?>'
		       placeholder="Nick"
		       name="nick" id="nick" readonly>
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Perfil</h2></div>
		<div class="tituloInfoForm"></div>
		<?php
		if (esc($error)) {
			echo "<div class='error'>".esc($msg)."</div>";
		}
		?>
		<form class="datos" action="/delete" method="post">
			<input class="dato" type="hidden" value='<?php echo $_SESSION["user"]["id"]; ?>' name="id" readonly>
			<input class="dato" id="password" type="password" name="password"
			       placeholder="Contraseña"
			       onblur="validatePassword('password')" onchange="validatePassword('password')" required>
			<input class="dato" id="repitePassword" type="password" name="repitePassword"
			       placeholder="Repite la contraseña" required>
			<br>
			<span id="passwordMatchError" style="color: red;"></span>
			<br>
			<div style="position: relative;">
				<input class="boton" type="submit" name="deleteUser" value="Eliminar cuenta">
			</div>
		</form>
	</div>
</div>
