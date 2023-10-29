<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
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
		<form method="get" action="http://localhost/perfil">
			<input class="back_boton" name="menus" type="submit" value="VOLVER">
		</form>
		<form class="contrasenias" action="http://localhost/updatePassword" method="post">
			<input class="dato" type="hidden" value='<?php echo $_SESSION["user"]["id"]; ?>' name="id" readonly>
			<input class="dato" type="password" placeholder="Contraseña actual" id="oldPassword"
			       name="oldPassword" required>
			<input class="dato" id="password" type="password" name="password"
			       placeholder="Nueva contraseña Minimo 6 caracteres"
			       onblur="validatePassword('password')" onchange="validatePassword('password')" required>
			<input class="dato" id="repitePassword" type="password" name="repitePassword"
			       placeholder="Repite la contraseña" required>
			<br>
			<span id="passwordMatchError" style="color: red;"></span>
			<br>
			<div style="position: relative; left: 100%">
				<input class="boton" type="submit" name="updatePassword" value="Cambiar contraseña">
			</div>
		</form>
	</div>
</div>
